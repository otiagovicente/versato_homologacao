@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Clientes',
        'sectionUrl' => '/customers',
        'pageTitle' => 'Editar Cliente',
        'url' => '/customers/editar/{{customer->id}}/edit',
        'actions' => [
            'Mostrar Todos' => '/customers',
            'Crear Cliente' => '/customers/create'
        ]
    ])

    <div class="container-fluid">
        <div class="row">
            <edit-customer :pcustomer="{{$customer}}"></create-customer>
        </div>
    </div>

@endsection