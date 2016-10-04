@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Clientes',
        'sectionUrl' => '/customers',
        'pageTitle' => 'Crear Cliente',
        'url' => '/customers/create',
        'actions' => [
            'Mostrar Todos' => '/customers',
            'Crear Cliente' => '/customers/create'
        ]
    ])

    <div class="container-fluid">
        <div class="row">
            <create-customer></create-customer>
        </div>
    </div>

@endsection