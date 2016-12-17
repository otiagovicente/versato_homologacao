@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Clientes',
        'sectionUrl' => '/customers',
        'pageTitle' => 'Mostrar',
        'url' => '/customers',
        'actions' => [
            'Mostrar Todos' => '/customers',
            'Crear Cliente' => '/customers/create'
        ]
    ])


    <div class="container-fluid">

        <list-customers></list-customers>

    </div>

@stop

