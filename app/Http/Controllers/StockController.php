<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Stock;
use App\Models\VentaDetalles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        //$proveedor = Proveedor::orderBy('name', 'asc')->get();
        //$categoria = Categoria::orderBy('name', 'asc')->get();
        //$producto = Producto::orderBy('product_name', 'asc')->get();
        //return view('stock.stock', [
           // 'proveedor' => $proveedor,
            //'categoria' => $categoria,
            //'producto' => $producto,
        //]);
    }


    public function StockList(Request $request)
    {

        $stock = Stock::with(
            [
                'product' => function ($query) {
                    $query->select('id', 'producto_nombre');
                },
                'vendor' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'user' => function ($query) {

                    $query->select('id', 'nombre');
                },
                'category' => function ($query) {

                    $query->select('id', 'nombre');
                }
            ]
        )
            ->orderBy('updated_at', 'desc');


        if ($request->categoria != '') {

            $stock->where('categoria_id', '=', $request->categoria);

        }

        if ($request->producto != '') {

            $stock->where('producto_id', '=', $request->producto);

        }

        if ($request->proveedor != '') {

            $stock->where('proveedor_id', '=', $request->proveedor);

        }

        $stock = $stock->paginate(10);

        return $stock;

    }

    public function StockListaCan($id)
    {

        $Lista = Stock::where('producto_id', '=', $id)
            ->where('cantidad_actual', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->get();


        return $Lista;

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([

            'producto' => 'required',
            'proveedor' => 'required',
            'categoria' => 'required',
            'cantidad' => 'required|integer',
            'precio_compra' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'precio_venta' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',

        ]);

        try {

            $stock = new Stock;
            $stock->categoria_id = $request->categoria;
            $stock->producto_id = $request->producto;
            $stock->proveedor_id = $request->proveedor;
            $stock->usuario_id = Auth::user()->id;
            $stock->precio_compra = $request->precio_compra;
            $stock->precio_venta = $request->precio_venta;
            $stock->Lista_no = date('Y-m-d');
            $stock->cantidad_stock = $request->cantidad;
            $stock->cantidad_actual = $request->cantidad;
            $stock->descuento = 0;
            $stock->nota = $request->nota;
            $stock->estado = 1;
            $stock->save();

            Stock::where('producto_id', '=', $request->producto)
                ->where('cantidad_actual', '>', 0)
                ->update(['precio_venta' => $request->precio_venta]);

            return response()->json(['status' => 'success', 'message' => 'Producto añadido a existencias']);

        } catch (\Exception $e) {
            return $e;
            //return response()->json(['status' => 'error', 'message' => 'Problema para actualizar existencia']);

        }
    }


    public function show(Stock $stock)
    {

        return $stock;

    }

    public function edit($stock)
    {
        return $stock = Stock::with('producto')->where('id', '=', $stock)->first();
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'categoria' => 'required',
            'producto' => 'required',
            'proveedor' => 'required',
            'precio_compra' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'precio_venta' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ]);


        try {
            $stock = Stock::find($id);
            $stock->categoria_id = $request->categoria;
            $stock->producto_id = $request->producto;
            $stock->proveedor_id = $request->proveedor;
            $stock->precio_compra = $request->precio_compra;
            $stock->precio_venta = $request->precio_venta;
            $stock->nota = $request->nota;
            $stock->update();

            return response()->json(['status' => 'success', 'message' => 'Existencia actualizada']);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => 'Problema para actualizar existencia']);


        }
    }

    public function StockUpdate(Request $request)
    {

        $request->validate([

            'new_qty' => 'required|integer',
            'state' => 'required',
        ]);

        $stock = Stock::find($request->id);

        if ($request->state == '+') {

            $stock->cantidad_actual= $stock->cantidad_actual+ $request->new_qty;
            $stock->cantidad_stock = $stock->cantidad_stock + $request->new_qty;

            $stock->update();

            return response()->json(['status' => 'success', 'message' => 'Cantidad actualizada']);
        } else {

            if ($request->new_qty > $stock->cantidad_actual) {

                return response()->json(['status' => 'error', 'message' => 'La cantidad es mayor que la cantidad actual']);

            } else {

                $stock->cantidad_actual = $stock->cantidad_actual - $request->new_qty;
                $stock->cantidad_stock = $stock->cantidad_stock - $request->new_qty;

                $stock->update();

                return response()->json(['status' => 'success', 'message' => 'Cantidad actualizada']);

            }


        }
    }


    public function destroy($id)
    {

        $check = VentaDetalles::where('stock_id', '=', $id)->count();

        if ($check > 0) {


            return response()->json(['status' => 'error', 'message' => 'Esta factura tiene registro de ventas, eliminar los artículos vendidos primero']);

        }


        try {

            Stock::where('id', '=', $id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Eliminado correctamente']);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);

        }

    }
}
