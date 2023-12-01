<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {


       // return view('proveedor.proveedor');

    }

    public function Proveedor(Request $request)
    {


        $proveedor = Proveedor::orderBy('id', 'desc');

        if ($request->nombre != '') {

            $proveedor->where('nombre', 'LIKE', '%' . $request->nombre . '%');
        }

        if ($request->email != '') {

            $proveedor->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->telefono != '') {

            $proveedor->where('telefono', 'LIKE', '%' . $request->telefono . '%');
        }

        if ($request->direccion != '') {

            $proveedor->where('direccion', 'LIKE', '%' . $request->direccion . '%');
        }

        $proveedor = $proveedor->paginate(10);

        return $proveedor;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'email' => 'nullable|unique:proveedores',
            'telefono' => 'required|unique:proveedores',
            'direccion'=> 'required|unique:proveedores',
        ]);


        try {
            $proveedor = new Proveedor;
            $proveedor->nombre = $request->nombre;
            $proveedor->email = $request->email;
            $proveedor->telefono = $request->telefono;
            $proveedor->direccion = $request->direccion;

            $proveedor->save();

            return response()->json(['status' => 'success', 'message' => 'Proveedor creado']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '¡Se ha encontrado un error! Vuelva a intentarlo.']);
        }


    }

    public function show(Proveedor $proveedor)
    {
        //
    }
    public function edit(Proveedor $proveedor)
    {
        return $proveedor;
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nombre' => 'required',
            'email' => 'nullable',
            'telefono' => 'required'
        ]);

        try {

            $supplier = Proveedor::find($id);
            $supplier->nombre = $request->nombre;
            $supplier->email = $request->email;
            $supplier->telefono = $request->telefono;
            $supplier->direccion = $request->direccion;

            $supplier->update();

            return response()->json(['status' => 'success', 'message' => 'Proveedor actualizado']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '¡Se ha encontrado un error! Vuelva a intentarlo.']);
        }
    }

    public function destroy($id)
    {

        try {

            $data = Proveedor::find($id);

            $data->delete();

            return response()->json(['status' => 'success', 'message' => 'Proveedor eliminado']);


        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '¡Se ha encontrado un error! Vuelva a intentarlo.']);
        }

    }
}
