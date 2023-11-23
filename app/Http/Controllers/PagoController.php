<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'pago_in' => 'required',
        ]);

        try{

            $venta = Venta::find($request->id);

            $pago = new Pago;

            $pago->venta_id = $request->id;
            $pago->cliente_id = $venta->cliente_id;
            $pago->usuario_id = Auth::usuario()->id;
            $pago->fecha = date("Y-m-d", strtotime($request->fecha_pago));
            $pago->importe = $request->importe_pago;
            $pago->pago_in = $request->pago_in;
            $pago->banco_informacion = $request->banco_info;

            $pago->save();

            $paid_amount = $venta->paid_amount+$request->importe_pago;

            if($paid_amount>=$venta->total_amount){

                $venta->payment_status = 1;
            }

            $venta->importe_pago = $paid_amount;

            $venta->save();

            return response()->json(['status'=>'success','message'=>'Payment Success']);



        }
        catch(\Exception $e){

            return response()->json(['status'=>'error','message'=>'Something Went Wrong']);



        }
    }

    public function show($id)
    {

        $sell = Venta::with('customer')->find($id);

        $payment = Pago::with('user')->where('sell_id','=',$id)->get();


        return ['payment' => $payment,'invoice' => $sell];
    }

    public function edit(Pago $pago)
    {
        //
    }

    public function update(Request $request,Pago $pago)
    {
        //
    }

    public function destroy($id)
    {

        try{

            DB::beginTransaction();

            $payment = Pago::find($id);

            $sell = Venta::find($payment->sell_id);

            $sell->paid_amount = $sell->paid_amount - $payment->amount;

            $sell->update();

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
