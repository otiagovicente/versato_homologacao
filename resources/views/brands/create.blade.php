@extends('layouts.dashboard')

@section('content')
@include('brands.partials.header',[
    'pageTitle' => 'Criar Marca',
    'url' => '/brands/create'
])
<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('brands.partials.form', [
            'action' => 'create',
            'sendButtonText' => 'Criar Marca'

            ])    

        </div>
    </div>
</div>
@endsection