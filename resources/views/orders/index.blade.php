@extends('layouts.dashboard')

@section('content')
	@include('orders.partials.header',[
		'pageTitle' => 'Pedidos',
		'url' => '/orders',
		'actions' => []
	])
<div class="container-fluid"> 
			<list-orders></list-orders>
</div>
@stop
