<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {

        //return view('cliente.cliente');

    }


    public function ClienteLista(Request $request){

        $nombre = $request->nombre;
        $email = $request->email;
        $telefono = $request->telefono;
        $cliente = Cliente::withCount([
            'sell AS total_amount' => function ($query){

                $query->select(DB::raw("COALESCE(SUM(total_amount),0)"));

            },

            'sell AS total_paid_amount' => function ($query){

                $query->select(DB::raw("COALESCE(SUM(paid_amount),0)"));

            },

        ])->orderBy('customer_name','asc');

        if($nombre != ''){

            $cliente->where('customer_name','LIKE','%'.$nombre.'%');

        }

        if($email != ''){

            $cliente->where('email','LIKE','%'.$email.'%');

        }

        if($telefono != ''){

            $cliente->where('phone','LIKE','%'.$telefono.'%');

        }

        $cliente = $cliente->paginate(10);

        return $cliente;

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([

            'nombre_cliente' => 'required',
            'email' => 'nullable|email|unique:customers',
            'telefono' => 'nullable|numeric|unique:customers',
        ]);

        try{
            $cliente = new Cliente;

            $cliente->nombre_cliente = $request->nombre_cliente;
            $cliente->email = $request->email;
            $cliente->telefono = $request->telefono;
            $cliente->direccion = $request->direccion;
            $cliente->save();

            return response()->json(['status'=>'success','message'=>'Cliente agregado']);
        }
        catch(\Exception $e)
        {

            return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);

        }



    }

    public function show(Cliente $cliente)
    {
        //
    }

    public function edit(Cliente $cliente)
    {
        return $cliente;
    }


    public function update(Request $request,$id)
    {
        $request->validate([

            'nombre_cliente' => 'required',
            'email' => 'nullable|email|unique:customers,email,'.$request->id,
            'telefono' => 'nullable|numeric|unique:customers,email,'.$request->id,
        ]);

        try{
            $cliente = Cliente::find($id);
            $cliente->nombre_cliente = $request->nombre_cliente;
            $cliente->email = $request->email;
            $cliente->telefono = $request->telefono;
            $cliente->direccion = $request->direccion;
            $cliente->update();

            return response()->json(['status'=>'success','message'=>'Información del cliente actualizada']);
        }
        catch(\Exception $e)
        {

            return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);

        }
    }

    public function destroy(Cliente $cliente)
    {
        //
    }
}
