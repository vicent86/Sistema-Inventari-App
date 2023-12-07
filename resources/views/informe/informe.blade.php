@extends('include.master')


@section('title','Inventario | Informe')


@section('page-title','Informe')


@section('content')




    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>

                        Informe General

                    </h2>
                </div>


                <div class="body">


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('informe.store') }}" method="GET">

                        <div class="row">
                            <report-form :user="{{ $user }}" :cliente="{{ $cliente }}" :categoria="{{ $categoria }}" :proveedor="{{ $proveedor }}"></report-form>
                        </div>


                        <div class="row text-center">
                            <button type="submit" class="btn bg-teal">Dar Informe</button>
                        </div>


                    </form>

                </div>


            </div>
        </div>
    </div>




@endsection

@push('script')

    <script type="text/javascript" src="{{ url('public/js/informe.js') }}"></script>

@endpush
