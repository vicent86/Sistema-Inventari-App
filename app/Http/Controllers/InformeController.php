<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Stock;
use App\Models\Usuario;
use App\Models\Venta;
use App\Models\VentaDetalles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InformeController extends Controller
{
    public function index()
    {
        $customer = Cliente::all();
        $category = Categoria::all();
        $user = Usuario::all();
        $vendor = Venta::all();

        return Inertia::render('Informe/Informe', [
            'cliente' => $customer,
            'categoria' => $category,
            'user' => $user,
            'proveedor' => $vendor,
        ]);

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $request->validate([
            'tipo' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $type = $request->tipo;
        $start_date = date("Y-m-d", strtotime($request->start_date));
        $end_date = date("Y-m-d", strtotime($request->end_date));

        $proveedor_id = $request->proveedor_id;
        $usuario_id = $request->usuario_id;
        $cliente_id = $request->cliente_id;
        $categoria_id = $request->categoria_id;
        $producto_id = $request->producto_id;
        $stock_id = $request->stock_id;




        $page = '';

        if ($type == 'sell') {

            $data = VentaDetalles::with([
                'producto:id,producto_nombre',
                'cliente:id,cliente_nombre',
                'usuario:id,nombre'
            ])
                ->whereBetween('fecha_venta', [$start_date, $end_date]);

            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($cliente_id != '') {

                $data->where('cliente_id', '=', $cliente_id);

            }


            if ($proveedor_id != '') {

                $data->where('proveedor_id', '=', $proveedor_id);

            }

            if ($categoria_id != '') {

                $data->where('categoria_id', '=', $categoria_id);

            }

            if ($producto_id != '') {

                $data->where('producto_id', '=', $producto_id);

            }


            if ($stock_id != '') {

                $data->where('stock_id', '=', $stock_id);

            }



            $data = $data->get();

            $page = 'report.sell';

        }

        if ($type == 'invoice') {

            $data = Venta::with(['cliente:id,cliente_nombre', 'usuario:id,nombre'])
                ->whereBetween('fecha_venta', [$start_date, $end_date]);
            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($cliente_id != '') {

                $data->where('cliente_id', '=', $cliente_id);

            }



            $data = $data->get();

            $page = 'report.invoice';

        }

        if ($type == 'due') {

            $data = Venta::with(['cliente:id,cliente_nombre'])
                ->select(
                    'cliente_id',
                    DB::raw('SUM(total_importe) as total_importe'),
                    DB::raw('SUM(importe_pagado) as importe_pagado')
                )
                ->where('estado_pago', '=', 0)
                ->whereBetween('fecha_venta', [$start_date, $end_date])
                ->groupBy('cliente_id');

            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($cliente_id != '') {

                $data->where('cliente_id', '=', $cliente_id);

            }


            $data = $data->get();

            $page = 'report.due';
        }

        if ($type == 'profit') {

            $data = VentaDetalles::with('product:id,product_name')
                ->select(
                    'producto_id',
                    DB::raw('SUM(cantidad_vendida) as cantidad_total'),
                    DB::raw('SUM(total_precio_compra) as total_precio_compra'),
                    DB::raw('SUM(total_precio_venta) as total_precio_venta'),
                    DB::raw('SUM(importe_descuento) as total_importe_descuento')
                )
                ->groupBy('producto_id')
                ->whereBetween('fecha_venta', [$start_date, $end_date]);

            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($cliente_id != '') {

                $data->where('cliente_id', '=', $cliente_id);

            }


            if ($proveedor_id != '') {

                $data->where('proveedor_id', '=', $proveedor_id);

            }

            if ($categoria_id != '') {

                $data->where('categoria_id', '=', $categoria_id);

            }

            if ($producto_id != '') {

                $data->where('producto_id', '=', $producto_id);

            }


            if ($stock_id != '') {

                $data->where('stock_id', '=', $stock_id);

            }

            $data = $data->get();

            $page = 'report.profit';

        }


        if ($type == 'stock') {
            $data = Stock::with(['producto:id,producto_nombre', 'categoria:id,nombre', 'proveedor:id,nombre'])
                ->withCount([
                    'venta_detalles AS sold_qty' => function ($query) {
                        $query->select(DB::raw("COALESCE(SUM(cantidad_vendida),0)"));
                    }
                ])
                ->whereBetween('lista_no', [$start_date, $end_date]);

            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($proveedor_id != '') {

                $data->where('proveedor_id', '=', $proveedor_id);

            }

            if ($categoria_id != '') {

                $data->where('categoria_id', '=', $categoria_id);

            }

            if ($producto_id != '') {

                $data->where('producto_id', '=', $producto_id);

            }

            $data = $data->get();


            $page = 'report.stock';


        }

        $company = Empresa::find(1);

        return view($page, [
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tipo' => $type,
            'proveedor_id' => $proveedor_id,
            'cliente_id' => $cliente_id,
            'categoria_id' => $categoria_id,
            'producto_id' => $producto_id,
            'stock_id' => $stock_id,
            'usuario_id' => $usuario_id,
            'empresa' => $company,
        ]);


    }

    // Imprimir Informes


    public function Print(Request $request)
    {

        $tipo = $request->tipo;
        $start_date = date("Y-m-d", strtotime($request->start_date));
        $end_date = date("Y-m-d", strtotime($request->end_date));

        $proveedor_id = $request->proveedor_id;
        $usuario_id = $request->usuario_id;
        $cliente_id = $request->cliente_id;
        $categoria_id = $request->categoria_id;
        $producto_id = $request->producto_id;
        $stock_id = $request->stock_id;

        $page = '';

        if ($tipo == 'venta') {

            $data = VentaDetalles::with([
                'producto:id,producto_name',
                'cliente:id,cliente_nombre',
                'usuario:id,nombre'
            ])
                ->whereBetween('fecha_venta', [$start_date, $end_date]);

            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($cliente_id != '') {

                $data->where('cliente_id', '=', $cliente_id);

            }


            if ($proveedor_id != '') {

                $data->where('proveedor_id', '=', $proveedor_id);

            }

            if ($categoria_id != '') {

                $data->where('categoria_id', '=', $categoria_id);

            }

            if ($producto_id != '') {

                $data->where('producto_id', '=', $producto_id);

            }


            if ($stock_id != '') {

                $data->where('stock_id', '=', $stock_id);

            }



            $data = $data->get();

            $page = 'report.print.sell';

        }

        if ($tipo == 'factura') {

            $data = Venta::with(['cliente:id,cliente_nombre', 'usuario:id,nombre'])
                ->whereBetween('fecha_venta', [$start_date, $end_date]);
            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($cliente_id != '') {

                $data->where('cliente_id', '=', $cliente_id);

            }



            $data = $data->get();

            $page = 'report.print.invoice';

        }

        if ($tipo == 'due') {

            $data = Venta::with(['cliente:id,cliente_nombre'])
                ->select(
                    'cliente_id',
                    DB::raw('SUM(importe_total) as importe_total'),
                    DB::raw('SUM(importe_pagado) as importe_pagado')
                )
                ->where('estado_pago', '=', 0)
                ->whereBetween('fecha_venta', [$start_date, $end_date])
                ->groupBy('cliente_id');

            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($cliente_id != '') {

                $data->where('cliente_id', '=', $cliente_id);

            }


            $data = $data->get();

            $page = 'report.print.due';
        }

        if ($tipo == 'beneficio') {

            $data = VentaDetalles::with('producto:id,producto_nombre')
                ->select(
                    'producto_id',
                    DB::raw('SUM(cantidad_vendida) as cantidad_vendida'),
                    DB::raw('SUM(total_precio_compra) as total_precio_compra'),
                    DB::raw('SUM(total_precio_venta) as total_precio_venta'),
                    DB::raw('SUM(importe_descuento) as total_importe_descuento')
                )
                ->groupBy('producto_id')
                ->whereBetween('fecha_venta', [$start_date, $end_date]);

            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($cliente_id != '') {

                $data->where('cliente_id', '=', $cliente_id);

            }


            if ($proveedor_id != '') {

                $data->where('proveedor_id', '=', $proveedor_id);
            }

            if ($categoria_id != '') {

                $data->where('categoria_id', '=', $categoria_id);

            }

            if ($producto_id != '') {

                $data->where('producto_id', '=', $producto_id);

            }


            if ($stock_id != '') {

                $data->where('stock_id', '=', $stock_id);

            }

            $data = $data->get();

            $page = 'report.print.profit';

        }


        if ($tipo == 'stock') {
            $data = Stock::with(['producto:id,producto_nombre', 'categoria:id,nombre', 'proveedor:id,nombre'])
                ->withCount([
                    'venta_detalles AS sold_qty' => function ($query) {
                        $query->select(DB::raw("COALESCE(SUM(sold_quantity),0)"));
                    }
                ])
                ->whereBetween('lista_no', [$start_date, $end_date]);

            if ($usuario_id != '') {

                $data->where('usuario_id', '=', $usuario_id);

            }

            if ($proveedor_id != '') {

                $data->where('proveedor_id', '=', $proveedor_id);

            }

            if ($categoria_id != '') {

                $data->where('categoria_id', '=', $categoria_id);

            }

            if ($producto_id != '') {

                $data->where('producto_id', '=', $producto_id);

            }

            $data = $data->get();


            $page = 'report.print.stock';


        }

        $company = Empresa::find(1);

        return view($page, [
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tipo' => $tipo,
            'proveedor_id' => $proveedor_id,
            'cliente_id' => $cliente_id,
            'categoria_id' => $categoria_id,
            'producto_id' => $producto_id,
            'stock_id' => $stock_id,
            'usuario_id' => $usuario_id,
            'empresa' => $company,
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
