@extends('layouts.dashboard')

@section('content')
@include('references.partials.header', [
    'pageTitle' => 'Editar Referência',
    'url' => '/references/'.$reference->id.'/edit',
    'actions' => []
])
<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('references.partials.form', [
            	'action' => 'edit', 
            	'sendButtonText' => 'Salvar Referência'
            ])    

        </div>
    </div>
</div>
@endsection