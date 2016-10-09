@extends('layouts.dashboard')

@section('content')
@include('macroregions.partials.header',[
    'pageTitle' => 'Criar macroregions',
    'url' => '/macroregions/create',
    'actions' => []
])

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <macroregions-form/>
        </div>
    </div>
</div>
@endsection