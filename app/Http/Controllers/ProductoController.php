<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index ()
    {
        //$categoria = Categoria::orderBy('nombre', 'asc')->get();
        //return view('producto.producto', ['categoria' => $categoria]);
    }

    public function create ()
    {
        //
    }

    public function ProductoLista(Request $request)
    {
           $producto = Producto::with([
               'categoria' => function ($query) {
                    $query->select('id', 'nombre');
               }
           ])->orderBy('producto_nombre', 'asc');

           $nombre = $request->nombre;

        if ($nombre != '') {

            $producto->where('producto_nombre', 'LIKE', '%' . $nombre . '%');

        }

        if ($request->cat != '') {

            $producto->where('categoria_id', '=', $request->cat);

        }

        $producto = $producto->paginate(10);

        return $producto;
    }

    public function productoPorCategoria($id)
    {

        $producto = Producto::where('categoria_id', '=', $id)->get();

        return $producto;

    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:products,producto_nombre',
            'categoria' => 'required',
        ]);

        try {

            $producto = new Producto;

            $producto->categoria_id = $request->categoria;
            $producto->producto_nombre = $request->nombre;
            $producto->descrpcion = $request->descripcion;

            $producto->save();

            return response()->json(['status' => 'success', 'message' => 'Producto agregado']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Algo salió mal! Por favor, vuelva a intentarlo']);
        }
    }

    public function show(Producto $producto)
    {
        //
    }

    public function edit(Producto $producto)
    {
        return $producto;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria' => 'required',
        ]);


        try {

            $producto = Producto::find($id);
            $producto->categoria_id = $request->categoria;
            $producto->producto_nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;

            $producto->update();

            return response()->json(['status' => 'success', 'message' => 'Producto actualizado']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Algo salió mal! Por favor, vuelva a intentarlo']);
        }
    }

    // Borrar producto

    public function destroy($id)
    {


        $producto = Producto::find($id);

        $check = Stock::where('product_id', '=', $producto->id)->count();


        if ($check > 0) {

            return response()->json(['status' => 'error', 'message' => 'Primero debe eliminar las existencias del producto']);


        } else {


            try {

                $producto->delete();

                return response()->json(['status' => 'success', 'message' => 'Producto eliminado']);

            } catch (\Exception $e) {

                return response()->json(['status' => 'error', 'message' => 'Algo salió mal! Por favor, vuelva a intentarlo']);
            }

        }

    }
}
