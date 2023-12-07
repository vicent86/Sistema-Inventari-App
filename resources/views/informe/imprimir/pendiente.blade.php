<!DOCTYPE html>
<html>
<head>
    <title>Due Report</title>
    <link href="{{ url('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="4" style="border: none !important;">
                    <h3 style="text-align: center;">{{ $cliente->nombre }}</h3>
                </td>

            </tr>

            <tr style="border: none !important;">
                <td colspan="4" style="border: none !important;">
                    <p style="text-align: center;">{{ $cliente->direccion }} <br>
                        {{ $cliente->telefono }}
                        {{ $cliente->cif }}
                    </p></td>

            </tr>

            <tr style="border: none !important;">
                <td colspan="4" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Due Report from {{ date('j M Y',strtotime($start_date)) }} To {{ date('j M Y',strtotime($end_date)) }}</p></td>

            </tr>
            <tr>

                <th>Cliente</th>
                <th>Total Importe</th>
                <th>Pago Importe</th>
                <th>Pendiente</th>
            </tr>
            </thead>


            <tbody>
            <?php
            $importe_total = 0;
            $total_pagado  = 0;
            $total_descuento  = 0;
            ?>
            @foreach($data as $value)

                    <?php
                    $importe_total += $value->importe_total;
                    $total_pagado += $value->importe_pagado;
                    ?>
                <tr>

                    <td>{{ $value->cliente->cliente_nombre }}</td>
                    <td>{{ $value->importe_total }}</td>
                    <td>{{ $value->importe_pagado }}</td>
                    <td>{{ $value->importe_total - $value->importe_pagado }}</td>
                </tr>
            @endforeach

            <tr>
                <th  style="text-align: right;">Total =</th>
                <th >{{ round($importe_total) }}</th>
                <th >{{ round($total_pagado) }}</th>
                <th >{{ round($importe_total-$total_pagado) }}</th>
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
