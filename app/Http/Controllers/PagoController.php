<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_pago' => 'required',
            'importe_pago' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'payment_in' => 'required',
        ]);

        try{

            $venta = Venta::find($request->id);

            $payment = new Pago();

            $payment->id_venta = $request->id;
            $payment->cliente_id = $venta->cliente_id;
            $payment->fecha = date("Y-m-d", strtotime($request->fecha_pago));
            $payment->importe = $request->importe_pago;
            $payment->paid_in = $request->payment_in;
            $payment->banco_informacion = $request->banco_info;

            $payment->save();

            $importe_pagado = $venta->importe_pago+$request->importe_pago;

            if($importe_pagado>=$venta->total_importe){

                $venta->estado_pago = 1;
            }

            $venta->paid_amount = $importe_pagado;

            $venta->save();

            return response()->json(['status'=>'success','message'=>'Payment Success']);



        }
        catch(\Exception $e){

            return response()->json(['status'=>'error','message'=>'Something Went Wrong']);



        }
    }

    public function show($id)
    {

        $venta = Venta::with('cliente')->find($id);

        $pago = Pago::with('cliente')->where('id_venta','=',$id)->get();


        return ['payment' => $pago,'factura' => $venta];
    }

    public function edit(Pago $pago)
    {
        //
    }

    public function update(Request $request, Pago $pago)
    {
        //
    }

    public function destroy($id)
    {

        try{

            DB::beginTransaction();

            $payment = Pago::find($id);

            $venta = Venta::find($payment->sell_id);

            $venta->importe_pagado = $venta->importe_pagado - $payment->amount;

            $venta->update();

            $payment->delete();

            DB::commit();

            return response()->json(['status'=>'success','message'=>'Borrado Satisfactoriamente']);



        }
        catch(\Exception $e)
        {
            DB::rollback();

            return response()->json(['status'=>'error','message'=>'Algo salió mal!']);

        }

    }
}
