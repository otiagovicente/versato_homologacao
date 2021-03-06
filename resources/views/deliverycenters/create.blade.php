@extends('layouts.dashboard')

@section('content')
@include('general.pageheader',[
    'section' => 'Centros de Entrega',
    'sectionUrl' => '/deliverycenters',
    'pageTitle' => 'Centros de Entrega',
    'url' => '/deliverycenters/create',
    'actions' => [
        'Mostrar Todos' => '/deliverycenters',
        'Crear Producto' => '/deliverycenters/create'
    ]
])
    <div class="container-fluid">
        <create-deliverycenter></create-deliverycenter>
    </div>
@endsection