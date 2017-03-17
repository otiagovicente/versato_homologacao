@extends('layouts.dashboard')

@section('content')

@include('brands.partials.header', [
    'pageTitle' => 'Mostrar Todos',
    'url' => '/brands'
])
	<div class="container-fluid">

		@foreach($brands as $brand)
			<div class="row">

				<div class="container-fluid" >
					<img src="{{ $brand->image }}" alt="{{ $brand->name }}" width="100%">
				</div>	
			</div>
		    <div class="row">
		    	<div class="container-fluid">
			        <div class="col-md-3">
		        		<h3>{{ $brand->name }} </h3>
		        	</div>
		        	<div class="col-md-5">
		        		<p>
		        			{{ $brand->description }}
		        		</p>

			        </div>
			        <div class="col-md-3 vertical-center pull-right" style="padding-top:20px;">
			        	<a href="{{ url('/brands/'.$brand->id.'/edit') }}" alt="Editar Marca">
			       		<button id="send-btn" type="button" class="btn btn-circle green">Editar Marca</button>
			        	</a>
			        	<a href="{{ url('/brands/'.$brand->id) }}" alt="Editar Marca">
			       		<button id="send-btn" type="button" class="btn btn-circle blue-sharp">Visualizar</button>
			        	</a>
			        </div>
		        </div>
		    </div>
		    <div class="row">
		    	<hr>
		    </div>

	    @endforeach
	</div>
@endsection