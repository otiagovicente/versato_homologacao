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
                <regions-form/>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo env('MAP_KEY');?>&callback=app.initMap&libraries=drawing">
</script>
@endsection