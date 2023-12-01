<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return view('category.category');
    }

    public function CategoriaLista(Request $request)
    {
        $categorias = Categoria::orderBy('id','desc');

        if ($request->name != '') {
            $categorias->where('name', 'LIKE', '%'. $request->name . '%');
        }

        $categorias = $categorias->paginate(10);

        return $categorias;
    }

    public function AllCategory()
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
            $category = new Categoria;
            $category->nombre = $request->nombre;
            $category->save();
            return response()->json(['status' => 'success', 'message' => 'Categoría Agregada']);

        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message' => 'Algo salio mal!']);

        }
    }
    public function show(Categoria $categoria)
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
            $category = Categoria::find($id);
            $category->nombre = $request->nombre;
            $category->update();
            return response()->json(['status'=> 'success','message'=> 'Categoría actualizada']);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message' => 'Algo salio mal!']);
        }
    }
    public function destroy($id)
    {
        $category = Categoria::find($id);
        $check = Producto::where('categoria_id', '=', $category->id)->count();
        if ($check > 0) {
            return response()->json(['status'=> 'error','message'=> 'Esta categoría no esta vacía, debe eliminar primero los productos']);
        }
        try {
            $category->delete();
            return response()->json(['status'=> 'success','message'=> 'Categoría eliminada']);
        } catch (\Exception $e) {

            return response()->json(['status'=> 'error', 'message' => 'Algo salio mal!']);
        }
    }
}
