<div class="portlet light">

    <div class="portlet-title">
        <div class="caption font-blue">
        	@if($action==='edit')
            <i class="fa fa-pencil font-blue"></i>Editar Marca 
            @elseif($action==='create')
            <i class="fa fa-plus font-blue"></i>Criar Marca
            @endif
        </div>
    </div>

    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <div id="message-success" class="alert alert-success" data-success="all" role="alert" style="margin-top:10px; display:none">
		    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		    <span class="sr-only">Sucesso:</span>
		    Marca Atualizada!
        </div>


        <form id="form-brand" class="form-horizontal">

	    	{{ csrf_field() }}
	    	@if($action==='edit')
	        {{ method_field('PATCH') }}
	        @endif
           

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Marca</label>
                    <div class="col-md-6">
                      
                        <input type="text" name="name" class="form-control" placeholder="Nome da Marca" @if($action==='edit') value="{{ $brand->name }}" @endif>
                      
                        <div id="message-name" class="alert alert-danger" data-error="name" role="alert" style="margin-top:10px; display:none">
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <span class="sr-only">Erro:</span>
                          Você deve inserir um nome
                        </div>

                    </div>
                </div>
				
				<div class="form-group last">
                    <label class="col-md-3 control-label">Descrição</label>
                    <div class="col-md-6">
                      
                      	<textarea name="description" class="form-control" rows="3" placeholder="Descrição breve...">@if($action==='edit') {{ $brand->description }} @endif</textarea>
                        
                        <div id="message-description" class="alert alert-danger" data-error="description" role="alert" style="margin-top:10px; display:none">
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <span class="sr-only">Erro:</span>
                          Você deve inserir uma descrição
                        </div>

                    </div>
                </div>	

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="pull-right col-md-3">

                        <a href="{{ url('brands/') }}">
                            <button type="button" class="btn grey-salsa btn-outline">Cancelar</button>
                        </a>
                        <button id="send-btn" type="button" class="btn blue">Salvar</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>

</div>


@section('styles')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="/dashboard/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
@stop

@section('scripts')

	<script src="/dashboard/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script> 
   
	<!-- DATA CASTING & FORM SEND-->
    <script>
          $('#send-btn').on('click', function(event) {
                 
                var data = $('#form-brand').serialize();
                
                
                
                $.ajax({

                	@if($action==='edit')
			        type: "PATCH",
			        url: '{{ url('/brands/'.$brand->id) }}',
			        @elseif($action==='create')
			        type: "POST",
			        url: '{{ url('/brands') }}',
			        @endif

                     data: data,
                     success: function(response) {
                        toastr.success('Sucesso!','Marca atualizada com sucesso');
                        $('#message-name').fadeOut('fast');
                        $('#message-description').fadeOut('fast');
                     },
                     error: function(responseError) {

                        var errors = JSON.parse(responseError.responseText);
                        
                        $.each(errors, function(key, value){

                            if(key == 'name'){
                                $('#message-name').fadeOut(50, function(){
                                    $('div[data-error="name"]').fadeIn('fast');
                                    
                                });
                            }
                            if(key == 'description'){
                                $('#message-description').fadeOut(50, function(){
                                    $('div[data-error="description"]').fadeIn('fast');
                                    
                                });
                            }
                            
                        });




                    }
                });
                 return false;
                 

           });            
    </script>
@stop