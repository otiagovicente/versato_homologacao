@extends('layouts.dashboard')
@section('content')
    @include('general.pageheader',[
        'section' => 'Vendas',
        'sectionUrl' => '/orders',
        'pageTitle' => 'Relatório de Pedido',
        'url' => '/orders/create',
        'actions' => [
            'Mostrar Todos' => '/orders',
            'Crear Pedido' => '/orders/create'
        ]
    ])
    <div class="x_content">
        <order-report-by-customer></order-report-by-customer>
    </div>
@stop
