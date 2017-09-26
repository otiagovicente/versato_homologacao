@extends('layouts.dashboard')

@section('content')
@include('materials.partials.header',[
    'pageTitle' => 'Materiais',
    'url' => '/materials',
    'actions' => []
])

	<div class="content-fluid" style="padding:20px;">
		<div class="row">
				@foreach($materials as $material)
				<a href="{{ url('/materials/'.$material->id) }}" style="color:black;">
					<div class="col-md-3" style=" padding-top:20px; padding-bottom:20px; margin:10px; box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);">

							<div class="container" style="width:100%; height:180px;">
								<img src="{{ $material->sample }}" alt="{{ $material->description }}" style="width:100%; height:100%">
							</div>
							<hr>
							<div style="text-align:right; overflow: hidden; height: 52px;">
							<span>
								<span><small>{{ $material->description }}</small></span>
								<span class="h2" style="padding-left:10px;">{{ $material->code }}</span>
								
							</span>
							</div>

					</div>
				</a>
				
				@endforeach

		</div>
	</div>




@stop