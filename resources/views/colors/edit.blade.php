@extends('layouts.dashboard')

@section('content')
@include('colors.partials.header',[
    'pageTitle' => 'Editar Cor',
    'url' => '/colors/'.$color->id.'/edit',
    'actions' => []
])
<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('colors.partials.form', [
            'action' => 'edit',
            'sendButtonText' => 'Salvar Cor'
            ])    

        </div>
    </div>
</div>
@endsection