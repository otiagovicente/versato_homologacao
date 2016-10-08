@extends('layouts.dashboard')
@section('content')
    @include('macroregions.partials.header',[
        'pageTitle' => 'Clientes',
        'url' => '/macroregions',
        'actions' => []
    ])

    <div class="container-fluid">
        <div class="row">
            @foreach($customers as $customer)        
                <div class="container-fluid product-list-row">
                    <div class="col-md-2">
                        <img class="product-list-photo" src="{{$customer->logo}}" alt="{{$customer->code}}">
                    </div>
                    <div class="col-md-offset-1 col-md-3">
                        <h1>
                            <small>Cliente: </small>
                            {{$customer->code}}
                        </h1>
                    </div>
                    <div class="pull-right col-md-2">
                        <br>
                        <a href="/customers/{{$customer->id}}">
                            <button class="btn btn-block green">Visualizar</button>
                        </a>
                        <br>
                        <a href="/customers/{{$customer->id}}/edit">
                            <button class="btn btn-block blue">Editar</button>
                        </a>
                    </div>    
                </div>    
            @endforeach
        </div>
@stop

@section('styles')
    <style>
        div .product-list-photo{
            height: 150px;
            width: auto;
        }

        div .product-list-row{
            background-color: #FFFFFF;
            padding: 20px;
            margin-bottom: 15px;
        }
    </style>
@endsection