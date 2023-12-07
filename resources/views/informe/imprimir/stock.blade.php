<!DOCTYPE html>
<html>
<head>
    <title>Stock Reporte</title>
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
                <td colspan="11" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Informe Stock Desde {{ date('j M Y',strtotime($start_date)) }} Hasta {{ date('j M Y',strtotime($end_date)) }}</p></td>

            </tr>
            <tr>
                <th>Categoria</th>
                <th>Producto</th>
                <th>Comprobante</th>
                <th>Fecha</th>
                <th>Entradas</th>
                <th>Compra Precio</th>
                <th>Venta Precio</th>
                <th>Stock Cantidad</th>
                <th>Cantidad Vendida</th>
                <th>Cantidad Actual</th>
            </tr>
            </thead>


            <tbody>
            <?php
            $total_cantidad = 0;
            $total_cantidad_vendida = 0;

            ?>
            @foreach($data as $value)

                    <?php
                    $total_cantidad += $value->stock_cantidad;
                    $total_cantidad_vendida += $value->sold_qty;
                    ?>
                <tr>

                    <td>{{ $value->categoria->nombre }}</td>
                    <td>{{ $value->producto->producto_nombre }}</td>
                    <td>{{ $value->lista_no }}</td>
                    <td>{{ date("j M Y", strtotime($value->created_at) ) }}</td>
                    <td>{{ $value->cliente->nombre }}</td>
                    <td>{{ $value->precio_compra }}</td>
                    <td>{{ $value->precio_venta }}</td>
                    <td>{{ $value->stock_cantidad }}</td>
                    <td>{{ $value->sold_qty }}</td>
                    <td>{{ $value->stock_cantidad - $value->sold_qty }}</td>

                </tr>
            @endforeach

            <tr>
                <th colspan="7" style="text-align: right;">Total =</th>
                <th >{{ round($total_cantidad) }}</th>
                <th >{{ round($total_cantidad_vendida) }}</th>
                <th >{{ round($total_cantidad-$total_cantidad_vendida) }}</th>

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
