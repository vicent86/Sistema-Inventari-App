@extends('include.master')


@section('title','Inventario | Existencias')


@section('page-title','Lista de Existencias')


@section('content')


    <div class="row clearfix">

        <create-stock :date="{{ json_encode(date('Y-m-d')) }}" :proveedores="{{ $proveedor }}" :categorias="{{ $categoria }}"></create-stock>

    </div>


    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-stock">
                            Agregar Existencias
                        </button>
                    </h2>
                </div>

                <view-stock :proveedores="{{ $proveedor }}" :categorias="{{ $categoria }}" :productos="{{ $producto }}"></view-stock>

            </div>
        </div>
    </div>


@endsection

@push('script')

    <script type="text/javascript" src="{{ url('public/js/stock.js') }}"></script>

@endpush
