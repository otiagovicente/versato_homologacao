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
                <a href="/products/{{$product->id}}">
                    <div class="col-md-3">
                        <div class="product-index-product-box">
                            <div class="row">

                                <div class="col-md-12">
                                    <img class="product-index-list-photo" src="{{$product->photo}}" alt="{{$product->code}}">
                                </div>

                            </div>
                            <div class="row">
                                <h4>{{$product->line->description.' '.$product->material->description}}</h4>
                                <h5>{{$product->color->description}}</h5>
                            </div>
                        </div>



                    </div>
                </a>

                @endforeach
        </div>
    </div>
@stop

@section('styles')

    <style>

        .product-index-list-photo{

            width: 100%;

        }

        .product-index-product-box{

            background-color: #FFFFFF;
            border: 3px solid #ebeef0;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            text-align: center;



        }

    </style>



@endsection