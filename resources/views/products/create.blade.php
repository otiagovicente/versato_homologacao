@extends('layouts.dashboard')
@section('content')

@include('general.pageheader',[
    'section' => 'Productos',
    'sectionUrl' => '/products',
    'pageTitle' => 'Crear Producto',
    'url' => '/products/create',
    'actions' => [
        'Mostrar Todos' => '/products',
        'Crear Producto' => '/products/create'
    ]
])

<div class="x_content">
    <create-product></create-product>
</div>

@stop