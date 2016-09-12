@extends('layouts.dashboard')
@section('content')
    @include('products.partials.header',[
        'pageTitle' => 'Editar Produto',
        'url' => '/products/edit'.$product->id,
        'actions' => []
    ])

    <div class="container">
        <div class="row">
            <div class="col-md-10">

                @include('products.partials.form', [
                    'action' => 'edit',
                    'sendButtonText' => 'Editar Produto',

                ])

            </div>
        </div>
    </div>

@stop