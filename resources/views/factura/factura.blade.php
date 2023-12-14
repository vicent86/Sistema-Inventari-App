@extends('include.master')

@section('title','Inventario | Facturación')

@section('page-title','Facturación')

@section('content')


    <div class="row clearfix">

        <create-invoice :categorias="{{ $categoria }}" :clientes="{{ $cliente }}"></create-invoice>

    </div>


    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">

                    <h2 style="visibility: hidden;">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-stock">
                            Nueva factura
                        </button>
                    </h2>
                </div>

                <view-invoice :categorias="{{ $categoria }}" :clientes="{{ $cliente }}"></view-invoice>

            </div>
        </div>
    </div>




@endsection

@push('script')

    <script type="text/javascript" src="{{ url('js/app.js') }}"></script>

@endpush
