@extends('include.master')


@section('title','Inventory | Informe-Stock')


@section('page-title','Informe Stock')


@section('content')




    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>

                        Informe Stock

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
                                <td colspan="11" style="border: none !important;"><p style="text-align: center;font-weight: bold;">Stock Informe desde {{ date('j M Y',strtotime($start_date)) }} Hasta {{ date('j M Y',strtotime($end_date)) }}</p></td>

                            </tr>
                            <tr>
                                <th>Categoria</th>
                                <th>Producto</th>
                                <th>Comprobante</th>
                                <th>Fecha</th>
                                <th>Entradas</th>
                                <th>Compra Precio</th>
                                <th>Venta Precio</th>
                                <th>Cantidad Stock</th>
                                <th>Cantidad Venta</th>
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
                                    <td>{{ $value->user->name }}</td>
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


            </div>
        </div>
    </div>




@endsection

