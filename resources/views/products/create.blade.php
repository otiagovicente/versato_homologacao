@extends('layouts.dashboard')
@section('content')

@include('general.pageheader',[
    'section' => 'Productos',
    'pageTitle' => 'Crear Producto',
    'url' => '/products/create',
    'actions' => [
        'Mostrar Todos' => '/products',
        'Crear Producto' => '/products/create'
    ]
])

<div class="x_content">
    @include('products.partials.form', [
        'action' => 'create',
        'sendButtonText' => 'Criar Produto',

    ])
</div>

@stop