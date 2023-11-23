<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Stock;
use App\Models\Venta;
use App\Models\VentaDetalles;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {

        return view('welcome');
    }


    public function InfoBox()
    {

        $total_invoice = Venta::count();
        $total_customer = Cliente::count();
        $total_vendor = Proveedor::count();
        $total_sold_amount = Venta::sum('importe_total');
        $total_paid_amount = Venta::sum('importe_pagado');
        $total_outstanding = $total_sold_amount - $total_paid_amount;
        $total_product = Producto::count();
        $total_quantity = Stock::sum('cantidad_stock');
        $total_sold_quantity = VentaDetalles::sum('cantidad vendida');
        $total_current_quantity = $total_quantity - $total_sold_quantity;

        $total_buy_price = VentaDetalles::sum('total_precio_compra');
        $total_gross_profit = $total_sold_amount - $total_buy_price;
        $total_net_profit = $total_paid_amount - $total_buy_price;

        return response()->json([

            'total_factura' => $total_invoice,
            'total_cliente' => $total_customer,
            'total_proveedor' => $total_vendor,
            'total_importe_vendido' => round($total_sold_amount),
            'total_importe_pagado' => round($total_paid_amount),
            'total_penmdiente' => round($total_outstanding),
            'total_producto' => $total_product,
            'total_cantidad' => $total_quantity,
            'total_cantidad_vendida' => $total_sold_quantity,
            'total_cantidad_actual' => $total_current_quantity,
            'total_beneficio_bruto' => round($total_gross_profit),
            'total_beneficio_neto' => round($total_net_profit)

        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
