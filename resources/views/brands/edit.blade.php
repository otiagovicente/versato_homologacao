@extends('layouts.dashboard')

@section('content')
@include('brands.partials.header', [
    'pageTitle' => 'Editar Marca',
    'url' => '/brands/'.$brand->id.'/edit'
])
<div class="container">
    <div class="row">
        <div class="col-md-10">
            
            @include('brands.partials.form', [
            	'action' => 'edit', 
            	'sendButtonText' => 'Editar Marca'
            ])    

        </div>
    </div>
</div>
@endsection