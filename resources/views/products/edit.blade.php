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

    <div class="container-fluid">

        {{$product->id}}


        <create-product :pproductid="{{$product->id}}"></create-product>

    </div>

@stop