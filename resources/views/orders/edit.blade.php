@extends('layouts.dashboard')
@section('content')
    @include('general.pageheader',[
        'section' => 'Vendas',
        'sectionUrl' => '/orders',
        'pageTitle' => 'Crear Pedido',
        'url' => '/orders/create',
        'actions' => [
            'Mostrar Todos' => '/orders',
            'Crear Pedido' => '/orders/create'
        ]
    ])
    <div class="x_content">
        <order-form :porder='{{$order}}'></order-form>
    </div>
@stop