@extends('layouts.dashboard')
@section('content')
    @include('macroregions.partials.header',[
        'pageTitle' => 'Clientes',
        'url' => '/macroregions',
        'actions' => []
    ])

    <div class="container-fluid">

        <list-customers></list-customers>

    </div>

@stop

