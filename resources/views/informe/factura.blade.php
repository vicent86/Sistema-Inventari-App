@extends('include.master')


@section('title','Inventario | Informe-Factura')


@section('page-title','Informe-Factura')


@section('content')




    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>

                        Informe Factura
                    </h2>

                    <h2 class="pull-right">

                        <a href="{{ url('print-report') }}?type={{ $type }}&start_date={{ $start_date }}&end_date={{ $end_date }}&category_id={{ $category_id }}&product_id={{ $product_id }}&stock_id={{ $stock_id }}&vendor_id={{ $vendor_id }}&customer_id={{ $customer_id }}&user_id={{ $user_id }}" target="_blank" type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                            <i class="material-icons">print</i>
                        </a>

                    </h2>
                </div>


                <div class="body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td colspan="8" style="border: none !important;">
                                    <h3 style="text-align: center;">{{ $cliente->nombre }}</h3>
                                </td>

                            </tr>

                            <tr style="border: none !important;">
                                <td colspan="8" style="border: none !important;">
                                    <p style="text-align: center;">{{ $cliente->direccion }} <br>
                                        {{ $cliente->telefono }}
                                        {{ $cliente->cif }}
                                    </p></td>

                            </tr>

                            <tr style="border: none !important;">
                                <td colspan="8" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Invoice Report from {{ date('j M Y',strtotime($start_date)) }} To {{ date('j M Y',strtotime($end_date)) }}</p></td>

                            </tr>
                            <tr>
                                <th>Factura No.</th>
                                <th>Factura Fecha</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Detalles</th>
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

                                    <td>{{ $value->id }}</td>
                                    <td>{{ date("j M Y", strtotime($value->fecha_venta) ) }}</td>
                                    <td>{{ $value->cliente->cliente_nombre }}</td>
                                    <td>{{ $value->cliente->nombre }}</td>
                                    <td><a href="{{ route('factura.show',$value->id) }}" target="_blank" type="button" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">print</i>
                                        </a></td>
                                    <td>{{ $value->importe_total }}</td>
                                    <td>{{ $value->importe_pagado }}</td>
                                    <td>{{ $value->importe_total - $value->importe_pagado }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <th colspan="5" style="text-align: right;">Total =</th>
                                <th >{{ round($importe_total) }}</th>
                                <th >{{ round($total_pagado) }}</th>
                                <th >{{ round($importe_total-$total_pagado) }}</th>
                            </tr>


                            </tbody>
                        </table>
                    </div>


                </div>


            </div>
        </div>
    </div>




@endsection

