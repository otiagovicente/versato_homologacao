@extends('layouts.dashboard')
@section('content')
    @include('macroregions.partials.header',[
        'pageTitle' => 'Macro Regiones '.session()->get('brand')->name,
        'url' => '/macroregions/',
        'actions' => []
    ])




@endsection