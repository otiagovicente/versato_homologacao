@extends('layouts.dashboard')

@section('content')
@include('brands.partials.header',[
    'pageTitle' => 'Criar Marca',
    'url' => '/brands/create'
])
    <div class="row">
        <div class="col-md-10">
            <create-brand></create-brand>
        </div>
    </div>
@endsection