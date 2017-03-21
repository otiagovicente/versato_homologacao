@extends('layouts.dashboard')
@section('content')

	@include('general.pageheader',[
        'section' => 'Colores',
        'sectionUrl' => '/colors',
        'pageTitle' => 'Colores de '.session()->get('brand')->name,
        'url' => '/colors/',
        'actions' => [
            'Mostrar Todas' => '/colors',
            'Crear Color' => '/colors/create'
        ]
    ])

	<div class="x_content">

		<colors-list></colors-list>

	</div>

@stop

{{--@include('colors.partials.header',[--}}
    {{--'pageTitle' => 'Mostrar Todas',--}}
    {{--'url' => '/colors',--}}
    {{--'actions' => []--}}
{{--])--}}
	{{--<div class="content-fluid" style="padding:20px;">--}}
		{{--<div class="row">--}}
				{{--@foreach($colors as $color)--}}
				{{--<a href="{{ url('/colors/'.$color->id) }}" style="color:black;">--}}
					{{--<div class="col-md-3" style=" padding-top:20px; padding-bottom:20px; margin:10px; box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);">--}}

							{{--<div style="width:100%; height:180px; background-color:{{ $color->color }};">&nbsp;</div>--}}
							{{--<hr>--}}
							{{--<div style="text-align:right;">--}}
							{{--<span>--}}
								{{--<span><small>{{ $color->description }}</small></span>--}}
								{{--<span class="h2" style="padding-left:10px;">{{ $color->code }}</span>--}}
								{{----}}
							{{--</span>--}}
							 {{--<br><br>--}}
							{{--</div>--}}
							{{--<div>--}}
								{{--<div style="display:block; text-align:right; padding-right:5px;">{{ $color->pantone }}</div>--}}
							{{--</div>--}}

					{{--</div>--}}
				{{--</a>--}}
				{{----}}
				{{--@endforeach--}}

		{{--</div>--}}
	{{--</div>--}}

{{--@endsection--}}