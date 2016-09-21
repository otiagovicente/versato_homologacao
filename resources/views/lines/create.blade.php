@extends('layouts.dashboard')

@section('content')
@include('lines.partials.header',[
    'pageTitle' => 'Criar Linha',
    'url' => '/lines/create',
    'actions' => []
])

<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('lines.partials.form', [
            'action' => 'create',
            'sendButtonText' => 'Criar Linha'

            ])    

        </div>
    </div>
</div>
@endsection