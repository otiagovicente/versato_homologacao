@extends('layouts.dashboard')

@section('content')

@include('lines.partials.header',[
        'pageTitle' => 'Editar Línea ',
        'url' => '/lines/create',
        'actions' => []
    ])

    <div class="container">
        <div class="row col-md-10">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-blue">
                        <i class="fa fa-plus font-blue"></i>Editar Línea
                    </div>
                </div>
                <div class="portlet-body form">
                    <line-form :pline="{{$line}}"></line-form>
                </div>
            </div>
        </div>

        <div class="portlet-body form">
            <line-form :pline="{{$line}}"></line-form>
        </div>

    </div>

@endsection