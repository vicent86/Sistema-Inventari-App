@extends('include.master')


@section('title','Inventario | Informe-Beneficio')


@section('page-title','Informe Beneficio')


@section('content')




    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe Beneficio
                    </h2>

                    <h2 class="pull-right">

                        <a href="{{ url('print-report') }}?type={{ $type }}&start_date={{ $start_date }}&end_date={{ $end_date }}&category_id={{ $category_id }}&product_id={{ $product_id }}&stock_id={{ $stock_id }}&vendor_id={{ $vendor_id }}&customer_id={{ $customer_id }}&user_id={{ $user_id }}" target="_blank" type="button" class="btn bg-teal btn-circle waves-effect waves-circle waves-float">
                            <i class="material-icons">print</i>
                        </a>

                    </h2>
                </div>


                <div class="body">

                    <div class="table-responsive">
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
                                <td colspan="5" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Informe Beneficiot desde {{ date('j M Y',strtotime($start_date)) }} Hasta {{ date('j M Y',strtotime($end_date)) }}</p></td>

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
                            $importe_total = 0;
                            $total_precio_compra = 0;
                            $total_precio_venta  = 0;
                            $total_descuento  = 0;
                            ?>
                            @foreach($data as $value)

                                    <?php
                                    $importe_total += $value->total_cantidad;
                                    $total_precio_compra += $value->$total_precio_compra;
                                    $total_precio_venta += $value->$total_precio_venta;
                                    ?>
                                <tr>

                                    <td>{{ $value->producto->producto_nombre }}</td>
                                    <td>{{ $value->total_cantidad }}</td>
                                    <td>{{ $value->$total_precio_venta }}</td>
                                    <td>{{ $value->$total_precio_compra }}</td>

                                    <td>{{ $value->$total_precio_venta - $value->$total_precio_compra }}</td>

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


            </div>
        </div>
    </div>




@endsection

