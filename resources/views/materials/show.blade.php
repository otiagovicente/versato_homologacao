@extends('layouts.dashboard')

@section('content')
    @include('materials.partials.header',[
        'pageTitle' => 'Materiais',
        'url' => '/materials',
        'actions' => ['Editar Material' => '/materials/'.$material->id.'/edit']
    ])
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">

                <div class="col-md-3" style="height:200px; text-align:center; padding-top:10px;">
                    <img src="{{ $material->sample }}" alt="{{ $material->description }}" style="width:100%;">
                </div>
                <div class="col-md-7">
                    <h1>{{ $material->code }}</h1>
                    <h2>{{ $material->description }}</h2>

                    
                </div>
                
                

            </div>
            <div class="col-md-12">
                <list-products :id="{{$material->id}}" type="material"></list-products>
            </div>
        </div>
    </div>
@stop