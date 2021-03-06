@extends('layouts.dashboard')

@section('content')
{{--@include('macroregions.partials.header',[--}}
    {{--'pageTitle' => 'Criar macroregions',--}}
    {{--'url' => '/macroregions/create',--}}
    {{--'actions' => []--}}
{{--])--}}

<div class="container-fluid">
            <macroregions-form />
</div>
@endsection

@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo env('MAP_KEY');?>&callback=app.initMap&libraries=drawing">
    </script>
@endsection