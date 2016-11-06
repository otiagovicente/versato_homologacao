@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Representantes',
        'sectionUrl' => '/representatives',
        'pageTitle' => 'Editar Representante',
        'url' => '/representatives/'.$representative->id.'/edit',
        'actions' => [
            'Mostrar Todos' => '/representatives',
            'Crear Representante' => '/representatives/create'
        ]
    ])

    <div class="container-fluid">
        <div class="row">
            <create-representative :prepresentativeid="{{$representative->id}}"></create-representative>
        </div>
    </div>

@endsection