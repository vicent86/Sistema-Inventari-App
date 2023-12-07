<!DOCTYPE html>
<html>
<head>
    <title>Factura_Inventario:{{ $factura->id }}</title>
    <link href="{{ url('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12" style="text-align: center;">
            <h2 >{{ $cliente->nombre }}</h2>
            <small>{{ $cliente->direccion }}</small><br>
            <small>{{ $cliente->telefono }}</small>
            <small>{{ $cliente->cif }}</small>
            <hr>
        </div>
    </div>
</div>
<div class="container">

    <!-- title row -->
    <div class="row">
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Información del cliente
            <address>
                <strong>{{ $factura->cliente->nombre_cliente }}</strong><br>

                <span style="font-weight: bold">Telefono:</span> {{ $factura->cliente->telefono }}<br>

                <span style="font-weight: bold">Dirección:</span> {{ $factura->cliente->direccion  }}<br>
                <span style="font-weight: bold">CIF:</span> {{ $factura->cliente->cif  }}<br>


            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col text-right">
            <b style="font-weight: bold;color: green">Factura N° : {{ $factura->id }}</b><br>
            <b>Fecha: {{ date("d F Y", strtotime($factura->frcha_venta)) }}</b><br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-condensed">
                <thead style="background-color: teal;color: #fff;">
                <tr>
                    <th>Categoría</th>
                    <th>Producto</th>
                    <th>Comprobante</th>
                    <th>Cantidad</th>
                    <th>Precio por unidad</th>
                    <th>Descuento</th>
                    <th>IVA</th>
                    <th>Precio total</th>
                </tr>
                </thead>
                <tbody>
                @php

                    $sub_total = 0;
                    $descuento = 0;
                @endphp
                @foreach($factura_detalles as $value)
                    <tr>
                        <td>{{ $value->stock->categoria->nombre }}</td>
                        <td>{{ $value->stock->producto->producto_nombre }}</td>
                        <td>{{ $value->lista_no }}</td>
                        <td>{{ $value->cantidad_vendida }}</td>
                        <td>{{ $value->precio_venta }}</td>
                        <td>{{ $value->importe_descuento }}</td>
                        <td>{{ $value->iva }}</td>
                        <td>{{ $value->total_precio_venta }}</td>
                    </tr>
                    @php
                        $descuento += $value->importe_descuento;
                        $sub_total += $value->total_precio_venta;
                    @endphp

                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-8">

        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <!-- <p class="lead">Importe Due 2/22/2014</p> -->

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$ {{ $sub_total+$descuento }}</td>
                    </tr>
                    <tr>
                        <th>Descuento: </th>
                        <td>$ {{ $descuento}}</td>
                    </tr>
                    <tr>
                        <th>Total a pagar: </th>
                        <td>$ {{ $sub_total }}</td>
                    </tr>
                    <tr>
                        <th>Importe pagado: </th>
                        <td>$ {!! $pgo = $factura->importe_pagado !!}</td>
                    </tr>
                    <tr>
                        <th>Importe a debido: </th>
                        <td>$ {{ $sub_total-$pago }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->




</div>
<script >
    window.print();
</script>
</body>
</html>
