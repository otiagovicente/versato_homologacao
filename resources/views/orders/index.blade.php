@extends('layouts.dashboard')

@section('content')
    @include('orders.partials.header',[
        'pageTitle' => 'Pedidos',
        'url' => '/orders',
        'actions' => []
    ])

	<div class="content-fluid" style="padding:20px;">
		<div class="row">
				
		</div>
	</div>
@stop