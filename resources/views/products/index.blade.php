@extends('layouts.dashboard')
@section('content')
    @include('products.partials.header',[
        'pageTitle' => 'Produtos '.session()->get('brand')->name,
        'url' => '/products/',
        'actions' => []
    ])
    <hr>
    {{ $products->links() }}
    <hr>
    <div class="container-fluid">
        <div class="row">

                @foreach($products as $product)
                    
                    <div class="container-fluid product-list-row">
                        <div class="col-md-2">
                            <img class="product-list-photo" src="{{$product->photo}}" alt="{{$product->code}}">
                        </div>
                        <div class="col-md-offset-1 col-md-3">
                            <h1>
                                <small>Código:</small>
                                {{$product->code}}
                            </h1>
                        </div>
                        <div class="pull-right col-md-2">
                            <br>
                            <a href="/products/{{$product->id}}">
                                <button class="btn btn-block green">Visualizar</button>
                            </a>
                            <br>
                            <a href="/products/{{$product->id}}/edit">
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