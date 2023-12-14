<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Stock;
use App\Models\Venta;
use App\Models\VentaDetalles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FacturaController extends Controller
{
    public function index()
    {
        $categoria = Categoria::orderBy('name','asc')->get();
        $cliente = Cliente::orderBy('customer_name','asc')->get();

        return Inertia::render('Factura/Factura',[
            'categoria'=>$categoria,
            'cliente'=>$cliente
        ]);

    }


    public function getLastInvoice(){


        $invoice = Venta::orderBy('id','desc')->first();

        if($invoice){

            return $invoice->id + 1;
        }
        else{

            return 1;
        }

    }

    public function FacturaLista(Request $request){

        $factura = Venta::with([

            'cliente'=>function($query){

                $query->select('cliente_nombre','id');
            },

            'usuario'=>function($query){

                $query->select('nombre','id');
            }])
            ->orderBy('updated_at','desc');

        if($request->factura_id != ''){

            $factura->where('id','=',$request->factura_id);
        }

        if ($request->cliente_id != ''){

            $factura->where('customer_id','=',$request->cliente_id);
        }

        if ($request->start_date != '' && $request->end_date != ''){

            $factura->whereBetween('fecha_venta',[$request->start_date,$request->end_date]);
        }
        $factura = $factura->paginate(10);


        return $factura;
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {


        $request->validate([
            'tipo_cliente' => 'required',
            'cliente_id' => 'required_if:customer_type,1',
            'cliente_nombre' => 'required_if:customer_type,2',
            'cliente_email' => 'nullable|unique:customers,email',
            'cliente_telefono' => 'nullable|unique:customers,phone',
            'factura_fecha' => 'required',
            'importe_pago' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',


            'producto.*.categoria' => 'required',
            'producto.*.producto_id' => 'required',
            'producto.*.lista_id' => 'required',
            'producto.*.cantidad' => 'required|integer',
            'producto.*.precio' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'producto.*.precio_total' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'producto.*.descuento' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ],[

            'cliente_id.required_if' => 'required',
            'cliente_name.required_if' => 'required',

            'producto.*.categoria.required' => 'required field',
            'producto.*.producto_id.required' => 'required field',
            'producto.*.lista_id.required' => 'required field',
            'producto.*.cantidad.required' => 'required',
            'producto.*.cantidad.integer' => 'required',
            'producto.*.precio.required' => 'required',
            'producto.*.precio_total.required' => 'required',
            'producto.*.descuento.regex' => 'invalid format',
        ]);


        try{

            DB::beginTransaction();

            // Añadir cliente
            if($request->tipo_cliente == 1){

                $cliente_id = $request['cliente_id']['id'];
            }
            else{

                $cliente = new Cliente;
                $cliente->nombre_cliente = $request->nombre_cliente;
                $cliente->email = $request->cliente_email;
                $cliente->telefono = $request->cliente_telefono;
                $cliente->direccion = $request->cliente_direccion;

                $cliente->save();

                $cliente_id = $cliente->id;


            }
            //Factura

            $factura = new Venta;

            $factura->user_id = Auth::usuario()->id;
            $factura->cliente_id = $cliente_id;
            $factura->branch_id = Auth::usuario()->branch_id;
            $factura->importe_total = $request->totalidad;
            $factura->importe_descuento = $request->total_descuento;
            $factura->importe_pagado = $request->importe_pagado;
            $factura->fecha_venta = date("Y-m-d", strtotime($request->fecha_factura));
            $factura->metodo_pago = $request->info_pago == 'cash' ? 1 : 2;
            if($request->importe_pagado >= $request->totalidad){
                $factura->estado_pago = 1;
            }
            else{
                $factura->estado_pago = 0;
            }
            $factura->save();

            foreach ($request->producto as  $value) {

                $stock = Stock::find($value['lista_id']);

                $inv_details = new VentaDetalles;

                $inv_details->stock_id = $value['chalan_id'];
                $inv_details->venta_id = $factura->id;
                $inv_details->producto_id = $value['producto_id']['id'];
                $inv_details->category_id = $value['category']['id'];
                $inv_details->cliente_id = $cliente_id;
                $inv_details->proveedor_id = $stock->proveedor_id;
                $inv_details->usuario_id = Auth::user()->id;
                $inv_details->lista_no = $stock->lista_no;
                $inv_details->fecha_venta = date("Y-m-d", strtotime($request->fecha_factura));
                $inv_details->cantidad_vendida = $value['cantidad'];
                $inv_details->precio_compra = $stock->precio_compra ;
                $inv_details->precio_vendido = $value['precio'];
                $inv_details->total_precio_compra = $stock->precio_compra*$value['cantidad'];
                $inv_details->total_precio_vendido = $value['precio_total'];
                $inv_details->descuento = $value['descuento'];
                $inv_details->tipo_descuento = $value['tipo_descuento'];
                $inv_details->importe_descuento = $value['importe_descuento'];

                $inv_details->save();

                $stock->cantidad_actual = $stock->cantidad_actual - $value['cantidad'];

                $stock->update();



            }
            //Historial pago

            if($request->importe_pago > 0){

                $payment = new Pago;

                $payment->venta_id = $factura->id;
                $payment->cliente_id = $cliente_id;
                $payment->usuario_id = Auth::user()->id;
                $payment->fecha = date("Y-m-d", strtotime($request->fecha_factura));
                $payment->pago_in = $request->pago_in;
                $payment->banco_informacion = $request->banco_info;
                $payment->importe = $request->impoprte_pagadot;
                $payment->save();

            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => '¡Factura creada!']);
        }
        catch(\Exception $e){

            DB::rollback();
            return $e;
            //return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);

        }


    }

    public function show($id)
    {

        $factura = Venta::find($id);

        $invoice_details = VentaDetalles::with(['stock.categoria:id,nombrew','stock.producto:id,producto_nombre'])
            ->where('venta_id','=',$id)->get();

        $payment = Pago::where('venta_id','=',$id)->get();

        $company = Empresa::find(1);

        return view('factura.print_factura',[
            'factura' => $factura,
            'factura_detalles' => $invoice_details,
            'pago' => $payment,
            'Empresa' => $company,
        ]);
    }

    public function edit($id)
    {
        $sell = Venta::find($id);


        $invoice_details = VentaDetalles::where('venta_detalles.venta_id','=',$id)
            ->get();

        $arr = [

            'factura_no' => $sell->id,
            'cliente_id' => $sell->cliente_id,
            'total_descuento' => $sell->importe_descuento,
            'importe_total' => $sell->importe_total+$sell->importe_descuento,
            'fecha_factura' => $sell->fecha_factura,
            'totalidad' => $sell->totalidad,
            'importe_pagado' => $sell->importe_pagado,

            'producto' => []

        ];

        $product = [];
        foreach ($invoice_details as $key => $value) {

            $products = Producto::where('categoria_id','=',$value->categoria_id)->get();
            $stocks = Stock::where('producto_id','=',$value->producto_id)->get();
            $product['id'] = $value->id;
            $product['categoria'] = $value->categoria_id;
            $product['producto_id'] = $value->producto_id;
            $product['lista_id'] = $value->stock_id;
            $product['cantidad_stock'] = 0;
            $product['cantidad'] = $value->cantidad_vendida;
            $product['precio'] = $value->precio_venta;
            $product['precio_total'] = $value->total_precio_venta;
            $product['descuento'] = $value->descuento;
            $product['tipo_descuento'] = $value->tipo_descuento;
            $product['importe_descuento'] = $value->importe_descuento;
            $product['productos'] = $products;
            $product['stocks'] = $stocks;

            array_push($arr['producto'],$product);
        }

        return $arr;
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'cliente_id' => 'required',
            'fecha_factura' => 'required',


            'producto.*.categoria' => 'required',
            'producto.*.producto_id' => 'required',
            'producto.*.lista_id' => 'required',
            'producto.*.cantidad' => 'required|integer',
            'producto.*.precio' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'producto.*.precio_total' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'producto.*.descuento' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ],[

            'cliente_id' => 'required',

            'producto.*.categoria.required' => 'required field',
            'producto.*.producto_id.required' => 'required field',
            'producto.*.lista_id.required' => 'required field',
            'producto.*.cantidad.required' => 'required',
            'producto.*.cantidad.integer' => 'required',
            'producto.*.precio.required' => 'required',
            'producto.*.precio_total.required' => 'required',
            'producto.*.descuento.regex' => 'invalid format',
        ]);

        try{

            DB::beginTransaction();


            $invoice = Venta::find($id);

            $invoice->cliente_id = $request->cliente_id;
            $invoice->importe_total = $request->totalidad;
            $invoice->importe_descuento = $request->total_descuento;
            $invoice->importe_pagado = $request->importe_pagado;
            $invoice->fecha_venta = date("Y-m-d", strtotime($request->fecha_factura));

            $invoice->update();

            $details = VentaDetalles::where('cliente_id','=',$id)->get();

            foreach ($details as $key => $sell) {

                $old_stock = Stock::find($sell->stock_id);

                $old_stock->cantidad_actual = $old_stock->cantidad_actual+$sell->cantidad_vendida;

                $old_stock->update();

            }

            VentaDetalles::where('venta_id','=',$id)->delete();

            foreach ($request->producto as  $value) {

                $stock = Stock::find($value['chalan_id']);

                $inv_details = new VentaDetalles;

                $inv_details->stock_id = $value['lista_id'];
                $inv_details->venta_id = $invoice->id;
                $inv_details->producto_id = $value['producto_id'];
                $inv_details->categoria_id = $value['categoria'];
                $inv_details->cliente_id = $request->cliente_id;
                $inv_details->proveedor_id = $stock->proveedor_id;
                $inv_details->usuario_id = Auth::user()->id;
                $inv_details->lista_no = $stock->lista_no;
                $inv_details->fecha_venta = date("Y-m-d", strtotime($request->fecha_factura));
                $inv_details->cantidad_vendida = $value['cantidad'];
                $inv_details->precio_compra = $stock->precio_compra ;
                $inv_details->precio_vendido = $value['precio'];
                $inv_details->total_precio_compra = $stock->precio_compra*$value['cantidad'];
                $inv_details->total_precio_vendido = $value['precio_total'];
                $inv_details->descuento = $value['descuento'];
                $inv_details->tipo_descuento = $value['tipo_descuento'];
                $inv_details->importe_descuento = $value['importe_descuento'];

                $inv_details->save();

                $stock->cantidad_actual = $stock->cantidad_actual  - $value['cantidad'];

                $stock->update();

            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => '¡Factura actualizada!']);
        }
        catch(\Exception $e){

            DB::rollback();

            return $e;
            //return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);
        }
    }

    public function destroy($id)
    {

        try{
            DB::beginTransaction();

            // delete sell

            $sell = Venta::find($id);

            $sell->delete();

            // delete Sell details

            $details = VentaDetalles::where('venta_id','=',$id)->get();

            foreach ($details as $key => $value) {

                $stock = Stock::find($value->stock_id);

                $stock->cantidad_actual  = $stock->cantidad_actual +$value->cantidad_vendida;

                $stock->update();

            }

            VentaDetalles::where('sell_id','=',$id)->delete();
            //delete payment

            Pago::where('sell_id','=',$id)->delete();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => '¡Factura eliminada!']);

        }
        catch(\Exception $e){

            DB::rollback();

            return $e;
            //return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);
        }

    }
}
