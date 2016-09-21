@extends('layouts.dashboard')

@section('content')

@include('lines.partials.header', [
    'pageTitle' => 'Editar Linha',
    'url' => '/lines/'.$line->id.'/edit',
    'actions' => []
])

<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('lines.partials.form', [
            	'action' => 'edit', 
            	'sendButtonText' => 'Editar Linha'
            ])    

        </div>
    </div>
</div>
@endsection