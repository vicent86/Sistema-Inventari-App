<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Stock;
use App\Models\VentaDetalles;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $vendor = Proveedor::orderBy('nombre', 'asc')->get();
        $category = Categoria::orderBy('nombre', 'asc')->get();
        $product = Producto::orderBy('producto_nombre', 'asc')->get();
        return view('stock.stock', [
            'proveedor' => $vendor,
            'categoria' => $category,
            'producto' => $product,
        ]);
    }


    public function StockList(Request $request)
    {

        $stock = Stock::with(
            [
                'producto' => function ($query) {
                    $query->select('id', 'producto_nombre');
                },
                'proveedor' => function ($query) {
                    $query->select('id', 'nombre');
                },

                'categoria' => function ($query) {

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

        $chalan = Stock::where('producto_id', '=', $id)
            ->where('cantidad_actual', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->get();


        return $chalan;

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
            $stock->producto_code = time();
            $stock->proveedor_id = $request->proveedor;
            $stock->precio_compra = $request->precio_compra;
            $stock->precio_venta = $request->precio_venta;
            $stock->lista_no = date('Y-m-d');
            $stock->stock_cantidad = $request->cantidad;
            $stock->cantidad_actual = $request->cantidad;
            $stock->descuento = 0;
            $stock->nota = $request->nota;
            $stock->estado = 1;
            $stock->save();

            Stock::where('producto_id', '=', $request->product)
                ->where('cantidad_actual', '>', 0)
                ->update(['precio_venta' => $request->selling_price]);

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

            $stock->current_quantity = $stock->current_quantity + $request->new_qty;
            $stock->stock_quantity = $stock->stock_quantity + $request->new_qty;

            $stock->update();

            return response()->json(['status' => 'success', 'message' => 'Cantidad actualizada']);
        } else {

            if ($request->new_qty > $stock->current_quantity) {

                return response()->json(['status' => 'error', 'message' => 'La cantidad es mayor que la cantidad actual']);

            } else {

                $stock->current_quantity = $stock->current_quantity - $request->new_qty;
                $stock->stock_quantity = $stock->stock_quantity - $request->new_qty;

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
