@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Productos',
        'sectionUrl' => '/products',
        'pageTitle' => 'Editar Producto',
        'url' => '/products/'.$product->id.'/edit',
        'actions' => [
            'Mostrar Todos' => '/products',
            'Crear Producto' => '/products/create'
        ]
    ])

    <div class="x_content">

        <create-product :pproductid="{{$product->id}}"></create-product>

    </div>

@stop