@extends('layouts.dashboard')

@section('content')

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

@endsection