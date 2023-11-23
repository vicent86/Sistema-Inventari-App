<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        //return view('categoria.categoria');
    }

    public function CategoriaLista(Request $request)
    {
        $categorias = Categoria::orderBy('id','desc');

        if ($request->nombre != '') {
            $categorias->where('nombre', 'LIKE', '%'. $request->nombre . '%');
        }

        $categorias = $categorias->paginate(10);

        return $categorias;
    }

    public function AllCategoria()
    {
        $categoria = Categoria::all();

        return $categoria;
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=> 'required|unique:categories',
        ]);

        try {
            $categoria = new Categoria;
            $categoria->nombre = $request->nombre;
            $categoria->save();
            return response()->json(['status' => 'success', 'message' => 'Categoría Agregada']);

        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message' => 'Algo salio mal!']);

        }
    }
    public function show(Categoria $category)
    {
        //
    }
    public function edit(Categoria $categoria)
    {
        return $categoria;
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=> 'required|unique:categories,name,'. $id,
        ]);
        try {
            $categoria = Categoria::find($id);
            $categoria->name = $request->nombre;
            $categoria->update();
            return response()->json(['status'=> 'success','message'=> 'Categoría actualizada']);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message' => 'Algo salio mal!']);
        }
    }
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        $check = Producto::where('category_id', '=', $categoria->id)->count();
        if ($check > 0) {
            return response()->json(['status' => 'error', 'message' => 'Esta categoría no esta vacía, debe eliminar primero los productos']);
        }
        try {
            $categoria->delete();
            return response()->json(['status' => 'success', 'message' => 'Categoría eliminada']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => 'Algo salio mal!']);
        }
    }
}
