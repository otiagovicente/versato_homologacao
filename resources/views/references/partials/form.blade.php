<div class="portlet light">

    <div class="portlet-title">
        <div class="caption font-blue">
        	@if($action==='edit')
            <i class="fa fa-pencil font-blue"></i>Editar Referência 
            @elseif($action==='create')
            <i class="fa fa-plus font-blue"></i>Criar Referência
            @endif
        </div>
    </div>

    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form id="form-reference" class="form-horizontal">

	    	{{ csrf_field() }}
	    	@if($action==='edit')
	        {{ method_field('PATCH') }}
	        @endif

            <input type="hidden" name="brand_id" value="{{Session::get('brand')->id}}">
            <div class="form-body">
                <div id="code-input" class="form-group">
                    <label class="col-md-3 control-label">Referência</label>
                    <div class="col-md-7">
                      
                        <input type="text" name="code" class="form-control input-circle " placeholder="Código da Referência" @if($action==='edit') value="{{ $reference->code }}" readonly="readonly" @endif>

                    </div>
                </div>
				
				<div id="description-input" class="form-group last">
                    <label class="col-md-3 control-label">Descrição</label>
                    <div class="col-md-7">

                      	<input type="text" name="description" class="form-control input-circle" rows="3" placeholder="Descrição" @if($action==='edit') value="{{ $reference->description }}"" @endif >

                    </div>
                </div>	

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="pull-right col-md-3">
                        <a href="{{ url('references/') }}">
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
    <!-- END PAGE LEVEL PLUGINS -->
@stop

@section('scripts')
   
	<!-- DATA CASTING & FORM SEND-->
    <script>
          $('#send-btn').on('click', function(event) {
                 
                var data = $('#form-reference').serialize();
                
                
                
                $.ajax({

                	@if($action==='edit')
			        type: "PATCH",
			        url: '{{ url('/references/'.$reference->id) }}',
			        @elseif($action==='create')
			        type: "POST",
			        url: '{{ url('/references') }}',
			        @endif

                     data: data,
                     success: function(response) {
                        toastr.success('Sucesso!','Referência atualizada com sucesso');
                        $('#code-input').removeClass('has-error');
                        $('#description-input').removeClass('has-error');
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