@extends('layouts.dashboard')

@section('content')

    @include('lines.partials.header',[
        'pageTitle' => 'Crear Línea ',
        'url' => '/lines/create',
        'actions' => []
    ])

    <div class="container">
        <div class="row col-md-10">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-blue">
                        <i class="fa fa-plus font-blue"></i>Crear Línea
                    </div>
                </div>
                <div class="portlet-body form">
                    <line-form/>
                </div>
            </div>
        </div>
    </div>

@endsection