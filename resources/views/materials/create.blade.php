@extends('layouts.dashboard')

@section('content')
@include('materials.partials.header',[
    'pageTitle' => 'Criar Material',
    'url' => '/materials/create',
    'actions' => []
])

<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('materials.partials.form', [
            'action' => 'create',
            'sendButtonText' => 'Criar Material'
            ])    

        </div>
    </div>
</div>


@stop