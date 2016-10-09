@extends('layouts.dashboard')

@section('content')

	@include('references.partials.header', [
	    'pageTitle' => 'Mostrar Todas',
	    'url' => '/references'
	])
	<div class="container-fluid">
		@foreach($references as $reference)
		    <div class="row">
		    	<div class="container-fluid">
				        <div class="col-md-3">
			        		<h2>{{ $reference->code }} </h2>
			        		<p>{{ $reference->description }}</p>
		        		</div>
		        		<div class="col-md-offset-10">
			        		<div class="" style="padding-top:20px;">
					        	<a href="{{ url('/references/'.$reference->id.'/edit') }}" alt="Editar Referência">
					       		<button id="send-btn" type="button" class="btn btn-circle blue">Editar Referência</button>
					        	</a>
				        	</div>
				        </div>
		        </div>
		    </div>
		@endforeach
	</div>
@stop