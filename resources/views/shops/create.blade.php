@extends('layouts.dashboard')
@section('content')

@include('general.pageheader',[
    'section' => 'Tiendas',
    'sectionUrl' => '/shops',
    'pageTitle' => 'Crear Tienda',
    'url' => '/shops/create',
    'actions' => [
        'Mostrar Todos' => '/shops',
        'Crear Tiendas' => '/shops/create'
    ]
])

<div class="x_content">

    <shop-form></shop-form>

</div>

@stop