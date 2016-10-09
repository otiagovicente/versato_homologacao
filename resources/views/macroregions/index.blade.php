@extends('layouts.dashboard')
@section('content')
    @include('macroregions.partials.header',[
        'pageTitle' => 'Macro Regiones '.session()->get('brand')->name,
        'url' => '/macroregions/',
        'actions' => []
    ])

    <div class="container-fluid">
        <div class="row">
            @foreach($macroregions as $macroregion)        
                <div class="container-fluid product-list-row">
                    <div class="col-md-2">
                        <img class="product-list-photo" src="/images/macroregions/route_128.png" alt="{{$macroregion->code}}">
                    </div>
                    <div class="col-md-offset-1 col-md-3">
                        <h1>
                            <small>Macro Region: </small>
                            {{$macroregion->code}}
                        </h1>
                    </div>
                    <div class="pull-right col-md-2">
                        <br>
                        <a href="/macroregions/{{$macroregion->id}}">
                            <button class="btn btn-block green">Visualizar</button>
                        </a>
                        <br>
                        <a href="/macroregions/{{$macroregion->id}}/edit">
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