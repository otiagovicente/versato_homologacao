@extends('layouts.dashboard')

@section('content')
@include('colors.partials.header',[
    'pageTitle' => $color->code.' - '.$color->color,
    'url' => '/colors/'.$color->id,
    'actions' => ['Editar Cor' => '/colors/'.$color->id.'/edit']
])
<div class="container">
    <div class="row">
        <div class="col-md-10">

            <div class="col-md-3" style="background-color:{{ $color->color }}; height:200px; text-align:center; padding-top:50px;">
                <h1 class="thick" style="color:white;"><bold>{{ $color->color }}</bold></h1>
            </div>
            <div class="col-md-7">
                <h1>{{ $color->code }}</h1>
                <h2>{{ $color->description }}</h2>
                <h2>{{ $color->pantone }}</h2>
                
            </div>
            
            

        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <list-products :id="{{$color->id}}" type="color"></list-products>
        </div>
    </div>
</div>
@endsection