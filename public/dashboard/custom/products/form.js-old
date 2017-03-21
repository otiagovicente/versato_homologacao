  
	/*
	 *	DataSets para busca
	 */	  
	var ProductDatasets = function(){
		// CORES
		var colors = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('code'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			 // '/colors/all',
			remote: {
				url: '/colors/search#%QUERY',
			    wildcard: '%QUERY',
			    transport: function (opts, onSuccess, onError) {
			        var url = opts.url.split("#")[0];
			        var query = opts.url.split("#")[1];
			        $.ajax({
			            url: url,
			            data: "search=" + query,
			            type: "POST",
			            headers: {
					  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					 	}, 
			            success: onSuccess,
			            error: onError,
			        })
			    }
			}
		});

		// MATERIAIS
		var materials = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('code'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			 // '/colors/all',
			remote: {
				url: '/materials/search#%QUERY',
			    wildcard: '%QUERY',
			    transport: function (opts, onSuccess, onError) {
			        var url = opts.url.split("#")[0];
			        var query = opts.url.split("#")[1];
			        $.ajax({
			            url: url,
			            data: "search=" + query,
			            type: "POST",
			            headers: {
					  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					 	}, 
			            success: onSuccess,
			            error: onError,
			        })
			    }
			}
		});
		// REFERENCIAS
		var references = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('code'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			 // '/colors/all',
			remote: {
				url: '/references/search#%QUERY',
			    wildcard: '%QUERY',
			    transport: function (opts, onSuccess, onError) {
			        var url = opts.url.split("#")[0];
			        var query = opts.url.split("#")[1];
			        $.ajax({
			            url: url,
			            data: "search=" + query,
			            type: "POST",
			            headers: {
					  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					 	}, 
			            success: onSuccess,
			            error: onError,
			        })
			    }
			}
		});
		// LINHAS
		var lines = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('code'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			 // '/colors/all',
			remote: {
				url: '/lines/search#%QUERY',
			    wildcard: '%QUERY',
			    transport: function (opts, onSuccess, onError) {
			        var url = opts.url.split("#")[0];
			        var query = opts.url.split("#")[1];
			        $.ajax({
			            url: url,
			            data: "search=" + query,
			            type: "POST",
			            headers: {
					  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					 	}, 
			            success: onSuccess,
			            error: onError,
			        })
			    }
			}
		});


		/*
		 * Atribuição dos TypeAheads
		 */

		//Cor
		$('#color-input .typeahead').typeahead(null, {
			name: 'color_id',
			hint: true,
			display: 'code',
			source: colors.ttAdapter(),
			templates: {
				empty: [
				  '<div style="padding: 5px 10px; text-align: center;">',
				    'Não existem cores correspondentes',
				  '</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<div><div style="display:inline-block;height:20px; width:20px; margin:5px; background-color:{{ color }};"></div><strong>{{code}}</strong> – {{description}}</div>')
			}
		});

		$('#color-input .typeahead').bind('typeahead:select', function(ev, suggestion) {
			  $('#color-id').val(suggestion.id);
			  $("#color-code").html(suggestion.code);
		  //console.log('Selection: ' + suggestion.id);
		});

		//Material
		$('#material-input .typeahead').typeahead(null, {
			name: 'material_id',
			hint: true,
			display: 'code',
			source: materials.ttAdapter(),
			templates: {
				empty: [
				  '<div style="padding: 5px 10px; text-align: center;">',
				    'Não existem materiais correspondentes',
				  '</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<div><strong>{{code}}</strong> – {{description}}</div>')
			}
		});

		$('#material-input .typeahead').bind('typeahead:select', function(ev, suggestion) {
			  $('#material-id').val(suggestion.id);
			  $("#material-code").html(suggestion.code);
		  //console.log('Selection: ' + suggestion.id);
		});	
	       
		//Referência
		$('#reference-input .typeahead').typeahead(null, {
			name: 'reference_id',
			hint: true,
			display: 'code',
			source: references.ttAdapter(),
			templates: {
				empty: [
				  '<div style="padding: 5px 10px; text-align: center;">',
				    'Não existem referências correspondentes',
				  '</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<div><strong>{{code}}</strong> – {{description}}</div>')
			}
		});

		$('#reference-input .typeahead').bind('typeahead:select', function(ev, suggestion) {
			  $('#reference-id').val(suggestion.id);
			  $("#reference-code").html(suggestion.code);
		  //console.log('Selection: ' + suggestion.id);
		});	

		//Linhas
		$('#line-input .typeahead').typeahead(null, {
			name: 'line_id',
			hint: true,
			display: 'code',
			source: lines.ttAdapter(),
			templates: {
				empty: [
				  '<div style="padding: 5px 10px; text-align: center;">',
				    'Não existem linhas correspondentes',
				  '</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<div><strong>{{code}}</strong> – {{description}}</div>')
			}
		});

		$('#line-input .typeahead').bind('typeahead:select', function(ev, suggestion) {
			  $('#line-id').val(suggestion.id);
			  $("#line-code").html(suggestion.code);
		  //console.log('Selection: ' + suggestion.id);
		});	

	}

