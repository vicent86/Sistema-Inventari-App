@extends('include.master')

@section('title','Inventario | Productos')

@section('page-title','Lista de productos')

@section('content')

    <div class="row clearfix">
        <create-product :categorias="{{ json_encode($categoria) }}"></create-product>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-product">
                            Producto nuevo
                        </button>
                    </h2>
                </div>

                <view-product :categorias="{{ json_encode($categoria) }}"></view-product>

            </div>
        </div>
    </div>

@endsection

@push('script')

    <script type="text/javascript" src="{{ url('js/app.js') }}"></script>

@endpush
