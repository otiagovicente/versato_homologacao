@extends('layouts.dashboard')

@section('content')
@include('colors.partials.header',[
    'pageTitle' => 'Criar Cor',
    'url' => '/colors/create',
    'actions' => []
])
<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('colors.partials.form', [
            'action' => 'create',
            'sendButtonText' => 'Criar Cor'
            ])    

        </div>
    </div>
</div>
@endsection