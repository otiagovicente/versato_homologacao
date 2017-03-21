@extends('layouts.dashboard')
@section('content')

    @include('general.pageheader',[
        'section' => 'Tareas',
        'sectionUrl' => '/grids',
        'pageTitle' => $grid->description,
        'url' => '/grids/'.$grid->id,
        'actions' => [
            'Mostrar Todos' => '/grids',
            'Crear Tarea' => '/grids/create'
        ]
    ])

    <div class="x_content">
        <show-grid :id="{{$grid->id}}"></show-grid>
    </div>

@stop