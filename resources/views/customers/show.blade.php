@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Clientes',
        'sectionUrl' => '/customers',
        'pageTitle' => $customer->name,
        'url' => '/customers/editar/{{customer->id}}/edit',
        'actions' => [
            'Mostrar Todos' => '/customers',
            'Crear Cliente' => '/customers/create'
        ]
    ])

    <div class="container-fluid">
        <div class="row">
            <show-customer :pcustomer_id="{{$customer->id}}"></show-customer>
        </div>
    </div>

@endsection