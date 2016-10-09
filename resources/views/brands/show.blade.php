@extends('layouts.dashboard')

@section('content')

@include('brands.partials.header', [
    'pageTitle' => $brand->name,
    'url' => '/brands/'.$brand->id
])
	<div class="container-fluid">
			<div class="row">

				<div class="container-fluid" >
					<img id="brandImageContainer" src="{{ $brand->image }}" alt="{{ $brand->name }}" width="100%">
				</div>	
			</div>
		    <div class="row">
		    	<div class="container-fluid">
			        <div class="col-md-3">
		        		<h3>{{ $brand->name }} </h3>
		        	</div>
		        	<div class="col-md-6">
		        		<p>
		        			{{ $brand->description }}
		        		</p>

			        </div>
			        <div class="col-md-2 vertical-center pull-right" style="padding-top:20px;">
			        	<a href="{{ url('/brands/'.$brand->id.'/edit') }}" alt="Editar Marca">
			       		<button id="send-btn" type="button" class="btn btn-circle green">Editar Marca</button>
			        	</a>
			        </div>\
		        </div>
		    </div>
		    <div class="row">
		    	<hr>
		    	<div class="container-fluid">
		    		<h3>Alterar foto de capa</h3>
		    		<p>
		    			Apenas arquivos .jpeg, .jpg, .png são aceitos e de até 2MB.
		    		</p>
		    		<br>
			    	<form id="brandImage" class="dropzone" method="POST" action="/brands/{{ $brand->id }}/photo">
			    		{{ csrf_field() }}
			    	</form>
		    	</div>
		    </div>
	</div>
@stop

@section('styles')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="/dashboard/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
@stop
@section('scripts')

	<script src="/dashboard/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script> 
	<script type="text/javascript" charset="utf-8">

		Dropzone.autoDiscover = false;

		var dropzoneOptions = {
			autoDiscover: false,
			maxFiles: 1,
			maxFileSize: 2,
			paramName: 'photo',
			acceptedFiles: '.jpeg, .jpg, .png',
			autoProcessQueue: false,
			dictDefaultMessage: 'Solte o arquivo aqui',

			success: function(file, response){
			  	$('img#brandImageContainer').attr("src", response);
			  	this.removeAllFiles(true);
		    },

		    init: function() {
			    this.on("maxfilesexceeded", function(file){
			    	toastr.warning('Número de arquivos excedido!', 'Você só pode inserir um arquivo');
			    });
			    this.on("error", function(file, errorMessage){
			    	console.log(errorMessage);
			    	toastr.error('Erro!', "Confira se o arquivo possui as características necessárias!");
			    	this.removeAllFiles(true);
			    });
		  	}	

		};

		var brandDropzone = new Dropzone("form#brandImage", dropzoneOptions);

		brandDropzone.accept = function(file, done) {

				bootbox.confirm("Tem certeza que quer mudar a imagem de capa da Marca?", function(result) {
					
					if(result){
						done();
						brandDropzone.processQueue();
					}else{
						brandDropzone.removeAllFiles(true);
						done(result);
					}

				}); 

		  };

	</script>



@stop
