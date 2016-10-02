@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Representantes',
        'sectionUrl' => '/customers',
        'pageTitle' => 'Crear Representante',
        'url' => '/customers/create',
        'actions' => [
            'Mostrar Todos' => '/customers',
            'Crear Cliente' => '/customers/create'
        ]
    ])

    <div class="container-fluid">
        <div class="row">
            <create-representative></create-representative>
        </div>
    </div>

@endsection