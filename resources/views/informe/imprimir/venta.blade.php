<!DOCTYPE html>
<html>
<head>
    <title>Informe Ventas</title>
    <link href="{{ url('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <table class="table table-bordered table-condensed">
            <thead>
            <tr>
                <td colspan="11" style="border: none !important;">
                    <h3 style="text-align: center;">{{ $cliente->nombre }}</h3>
                </td>

            </tr>

            <tr style="border: none !important;">
                <td colspan="11" style="border: none !important;">
                    <p style="text-align: center;">{{ $cliente->direccion }} <br>
                        {{ $cliente->telefono }}
                        {{ $cliente->cif }}
                    </p></td>

            </tr>

            <tr style="border: none !important;">
                <td colspan="11" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Informe Ventas desde {{ date('j M Y',strtotime($start_date)) }} Hasta {{ date('j M Y',strtotime($end_date)) }}</p></td>

            </tr>
            <tr>
                <th>Producto</th>
                <th>Comprobante</th>
                <th>Fecha Venta</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Cantidad</th>
                <th>Unidad Compra Precio</th>
                <th>Unidad Venta Precio</th>
                <th>Descuento Importe</th>
                <th>IVA</th>
                <th>Total Compra Importe</th>
                <th>Total Venta Importe</th>

            </tr>
            </thead>


            <tbody>
            <?php
            $total_cantidad = 0;
            $total_precio_compra = 0;
            $total_precio_venta  = 0;
            $total_descuento  = 0;
            ?>
            @foreach($data as $value)

                    <?php
                    $total_cantidad += $value->cantidad_vendida;
                    $total_precio_compra += $value->total_precio_compra;
                    $total_precio_venta += $value->total_precio_venta;
                    $total_descuento += $value->importe_descuento;
                    ?>
                <tr>

                    <td>{{ $value->producto->producto_nombre }}</td>
                    <td>{{ $value->lista_no }}</td>
                    <td>{{ date("j M Y", strtotime($value->fecha_venta) ) }}</td>
                    <td>{{ $value->cliente->cliente_nombre }}</td>
                    <td>{{ $value->cliente->nombre }}</td>
                    <td>{{ $value->cantidad_vendida }}</td>
                    <td>{{ $value->precio_compra }}</td>
                    <td>{{ $value->precio_venta }}</td>
                    <td>{{ $value->importe_descuento }}</td>
                    <td>{{ $value->total_precio_compra }}</td>
                    <td>{{ $value->total_precio_venta }}</td>

                </tr>
            @endforeach

            <tr>
                <th colspan="5" style="text-align: right;">Total =</th>
                <th >{{ round($total_cantidad) }}</th>
                <th ></th>
                <th ></th>
                <th >{{ round($total_descuento) }}</th>
                <th >{{ round($total_precio_compra) }}</th>
                <th >{{ round($total_precio_venta) }}</th>

            </tr>


            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    window.print();
</script>
</body>
</html>
