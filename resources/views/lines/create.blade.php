@extends('layouts.dashboard')

@section('content')
@include('lines.partials.header',[
    'pageTitle' => 'Crear Linea ',
    'url' => '/lines/create',
    'actions' => []
])

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <line-form/>
        </div>
    </div>
</div>
@endsection