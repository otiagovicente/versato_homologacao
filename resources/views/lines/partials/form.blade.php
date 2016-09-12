<div class="portlet light">

    <div class="portlet-title">
        <div class="caption font-blue">
        	@if($action==='edit')
            <i class="fa fa-pencil font-blue"></i>Editar Linha 
            @elseif($action==='create')
            <i class="fa fa-plus font-blue"></i>Criar Linha
            @endif
        </div>
    </div>

    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form id="form-line" class="form-horizontal">

	    	{{ csrf_field() }}
	    	@if($action==='edit')
	        {{ method_field('PATCH') }}
	        @endif
            <input type="hidden" name="brand_id" value="{{Session::get('brand')->id}}">

            <div class="form-body">
                <div id="code-input" class="form-group">
                    <label class="col-md-3 control-label">Linha</label>
                    <div class="col-md-6">
                      
                        <input type="text" name="code" class="form-control " placeholder="Código da Linha" @if($action==='edit') value="{{ $line->code }}" readonly="readonly" @endif>
                      
                        <div id="message-code" class="alert alert-danger" data-error="code" role="alert" style="margin-top:10px; display:none">
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <span class="sr-only">Erro:</span>
                          Você deve inserir um código
                        </div>

                    </div>
                </div>
				
				<div id="description-input" class="form-group last">
                    <label class="col-md-3 control-label">Descrição</label>
                    <div class="col-md-6">
                      
                      	<textarea  name="description" class="form-control" rows="3" placeholder="Descrição breve...">@if($action==='edit') {{ $line->description }} @endif</textarea>
                        
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
                    <div class="pull-right col-md-">

                        <a href="{{ url('lines/') }}">
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
                 
                var data = $('#form-line').serialize();
                
                
                
                $.ajax({

                	@if($action==='edit')
			        type: "PATCH",
			        url: '{{ url('/lines/'.$line->id) }}',
			        @elseif($action==='create')
			        type: "POST",
			        url: '{{ url('/lines') }}',
			        @endif

                     data: data,
                     success: function(response) {
                        toastr.success('Sucesso!','Linha atualizada com sucesso');
                     },
                     error: function(responseError) {

                        var errors = JSON.parse(responseError.responseText);
                        toastr.error('Erro!', 'Alguns dados não foram preenchidos corretamente');
                        $.each(errors, function(key, value){

                            if(key == 'code'){
                                toastr.error('Erro!', value);
                                $('#code-input').addClass('has-error');

                            }
                            if(key == 'description'){
                                toastr.error('Erro!', value);
                                $('#description-input').addClass('has-error');

                            }
                            
                        });




                    }
                });
                 return false;
                 

           });            
    </script>
@stop