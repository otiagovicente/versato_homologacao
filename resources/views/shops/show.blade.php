@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Tiendas',
        'sectionUrl' => '/shops',
        'pageTitle' => 'Tienda',
        'url' => '/shops',
        'actions' => [
            'Mostrar Todos' => '/shops',
            'Crear Tiendas' => '/shops/create'
        ]
    ])

    <div class="x_content">
        <shop-form :pshop="{{$shop}}" :isedit='false'></shop-form>
    </div>

@stop