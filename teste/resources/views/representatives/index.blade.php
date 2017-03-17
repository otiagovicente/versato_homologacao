@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Representantes',
        'sectionUrl' => '/representatives',
        'pageTitle' => 'Mostrar Representantes',
        'url' => '/representatives',
        'actions' => [
            'Mostrar Todos' => '/representatives',
            'Crear Representante' => '/representatives/create'
        ]
    ])

    <div class="container-fluid">
        <div class="row">
            <list-representatives></list-representatives>
        </div>
    </div>

@endsection