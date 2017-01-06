@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Productos',
        'sectionUrl' => '/products',
        'pageTitle' => 'Produtos '.session()->get('brand')->name,
        'url' => '/products',
        'actions' => [
            'Mostrar Todos' => '/products',
            'Crear Producto' => '/products/create'
        ]
    ])
    <hr>

    <list-products></list-products>
@endsection
