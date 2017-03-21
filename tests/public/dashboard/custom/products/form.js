

//ProductDropzone - Begin
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
            Vue.set(data.product, 'photo', response);
            console.log(data);
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
//ProductDropzone - End




var vm = new Vue({
    el: '#app',
    data () { return data },
    components: {
        vSelect: VueStrap.select,
        vOption: VueStrap.option,
        datepicker: VueStrap.datepicker,
    },
    ready: function(){
            //initializes algolia
            this.client = algoliasearch('Y9WBZIWMX0', '463bcdaf034272d4a26167c5f82ba45e');

            //Lines Typeahead
            this.linesIndex = this.client.initIndex('lines');
            $('#line-input .typeahead')
            .typeahead({hint: false},{
                source: this.linesIndex.ttAdapter({
                    filters: 'brand_id='+data.product.brand_id
                }),
                displayKey: 'description',
                templates:{
                    suggestion: function(hit){
                        return '<div><strong>' + hit._highlightResult.description.value + '</strong> <small>'
                        + hit.code + '</small></div>';
                    }
                }
            })
            .on('typeahead:select',function(e, suggestion){
                this.linesQuery = suggestion.description;
                data.product.line_id = suggestion.id;
                data.product.line_code = suggestion.code;

            }).bind(this);

            //References Typeahead
            this.referencesIndex = this.client.initIndex('references');
            $('#reference-input .typeahead')
            .typeahead({hint: false},{
                source: this.referencesIndex.ttAdapter({
                    filters: 'brand_id='+data.product.brand_id
                }),
                displayKey: 'description',
                templates:{
                    suggestion: function(hit){
                        return '<div><strong>' + hit._highlightResult.description.value + '</strong> <small>'
                        + hit.code + '</small></div>';
                    }
                }
            })
            .on('typeahead:select',function(e, suggestion){
                this.referencesQuery = suggestion.description;
                data.product.reference_id = suggestion.id;
                data.product.reference_code = suggestion.code;
            }).bind(this);

            //Materials Typeahead
            this.materialsIndex = this.client.initIndex('materials');
            $('#material-input .typeahead')
            .typeahead({hint: false},{
                source: this.materialsIndex.ttAdapter({
                    filters: 'brand_id='+data.product.brand_id
                }),
                displayKey: 'description',
                templates:{
                    suggestion: function(hit){
                        return '<div><strong>' + hit._highlightResult.description.value + '</strong> <small>'
                        + hit.code + '</small></div>';
                    }
                }
            })
            .on('typeahead:select',function(e, suggestion){
                this.materialsQuery = suggestion.description;
                data.product.material_id = suggestion.id;
                data.product.material_code = suggestion.code;
            }).bind(this);


            //References Typeahead
            this.colorsIndex = this.client.initIndex('colors');
            $('#color-input .typeahead')
            .typeahead({hint: false},{
                source: this.colorsIndex.ttAdapter({
                    filters: 'brand_id='+data.product.brand_id
                }),
                displayKey: 'description',
                templates:{
                    suggestion: function(hit){
                        return '<div><div style="display:inline-block;height:20px; width:20px; margin:5px; background-color:'+hit.color+';"></div><strong>'+hit.code+'</strong> – '+hit.description+'</div>';
                    }
                }
            })
            .on('typeahead:select',function(e, suggestion){
                this.colorsQuery = suggestion.description;
                data.product.color_id = suggestion.id;
                data.product.color_code = suggestion.code;
            }).bind(this);



            Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

            //ProductDropzone
            ProductDropzone();


        //$('#grids-input').select2({data: data.product.grids});
    },
    methods: {
        searchLines: function(){
            this.linesIndex.search(this.linesQuery,{
                filters: 'brand_id='+data.product.brand_id
            }, function(error, results){
                this.lines = results.hits;
            }.bind(this));
        },
        searchReferences: function(){

            this.referencesIndex.search(this.referencesQuery,{
                filters: 'brand_id='+data.product.brand_id
            }, function(error, results){
                this.references = results.hits;
            }.bind(this));
        },
        searchMaterials: function(){

            this.materialsIndex.search(this.materialsQuery, {
                filters: 'brand_id='+data.product.brand_id
            },function(error, results){
                this.materials = results.hits;
            }.bind(this));
        },
        searchColors: function(){

            this.colorsIndex.search(this.colorsQuery, {
                filters: 'brand_id='+data.product.brand_id
            },function(error, results){
                this.colors = results.hits;
            }.bind(this));
        },

        submitData: function(){

            data.product.code = data.product.line_code.toString() + data.product.reference_code.toString() + data.product.material_code.toString() + data.product.color_code.toString();
            data.product.code = parseInt(data.product.code);
            this.$http.post(data.actionUrl, data.product).then((response) => {


                toastr.success('Sucesso!','Produto atualizado com sucesso');
                $('#code-input').removeClass('has-error');
                $('#line-input').removeClass('has-error');
                $('#reference-input').removeClass('has-error');
                $('#material-input').removeClass('has-error');
                $('#color-input').removeClass('has-error');
                $('#price-input').removeClass('has-error');
                $('#cost-input').removeClass('has-error');
                $('#grids-input').removeClass('has-error');
                $('#tags-input').removeClass('has-error');


                // get status
                response.status;

                // get status text
                response.statusText;

                // get all headers
                response.headers;

                // get 'Expires' header
                response.headers['Expires'];

                // set data on vm
                console.log(response.body);
               // this.$set('someData', response.json())

            }, (response) =>
            {

                var errors = response.json();

                $.each(errors, function (key, value) {

                    if(key === "line_id"){
                        key = "line";
                    }
                    if(key === "reference_id"){
                        key = "reference";
                    }
                    if(key === "material_id"){
                        key = "material";
                    }
                    if(key === "color_id"){
                        key = "color";
                    }

                    var input = '#' + key + '-input';
                    $(input).addClass('has-error');
                    toastr.error('Atenção!', value);

                });
            });


        }

    },
    filters: {
        currencyDisplay: {
            // model -> view
            // formats the value when updating the input element.
            read: function (val) {
                return '$' + parseFloat(val).toFixed(2);
            },
            // view -> model
            // formats the value when writing to the data.
            write: function (val, oldVal) {

                var number = + val.replace(/[^\d.]/g, '');
                return isNaN(number) ? 0 : parseFloat(number).toFixed(2);
            }
        }
    }

});
