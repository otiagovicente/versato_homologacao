@extends('layouts.dashboard')
@section('content')
    @include('macroregions.partials.header',[
        'pageTitle' => 'Macro Regiones '.session()->get('brand')->name,
        'url' => '/macroregions/',
        'actions' => []
    ])

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <macroregions-form :pmacroregion="{{$macroregion}}" :isedit='true'></<macroregions-form>
            </div>
        </div>
    </div>


@endsection