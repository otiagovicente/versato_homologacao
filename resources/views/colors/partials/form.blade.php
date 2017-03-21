<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-blue">
        	@if($action==='edit')
            <i class="fa fa-pencil font-blue"></i>Editar Cor 
            @elseif($action==='create')
            <i class="fa fa-plus font-blue"></i>Criar Cor
            @endif
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form id="form-color" class="form-horizontal">
            <input type="hidden" name="brand_id" value="{{session()->get('brand')->id}}">
	    	{{ csrf_field() }}
	    	@if($action==='edit')
	        {{ method_field('PATCH') }}
	        @endif
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div id="code-input" class="form-group form-line-input">
                            <label class="col-md-3 control-label">Código</label>
                            <div class="col-md-5">
                              
                                <input type="text" name="code" class="form-control" placeholder="Código da Cor" @if($action==='edit') value="{{ $color->code }}" readonly="readonly" @endif>
                              
                            </div>
                        </div>
        				
        				<div id="description-input" class="form-group form-line-input">
                            <label class="col-md-3 control-label">Descrição</label>
                            <div class="col-md-5">
                              
                              	<input type="text" name="description" class="form-control" placeholder="Nome da Cor"@if($action==='edit') value="{{ $color->description }}" @endif >

                            </div>
                        </div>	
                    </div>
                    <div class="col-md-6 pull-right">
                        <div id="color-input" class="form-group form-line-input">
                            <label class="col-md-2 control-label">Cor</label>
                            <div class="col-md-6">
                                <input type="text" name="color" id="color-selector" class="form-control demo" data-control="hue" value="@if($action==='edit') {{ $color->color }} @endif"> 

                            </div>
                        </div>
                        <div id="pantone-input" class="form-group form-line-input">
                            <label class="col-md-2 control-label">Pantone</label>
                            <div class="col-md-6">
                                <input type="text" name="pantone" id="pantone" class="form-control " data-control="hue" value="@if($action==='edit') {{ $color->pantone }} @endif"> 

                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="pull-right col-md-3">
                        <a href="{{ url('colors/') }}">
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
    <link href="/dashboard/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
@stop

@section('scripts')
    <script src="/dashboard/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
	<!-- DATA CASTING & FORM SEND-->
    <script src="/dashboard/pages/scripts/components-color-pickers.js" type="text/javascript"></script>
    <script>
        $('#color').minicolors({
            change: function(value, opacity) {
                console.log(value + ' - ' + opacity);
            }
        });

        $('#send-btn').on('click', function(event) {         
            var data = $('#form-color').serialize();
            $.ajax({
            	@if($action==='edit')
                type: "PATCH",
                url: '{{ url('/colors/'.$color->id.'/edit') }}',
                @elseif($action==='create')
                type: "POST",
                url: '{{ url('/colors') }}',
                @endif
                 data: data,
                 success: function(response) {
                    toastr.success('Sucesso!','Linha atualizada com sucesso');
                    $('#code-input').removeClass('has-error');
                    $('#description-input').removeClass('has-error');
                    $('#color-input').removeClass('has-error');
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
                        if(key == 'color'){
                            toastr.error('Erro!', value);
                            $('#color-input').addClass('has-error');
                        }
                        
                    });
                }
            });
             return false;
        });            
    </script>
@stop