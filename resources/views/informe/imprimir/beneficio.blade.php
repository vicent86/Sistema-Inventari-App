<!DOCTYPE html>
<html>
<head>
    <title>Informe Beneficio</title>
    <link href="{{ url('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <table class="table table-bordered table-condensed">
            <thead>
            <tr>
                <td colspan="5" style="border: none !important;">
                    <h3 style="text-align: center;">{{ $cliente->nombre }}</h3>
                </td>

            </tr>

            <tr style="border: none !important;">
                <td colspan="5" style="border: none !important;">
                    <p style="text-align: center;">{{ $cliente->direccion }} <br>
                        {{ $cliente->telefono }}
                        {{ $cliente->cif }}
                    </p></td>

            </tr>

            <tr style="border: none !important;">
                <td colspan="5" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Informe de Beneficio desde {{ date('j M Y',strtotime($start_date)) }} Hasta {{ date('j M Y',strtotime($end_date)) }}</p></td>

            </tr>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total Vendido Importe</th>
                <th>Total Comprado Importe</th>
                <th>Beneficio</th>

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
                    $total_cantidad += $value->total_cantidad;
                    $total_precio_compra += $value->total_precio_compra;
                    $total_precio_venta += $value->total_precio_venta;
                    ?>
                <tr>

                    <td>{{ $value->producto->producto_nombre }}</td>
                    <td>{{ $value->total_cantidad }}</td>
                    <td>{{ $value->total_precio_venta }}</td>
                    <td>{{ $value->total_precio_compra }}</td>

                    <td>{{ $value->total_precio_venta - $value->total_precio_compra }}</td>

                </tr>
            @endforeach

            <tr>
                <th style="text-align: right;">Total =</th>
                <th>{{ round($total_cantidad) }}</th>
                <th>{{ round($total_precio_venta) }}</th>
                <th>{{ round($total_precio_compra) }}</th>
                <th>{{ round($total_precio_venta-$total_precio_compra) }}</th>

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
