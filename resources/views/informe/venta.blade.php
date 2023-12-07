@extends('include.master')


@section('title','Inventario | Informe-Venta')


@section('page-title','Informe Venta')


@section('content')




    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>

                        Informe Venta

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
                                <td colspan="11" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Informe Venta desde {{ date('j M Y',strtotime($start_date)) }} Hasta {{ date('j M Y',strtotime($end_date)) }}</p></td>

                            </tr>
                            <tr>
                                <th>Producto</th>
                                <th>Comprobante</th>
                                <th>Fecha Venta</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Canbtidad</th>
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
                                    $total_precio_compra += $value->$total_precio_compra;
                                    $total_precio_venta += $value->$total_precio_venta;
                                    $total_descuento += $value->importe_descuento;
                                    ?>
                                <tr>

                                    <td>{{ $value->producto->producto_nombre }}</td>
                                    <td>{{ $value->lista_no }}</td>
                                    <td>{{ date("j M Y", strtotime($value->fecha_venta) ) }}</td>
                                    <td>{{ $value->cliente->cliente_nombre }}</td>
                                    <td>{{ $value->$cliente->nombre }}</td>
                                    <td>{{ $value->cantidad_vendida }}</td>
                                    <td>{{ $value->precio_compra }}</td>
                                    <td>{{ $value->precio_venta }}</td>
                                    <td>{{ $value->importe_descuento }}</td>
                                    <td>{{ $value->$total_precio_compra }}</td>
                                    <td>{{ $value->$total_precio_venta }}</td>

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


            </div>
        </div>
    </div>




@endsection

