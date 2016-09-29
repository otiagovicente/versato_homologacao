@extends('layouts.dashboard')

@section('content')
    @include('regions.partials.header',[
        'pageTitle' => 'Crear regiones',
        'url' => '/regions/create',
        'actions' => []
    ])

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <regions-form :pmacroregions="{{$macroregions}}"></regions-form>
            </div>
        </div>
    </div>
@endsection