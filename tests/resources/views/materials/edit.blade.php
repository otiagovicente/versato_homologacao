@extends('layouts.dashboard')

@section('content')

    @include('materials.partials.header',[
        'pageTitle' => 'Editar Material',
        'url' => '/materials/'.$material->id.'/edit',
        'actions' => []
    ])

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                
                @include('materials.partials.form', [
                'action' => 'edit',
                'sendButtonText' => 'Salvar Material'
                ])    

            </div>
        </div>
    </div>


@stop