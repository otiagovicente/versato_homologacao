@extends('layouts.dashboard')

@section('content')
	@include('orders.partials.header',[
		'pageTitle' => 'Pedidos',
		'url' => '/orders',
		'actions' => []
	])
	<div class="content-fluid" style="padding:20px;">
		<div class="row">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Representante</th>
                    <th>Cliente</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Desc. Cliente</th>
                    <th>Desc. Representante
                    <th>Qtd. Productos</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{$order->id}}</td>
                        <td>{{$order->representative->user->name}}</td>
                        <td>{{$order->customer->name}}</td>
                        <td>${{$order->cost}}</td>
                        <td>${{$order->price}}</td>
                        <td>{{$order->client_discount}}</td>
                        <td>{{$order->representative_discount}}</td>
                        <td>{{count($order->products)}}</td>
                        <td>${{$order->total}}</td>
                        <td>
                            <a class="btn blue btn-outline sbold"
                               data-toggle="modal"
                               href="/orders/{{$order->id}}/edit"
                            >
                                Editar
                            </a>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            {{ $orders->links() }}
        </div>
	</div>
@stop