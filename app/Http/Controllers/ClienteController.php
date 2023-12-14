<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClienteController extends Controller
{
    public function index()
    {

        return Inertia::render('Cliente/Cliente');

    }


    public function ClienteLista(Request $request){

        $nombre = $request->nombre;
        $direccion = $request->direccion;
        $telefono = $request->telefono;
        $cif = $request->cif;
        $cliente = Cliente::withCount([
            'venta AS importe_total' => function ($query){

                $query->select(DB::raw("COALESCE(SUM(importe_total),0)"));

            },

            'venta AS total_importe_pagado' => function ($query){

                $query->select(DB::raw("COALESCE(SUM(importe_pagado),0)"));

            },

        ])->orderBy('nombre_cliente','asc');

        if($nombre != ''){

            $cliente->where('nombre_cliente','LIKE','%'.$nombre.'%');

        }

        if($direccion != ''){

            $cliente->where('direccion','LIKE','%'.$direccion.'%');

        }

        if($telefono != ''){

            $telefono->where('telefono','LIKE','%'.$telefono.'%');

        }

        if($cif != ''){

            $cif->where('cif','LIKE','%'.$cif.'%');

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
            'direccion' => 'required|unique:clientes',
            'telefono' => 'nullable|numeric|unique:clientes',
            'cif'       => 'required|nullable|unique:clientes',
        ]);

        try{
            $customer = new Cliente();

            $customer->nombre_cliente = $request->nombre_cliente;
            $customer->direccion = $request->direccion;
            $customer->telefono = $request->telefono;
            $customer->cif = $request->cif;
            $customer->save();

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
            'direccion' => 'nullable|direccion|unique:clientes,direccion,'.$request->id,
            'telefono' => 'nullable|numeric|unique:clientes,telefono,'.$request->id,
            'cif'       => 'nullable|unique:clientes,cif'.$request->id,
        ]);

        try{
            $customer = Cliente::find($id);
            $customer->nombre_cliente = $request->nombre_cliente;
            $customer->direccion = $request->direccion;
            $customer->telefono = $request->telefono;
            $customer->cif = $request->cif;
            $customer->update();

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
