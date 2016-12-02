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
        'pageTitle' => 'Crear Color',
        'url' => '/colors/create',
        'actions' => [
            'Mostrar Todos' => '/colors',
        ]
    ])
    <div class="container-fluid">
        <color-form/>
    </div>
@stop