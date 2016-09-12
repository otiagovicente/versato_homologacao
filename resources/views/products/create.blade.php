@extends('layouts.dashboard')
@section('content')
@include('products.partials.header',[
    'pageTitle' => 'Criar Produto',
    'url' => '/products/create',
    'actions' => []
])

<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('products.partials.form', [
            	'action' => 'create', 
            	'sendButtonText' => 'Criar Produto',

            ])    

        </div>
    </div>
</div>

@stop