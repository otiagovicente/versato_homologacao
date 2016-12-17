@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Productos',
        'sectionUrl' => '/products',
        'pageTitle' => 'Produtos '.session()->get('brand')->name,
        'url' => '/products',
        'actions' => [
            'Mostrar Todos' => '/products',
            'Crear Producto' => '/products/create'
        ]
    ])
    <hr>
    <div class="md-col-12">
        <div class="row">
            <form action="/products/search">
                <div class="form-group form-line-input search">
                    <h4>Buscar</h4>
                    <div class="input-icon input-icon-lg right">
                        <i class="fa fa-search font-green"></i>
                        <input id="search-input" class="form-control input-lg" type="text" name="search">
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-5 pull-right">
                {{ $products->links() }}
            </div>
        </div>

    </div>
    <hr>
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