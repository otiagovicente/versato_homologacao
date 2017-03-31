@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Representantes',
        'sectionUrl' => '/representatives',
        'pageTitle' => 'Versato App',
        'url' => '/representatives/grantaccess',
        'actions' => [
            'Mostrar Todos' => '/representatives',
            'Crear Representante' => '/representatives/create',
            'Editar Representante' => '/representatives/'.$representative->id.'/edit'
        ]
    ])

    <div class="container-fluid">
        <div class="row">
            <grant-access-to-versato-app :representativeid="{{$representative->id}}"></grant-access-to-versato-app>
        </div>
    </div>

@endsection