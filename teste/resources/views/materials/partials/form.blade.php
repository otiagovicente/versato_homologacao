<div class="portlet light">

    <div class="portlet-title">
        <div class="caption font-blue">
        	@if($action=='edit')
            <i class="fa fa-pencil font-blue"></i>Editar Material 
            @elseif($action=='create')
            <i class="fa fa-plus font-blue"></i>Criar Material
            @endif
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form id="form-material" class="form-horizontal">

	    	{{ csrf_field() }}
	    	@if($action==='edit')
	        {{ method_field('PATCH') }}
	        @endif

            <div class="form-body">
                <div class="row">
                    <div class="col-md-7">
                        <div id="code-input" class="form-group">
                            <label class="col-md-3 control-label">Código</label>
                            <div class="col-md-7">
                              
                                <input type="text" name="code" class="form-control " placeholder="Código do Material" @if($action==='edit') value="{{ $material->code }}" readonly="readonly" @endif>
                              
                            </div>
                        </div>
        				
        				<div id="description-input" class="form-group">
                            <label class="col-md-3 control-label">Material</label>
                            <div class="col-md-7">
                              
                              	<input type="text" name="description" class="form-control" placeholder="Nome do Material"@if($action==='edit') value="{{ $material->description }}" @endif >

                            </div>
                        </div>	
                    </div>
                    <div class="col-md-5">
                        <div id="sample-input" class="form-group">
                            <label class="col-md-2 control-label">Amostra</label>
                            <div class="col-md-6">
                                
                                  <img id="sample-image" @if($action ==='edit') src="{{ $material->sample }}" @else src="/images/default-placeholder.jpg" @endif  class="figure-img img-fluid img-rounded" alt="sem imagem de amostra." style="width:200px; margin:10px;">
                                  <input id="sample-path" type="hidden" name="sample" @if($action ==='edit') value="{{ $material->sample }}" @else value="" @endif>
                                  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Upload</label>
                            <div id="sample" class="col-md-6 dropzone" style="margin:25px;">
                                
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="pull-right col-md-3">

                        <a href="{{ url('materials/') }}">
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


@section('metatags')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('styles')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="/dashboard/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
@stop

@section('scripts')

    <script src="/dashboard/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script> 

    <script src="/dashboard/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
	<!-- DATA CASTING & FORM SEND-->

    <script>

        $('#send-btn').on('click', function(event) {
             
            var data = $('#form-material').serialize();
            
            $.ajax({

            	@if($action==='edit')
                type: "PATCH",
                url: '{{ url('/materials/'.$material->id) }}',
                @elseif($action==='create')
                type: "POST",
                url: '{{ url('/materials') }}',
                @endif

                 data: data,
                 success: function(response) {
                    toastr.success('Sucesso!','Material atualizado com sucesso');
                    $('#code-input').removeClass('has-error');
                    $('#description-input').removeClass('has-error');
                    $('#sample-input').removeClass('has-error');
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
                        if(key == 'sample'){
                            toastr.error('Erro!', value);
                            $('#sample-input').addClass('has-error');
                        }
                        
                    });
                }
            });
             return false;
             

        });            

        Dropzone.autoDiscover = false;

        var dropzoneOptions = {
            autoDiscover: false,
            maxFiles: 1,
            maxFileSize: 2,
            paramName: 'photo',
            acceptedFiles: '.jpeg, .jpg, .png',
            autoProcessQueue: false,
            dictDefaultMessage: 'Solte o arquivo aqui',
            url: "/materials/photo",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(file, response){
                $('img#sample-image').attr("src", response);
                $('#sample-path').attr("value", response);
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

        var sampleDropzone = new Dropzone("div#sample", dropzoneOptions);

       sampleDropzone.accept = function(file, done) {
                @if($action==='edit')
                bootbox.confirm("Tem certeza que quer atualizar a amostra?", function(result) {
                @else
                bootbox.confirm("Tem certeza que quer fazer o upload da amostra?", function(result) {
                @endif
                    
                    if(result){
                        done();
                        sampleDropzone.processQueue();
                    }else{
                        sampleDropzone.removeAllFiles(true);
                        done(result);
                    }

                }); 

          };




    </script>
@stop