@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Clientes',
        'sectionUrl' => '/customers',
        'pageTitle' => $customer->name,
        'url' => '/customers/'.$customer->id,
        'actions' => [
            'Mostrar Todos' => '/customers',
            'Crear Cliente' => '/customers/create',
            'Editar Cliente' => '/customers/'.$customer->id.'/edit'
        ]
    ])

    <div class="container-fluid">
        <div class="row">
            <show-customer :pcustomer_id="{{$customer->id}}"></show-customer>
        </div>
    </div>

@endsection

@section('scripts')
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo env('MAP_KEY');?>&callback=app.initMap&libraries=places">
    </script>
@endsection