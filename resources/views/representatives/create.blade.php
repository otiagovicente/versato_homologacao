@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Representantes',
        'sectionUrl' => '/representatives',
        'pageTitle' => 'Crear Representante',
        'url' => '/representatives/create',
        'actions' => [
            'Mostrar Todos' => '/representatives',
            'Crear Producto' => '/representatives/create'
        ]
    ])

<div class="container-fluid">
    <div class="row">
        <create-representative></create-representative>
    </div>
</div>

@endsection