//DROPZONE
		var ProductDropzone = function(){
	        var dropzoneOptions = {
	            autoDiscover: false,
	            maxFiles: 1,
	            maxFileSize: 2,
	            paramName: 'photo',
	            acceptedFiles: '.jpeg, .jpg, .png',
	            autoProcessQueue: false,
	            dictDefaultMessage: 'Solte o arquivo aqui',
	            url: "/products/photo",
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },

	            success: function(file, response){
	                $('img#photo-image').attr("src", response);
	                $('#photo-path').attr("value", response);
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


	        var photoDropzone = new Dropzone("div#photo", dropzoneOptions);

	       	photoDropzone.accept = function(file, done) {

	                bootbox.confirm("Tem certeza que quer fazer o upload da imagem do produto?", function(result) {

	                    
	                    if(result){
	                        done();
	                        photoDropzone.processQueue();
	                    }else{
	                        photoDropzone.removeAllFiles(true);
	                        done(result);
	                    }

	                }); 

	          };
        }

        var ProductMasks = function(){
		        $("#cost-input").inputmask('$‚ 999.999,99', {
		            numericInput: true,
		            autoUnmask: true
		        }); //123456  =>  $‚¬ ___.__1.234,56
		        $("#price-input").inputmask('$‚ 999.999,99', {
		            numericInput: true,
		            autoUnmask: true
		        }); //123456  =>  $‚¬ ___.__1.234,56
        }


		var handleData = handleData || (function(){
			var action = "";
			var product_id;
			var type;
			var url;
		    return {
		    	init : function(order, id){
	    			action = order;
	    			if (action === 'edit'){
	    				product_id = id;
		                type = "PATCH";
		                url = '/products/'+product_id;
	    			}else{
		                type = "POST";
		                url = '/products';
		            }
		    	},
		        prepareSubmitButton : function() {
		        	console.log(action);
			        $('#send-btn').on('click', function(event) {
			            console.log('ação: '+action);
			            if(action === 'create'){
			            	console.log('cria maluco');
			            } else {
			            	console.log('edita maluco');
			            }
			            code = $('#line').val() + $('#reference').val() + $('#material').val() + $('#color').val();
			            $('#code').val(code);
			            var data = $('#form-product').serialize();
			            console.log(data);
			            $.ajax({
				             type: type,
				             url: url,
			                 data: data,			            
			                 headers: {
						  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						 	},
			                 success: function(response) {
			                    toastr.success('Sucesso!','Produto atualizado com sucesso');
			                    $('#code-input').removeClass('has-error');
			                    $('#description-input').removeClass('has-error');
			                    $('#sample-input').removeClass('has-error');
			                 },
			                 error: function(responseError) {

			                    var errors = JSON.parse(responseError.responseText);
			                    toastr.error('Erro!', 'Alguns dados não foram preenchidos corretamente');
			                    $.each(errors, function(key, value){

			                        if(key = 'code'){
			                            toastr.error('Erro!', value);
			                            $('#code-input').addClass('has-error');

			                        }
			                        if(key = 'description'){
			                            toastr.error('Erro!', value);
			                            $('#description-input').addClass('has-error');

			                        }
			                        if(key = 'sample'){
			                            toastr.error('Erro!', value);
			                            $('#sample-input').addClass('has-error');
			                        }
			                        
			                    });
			                }
			            });
			             return false;
			             

			        });         
		        },
		        helloWorld : function() {
		            alert(action);
		        }
		    };
		}());




        $(function() {
        	ProductDatasets();
        	ProductDropzone();
        	ProductMasks();
		    console.log( "ready!" );
		});

