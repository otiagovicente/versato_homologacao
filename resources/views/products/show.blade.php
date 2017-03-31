@extends('layouts.dashboard')
@section('content')
    @include('general.pageheader',[
        'section' => 'Productos',
        'sectionUrl' => '/products',
        'pageTitle' => 'Produto ',
        'url' => '/products/'.$product->id,
        'actions' => [
            'Mostrar Todos' => '/products',
            'Crear Producto' => '/products/create',
            'Editar Producto' => '/products/'.$product->id.'/edit'
        ]
    ])
    <div class="container">
        <div class="row">

                <div class="content-fluid">
                    <div class="portlet light">

                        <div class="portlet-title">
                            <div class="caption font-blue">
                                <h2>
                                    {{ $product->line->description.' '.$product->material->description.' '.$product->color->description }}
                                </h2>
                            </div>
                        </div>

                        <div class="portlet-body">
                                <div class="row">
                                    <br>
                                    <div class="col-md-3">
                                        <div id="photo-input" class="form-group">
                                            <div class="">

                                                <img id="photo-image" src="{{ $product->photo }}" class="figure-img img-fluid img-rounded" alt="sem imagem do produto." style="width:200px;">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group form-line-input" id="line-input">
                                            <small class="font-blue">Linha</small><br>
                                            <span>{{$product->line->description}}</span>




                                        </div>

                                        <div class="form-group form-line-input " id="material-input">
                                            <small class="font-blue">Material</small><br>
                                            <span>{{$product->material->description}}</span>
                                        </div>
                                        <div class="form-group form-line-input" id="color-input">
                                            <small class="font-blue">Cor</small><br>
                                            <div style="align-content: stretch; width:90%;">


                                                <div style="display: inline-block; border: 3px solid {{$product->color->color}}; height: 40px; width:100%; margin: 0px; position: relative;">
                                                    <div style="display: inline-block; background-color: {{$product->color->color}}; height: 100%; width: 80px; margin: 0px;">
                                                    </div>
                                                    <span style="position: absolute; bottom: 1; right: 5%; font-weight: bolder; font-style: italic; font-size: 24pt; color: {{$product->color->color}};">{{$product->color->description}}</span>
                                                </div>

                                            </div>



                                        </div>
                                        <div class="form-group form-line-input" id="launch-input">
                                            <small class="font-blue">Lançamento</small><br>
                                            <span>{{$product->launch->format('d/M/Y')}}</span>
                                        </div>
                                        <div class="form-group form-line-input" id="published-input">
                                            <small class="font-blue">Publicado?</small><br>
                                            <span>@if($product->published) Sim @else Não @endif</span>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-line-input">
                                            <small class="font-blue">Custo</small><br>
                                            <span>{{$product->cost}}</span>
                                        </div>
                                        <div class="form-group form-line-input">
                                            <small class="font-blue">Preço</small><br>
                                            <span>{{$product->price}}</span>
                                        </div>
                                        <div class="form-group form-line-input">
                                            <small class="font-blue">Grades</small>
                                            <ul class="list-group" style="width:50%;">
                                                @foreach($product->grids as $grid)
                                                    <li class="list-group-item">{{$grid->description}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="form-group form-line-input">
                                            <small class="font-blue">Tags</small>
                                            <ul class="list-group " style="width:50%;">
                                                @foreach($product->tags as $tag)
                                                   <li class="list-group-item">{{$tag->description}}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="container-fluid">

                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>

@stop


