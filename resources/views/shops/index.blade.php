@extends('layouts.dashboard')
@section('content')
    @include('shops.partials.header',[
        'pageTitle' => 'Tiendas',
        'url' => '/shops',
        'actions' => []
    ])
    <hr>
    
    <hr>
    <div class="container-fluid">
        <div class="row">
                @foreach($shops as $shop)
                    <div class="container-fluid shop-list-row">
                        <div class="col-md-2">
                            <img class="shop-list-logo" src="{{$shop->logo}}" alt="{{$shop->name}}">
                        </div>
                        <div class="col-md-offset-1 col-md-3">
                            <h1>
                                <small>Tienda:</small>
                                {{$shop->name}}
                            </h1>
                        </div>
                        <div class="pull-right col-md-2">
                            <br>
                            <a href="/shops/{{$shop->id}}">
                                <button class="btn btn-block green">Visualizar</button>
                            </a>
                            <br>
                            <a href="/shops/{{$shop->id}}/edit">
                                <button class="btn btn-block blue">Editar</button>
                            </a>
                        </div>
                    </div>
                @endforeach
        </div>
    </div>
@stop

@section('styles')
    <style>
        div .shop-list-logo{
            height: 150px;
            width: auto;
        }
        div .shop-list-row{
            background-color: #FFFFFF;
            padding: 20px;
            margin-bottom: 15px;
        }
    </style>
@endsection