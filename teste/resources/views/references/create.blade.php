@extends('layouts.dashboard')

@section('content')
@include('references.partials.header',[
    'pageTitle' => 'Criar Referência',
    'url' => '/references/create',
    'actions' => []
])
<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('references.partials.form', [
            'action' => 'create',
            'sendButtonText' => 'Criar Referência'

            ])    

        </div>
    </div>
</div>
@endsection