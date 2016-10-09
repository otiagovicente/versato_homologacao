@extends('layouts.dashboard')

@section('content')

	@include('references.partials.header', [
	    'pageTitle' => $reference->code.' - '.$reference->description,
	    'url' => '/references/'.$reference->id
	])
	<div class="container-fluid">
		    <div class="row">
		    	<div class="container-fluid">
			        <div class="col-md-3">
		        		<h3>{{ $reference->code }} </h3>
		        	</div>
		        	<div class="col-md-6">
		        		<p>
		        			{{ $reference->description }}
		        		</p>

			        </div>
			        <div class="col-md-2 vertical-center pull-right" style="padding-top:20px;">
			        	<a href="{{ url('/references/'.$reference->id.'/edit') }}" alt="Editar Marca">
			       		<button id="send-btn" type="button" class="btn btn-circle green">Editar Referência</button>
			        	</a>
			        </div>
		        </div>
		    </div>

	</div>
@stop