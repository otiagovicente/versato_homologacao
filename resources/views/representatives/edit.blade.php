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
            <edit-representative :representative_id="{{$representative->id}}"></edit-representative>
        </div>
    </div>

@endsection