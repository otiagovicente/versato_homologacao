@extends('layouts.dashboard')

@section('styles')
    <link href="/dashboard/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
@stop
@section('scripts')
    <script src="/dashboard/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
    <script src="/dashboard/pages/scripts/components-color-pickers.js" type="text/javascript"></script>
@stop

@section('content')
    @include('general.pageheader',[
        'section' => 'Colores',
        'sectionUrl' => '/colors',
        'pageTitle' => 'Editar Color',
        'url' => '/colors/'.$color->id.'/edit',
        'actions' => [
            'Mostrar Todos' => '/colors',
            'Crear Color' => '/colors/create',
        ]
    ])

    <div class="container">
        <div class="row col-md-10">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-blue">
                        <i class="fa fa-plus font-blue"></i>Editar Color
                    </div>
                </div>
                <div class="portlet-body form">
                    <color-form :pcolor="{{$color}}"/>
                </div>
            </div>
        </div>
    </div>

@stop