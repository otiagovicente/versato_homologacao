<style>
    .dropzone {
        min-height: 150px;
        border: 2px dashed #eaeaea;
        background: white;
        padding: 20px 20px;
        width: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: "Open Sans",sans-serif;
        font-weight: 300;
        font-size: 18px;
    }
    .datepicker-input {
        width: 100%;
    }
    .product-photo {
        width:200px;
    }

    .algolia-autocomplete {
        width: 100%;
    }
    .algolia-autocomplete .aa-input, .algolia-autocomplete .aa-hint {
        width: 100%;
        min-height: 30px;
        text-indent: 10px;
    }
    .algolia-autocomplete .aa-hint {
        color: #999;
    }
    .algolia-autocomplete .aa-dropdown-menu {
        width: 100%;
        background-color: #fff;
        border: 1px solid #999;
        border-top: none;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion {
        cursor: pointer;
        padding: 5px 4px;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion.aa-cursor {
        background: #f8f8f8;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion em {
        font-weight: bold;
        font-style: normal;
    }
    .algolia-autocomplete .category {
        text-align: left;
        background: #efefef;
        padding: 10px 5px;
        font-weight: bold;
    }

</style>
<template>
    <div class="content">
        <div class="portlet light">

            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>Crear Produto
                </div>
            </div>
            <div class="portlet-body form">
                <form id="form-product">

                    <div class="row">
                        <div class="col-md-4">
                            <h3>Códigos:</h3>

                        </div>
                        <div class="col-md-4">
                            <small>Código</small>
                            <div class="form-group form-line-input" id="code">
                                <input id="code-input" class="form-control input-sm" type="text" v-model="product.code" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small>Código Beira Rio</small>
                            <div class="form-group form-line-input" id="code_beirario">
                                <input id="code_beirario-input" class="form-control input-sm" type="text" v-model="product.code_beirario"/>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4">
                            <small>Foto</small>
                            <div id="photo-input" class="form-group">
                                <div class="">
                                    <img id="photo-image"  v-bind:src="product.photo" class="figure-img img-fluid img-rounded product-photo" alt="sem imagem do produto.">
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="photo" class="dropzone">
                                </div>
                            </div>
                        </div>



                        <div class="col-md-4">

                            <small>Línea</small>
                            <div class="form-group form-line-input" id="line_id">
                                <input id="line-input" class="form-control input-sm" type="text" />
                            </div>


                            <small>Material</small>
                            <div class="form-group form-line-input" id="material_id">
                                <input id="material-input"class="form-control input-sm" type="text"/>
                            </div>

                            <small>Color</small>
                            <div class="form-group form-line-input" id="color_id">
                                <input id="color-input"class="form-control input-sm" type="text"/>
                            </div>

                            <small>Lanzamiento</small>
                            <div class="form-group form-line-input" id="launch">
                                <datepicker :value.sync="product.launchdisplay" format="dd/MM/yyyy" width="100%">
                                </datepicker>
                            </div>
                            <small>Publicado?</small>
                            <div class="form-group form-line-input" id="published">
                                <input type="checkbox" name="published" v-model="product.published">
                            </div>

                        </div>



                        <div class="col-md-4">

                            <div class="form-group form-line-input" id="cost">
                                <small>Costo</small>
                                <input name="cost"
                                       type="text"
                                       v-model="product.cost | currencyDisplay"
                                       class="form-control input-sm"
                                       id="cost-input">

                            </div>
                            <div class="form-group form-line-input" id="price">
                                <small>Precio</small>
                                <input name="price"
                                       type="text"
                                       v-model="product.price | currencyDisplay"
                                       class="form-control input-sm"
                                       id="price-input">
                            </div>

                            <div class="form-group form-line-input" id="grids">
                                <small>Tareas</small>
                                <v-select v-bind:options.sync="grids_select" :value.sync="product.grids"  placeholder="Elije las tareas" multiple class="form-control" id="grids-input" name="grids[]" search justified required close-on-select></v-select>


                            </div>

                            <div class="form-group form-line-input" id="tags">
                                <small>Tags</small>
                                <v-select v-bind:options.sync="tags_select" :value.sync="product.tags"  placeholder="Elije las tags" multiple class="form-control" id="tags-input" name="tags[]" search justified required close-on-select></v-select>

                            </div>

                        </div>


                    </div>
                    <hr/>

                    <div class="row">
                        <div class="container-fluid">
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <button type="button" @click="submitData()" class="btn blue btn-block" id="send-btn">Salvar</button>
                                </div>
                            </div>
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <a href="/products/"><button type="button" class="btn grey btn-block" id="cancel-btn">Cancel</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




</template>

<script type="text/babel">

    import VueStrap from 'vue-strap'
    import algoliasearch from 'algoliasearch'
    import Dropzone from 'dropzone'
    import toastr from 'toastr'
    import bootbox from 'bootbox'

    export default{
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            datepicker: VueStrap.datepicker
        },
        data(){
            return{
                product: {
                    code: '',
                    code_beirario: '',
                    line_id: null,
                    line_code: '',
                    material_id: null,
                    material_code: '',
                    color_id: null,
                    color_code: '',
                    cost: 0.00,
                    price: 0.00,
                    grids: [],
                    photo: '/images/default-placeholder.jpg',
                    brand_id: Versato.brand_id,
                    launchdisplay: '',
                    launch: '',
                    published: false
                },

                client: '',
                linesIndex: '',
                materialsIndex: '',
                colorsIndex: '',
                tags_select: new Array(),
                grids_select: new Array()




            }
        },
        props:['pproductid'],
        ready(){
            window._CreateProducts = this;
            _CreateProducts.product.brand_id = Versato.brand_id;
            _CreateProducts.product.launchdisplay = moment().format('DD/MM/YYYY');
            _CreateProducts.getGrids();
            _CreateProducts.getTags();
            _CreateProducts.configureDropzone(_CreateProducts.product);
            _CreateProducts.configureAlgolia();
            _CreateProducts.configureAutocomplete();

            if(_CreateProducts.pproductid){
                _CreateProducts.getProduct();
            }


        },
        methods:{

            /*
             * Funções de envio
             */

            submit: function () {


                if (!_CreateProducts.product.id) {
                    _CreateProducts.store();
                } else {
                    _CreateProducts.update();
                }

            },

            store: function(){

                if(!_CreateProducts.validateInputs()){
                    return false;
                }

                this.$http.post('/products', _CreateProducts.product)
                        .then(function (response) {
                            console.log(response);
                            toastr.success('Producto guardado');
                        }).catch(function (response) {
                    $.each(response.data, function (key, value) {
                        toastr.error(value);
                        $('#'+key).addClass('has-error');
                    });
                });
                console.log('submitData');
            },

            update: function(){

                if(!_CreateProducts.validateInputs()){
                    return false;
                }

                this.$http.patch('/products/'+_CreateProducts.productid, _CreateProducts.product)
                        .then(function (response) {
                            console.log(response);
                            toastr.success('Producto guardado');
                        }).catch(function (response) {
                    $.each(response.data, function (key, value) {
                        toastr.error(value);
                        $('#'+key).addClass('has-error');
                    });
                });
                console.log('submitData');
            },


            /*
             * Função de carregamentos
             */

            getGrids: function(){
                this.$http.get('/api/grids/selectlist/'+Versato.brand_id)
                        .then(response => {
                            _CreateProducts.grids_select = response.json();
                        });
            },
            getTags: function(){
                this.$http.get('/api/tags/selectlist/'+Versato.brand_id)
                        .then(response => {
                            _CreateProducts.tags_select = response.json();
                        });
            },
            getProduct: function(){
                this.$http.get('/api/products/'+_CreateProducts.pproductid)
                        .then(response => {
                            var product = response.json();
                            product.launch = moment(product.launch, "YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY');
                            product.launchdisplay = product.launch;
                            product.grids = product.grids_list;
                            product.tags = product.tags_list;

                            $('#line-input').val(product.line.description);
                            $('#material-input').val(product.material.description);
                            $('#color-input').val(product.color.description);

                            _CreateProducts.product = product;
                        });
            },

            /*
             * Configura DropZone
             */
            configureDropzone: function(callback){
                Dropzone.autoDiscover = false;
                var dropzoneOptions = {
                    maxFiles: 1,
                    maxFileSize: 8,
                    paramName: 'photo',
                    acceptedFiles: '.jpeg, .jpg, .png',
                    autoProcessQueue: false,
                    dictDefaultMessage: 'Elige el archivo',
                    url: "/products/photo",
                    headers: {
                        'X-CSRF-TOKEN': Laravel.csrfToken
                    },

                    success: function(file, response){
                        Vue.set(callback, 'photo', response);
                        this.removeAllFiles(true);
                    },

                    init: function() {
                        this.on("maxfilesexceeded", function(file){
                            toastr.warning('Numero de archivos excedido!', 'Solo puede poner un archivo');
                        });
                        this.on("error", function(file, errorMessage){
                            toastr.error('Erro!', "La foto no tiene las caracteristicas que se necesita!");
                            this.removeAllFiles(true);
                        });
                    }

                };
                var photoDropzone = new Dropzone("div#photo", dropzoneOptions);

                photoDropzone.accept = function(file, done) {

                    bootbox.confirm("Seguro que quieres hacer el upload de una imágene del producto?", function(result) {
                        if(result){
                            done();
                            photoDropzone.processQueue();
                        }else{
                            photoDropzone.removeAllFiles(true);
                            done(result);
                        }
                    });
                };



            },
            /*
             *  Confitura Algolia
             */
            configureAlgolia: function(){
                //initializes algolia
                _CreateProducts.client = window.algoliasearch(Scout.app_id, Scout.search_key);
                _CreateProducts.linesIndex = _CreateProducts.client.initIndex(Scout.prefix+'lines');
                _CreateProducts.materialsIndex = _CreateProducts.client.initIndex(Scout.prefix+'materials');
                _CreateProducts.colorsIndex = _CreateProducts.client.initIndex(Scout.prefix+'colors');
            },

            /*
             * Configura o Autocomplete
             */
            configureAutocomplete: function(){

                autocomplete('#line-input', { hint: false }, [
                    {
                        source: autocomplete.sources.hits(_CreateProducts.linesIndex, {
                            hitsPerPage: 5,
                            filters: 'brand_id='+Versato.brand_id
                        }),
                        displayKey: 'description',
                        templates: {
                            suggestion: function(suggestion) {
                                return '<div><strong>' + suggestion._highlightResult.description.value + '</strong> <small>'
                                        + suggestion.code + '</small></div>';
                            }
                        }
                    }
                ]).on('autocomplete:selected', function(event, suggestion, dataset) {
                    _CreateProducts.product.line_id = suggestion.id;
                    _CreateProducts.product.line_code = suggestion.code;
                    $('#line_id').removeClass('has-error');
                });



                autocomplete('#material-input', { hint: false }, [
                    {
                        source: autocomplete.sources.hits(_CreateProducts.materialsIndex, {
                            hitsPerPage: 5,
                            filters: 'brand_id='+Versato.brand_id
                        }),
                        displayKey: 'description',
                        templates: {
                            suggestion: function(suggestion) {
                                return '<div><strong>' + suggestion._highlightResult.description.value + '</strong> <small>'
                                        + suggestion.code + '</small></div>';
                            }
                        }
                    }
                ]).on('autocomplete:selected', function(event, suggestion, dataset) {
                    _CreateProducts.product.material_id = suggestion.id;
                    _CreateProducts.product.material_code = suggestion.code;
                    $('#material_id').removeClass('has-error');
                });

                autocomplete('#color-input', { hint: false }, [
                    {
                        source: autocomplete.sources.hits(_CreateProducts.colorsIndex, {
                            hitsPerPage: 5,
                            filters: 'brand_id='+Versato.brand_id
                        }),
                        displayKey: 'description',
                        templates: {
                            suggestion: function(suggestion){
                                return '<div style="display: flex; align-items: center;"><div style="display:inline-block;height:20px; width:20px; margin:5px; background-color:'+suggestion.color+';"></div><strong>'+suggestion.code+'</strong> – '+suggestion.description+'</div>';
                            }
                        }
                    }
                ]).on('autocomplete:selected', function(event, suggestion, dataset) {
                    _CreateProducts.product.color_id = suggestion.id;
                    _CreateProducts.product.color_code = suggestion.code;
                    $('#color_id').removeClass('has-error');
                });

            },
            /*
             * Valida os inputs
             */
            validateInputs: function(){
                console.log('validating...');
                console.log('done.');
                _CreateProducts.product.launch = moment(_CreateProducts.product.launchdisplay, "DD/MM/YYYY").format("YYYY-MM-DD");

                var valid = true;
                if(_CreateProducts.product.code == ''){
                    $('#code').addClass('has-error');
                    toastr.error('Se necesita el codigo de producto');
                    valid = false;
                }

                if(_CreateProducts.product.code_beirario == ''){
                    $('#code_beirario').addClass('has-error');
                    toastr.error('Necesita el codigo del fabricante!');
                    valid = false;
                }

                if(_CreateProducts.product.line_id == null){
                    $('#line_id').addClass('has-error');
                    toastr.error('Necesita una Línea');
                    valid = false;
                }



                if(_CreateProducts.product.material_id == null){
                    $('#material_id').addClass('has-error');
                    toastr.error('Necesita eligir material');
                    valid = false;
                }
                if(_CreateProducts.product.color_id == null){
                    $('#color_id').addClass('has-error');
                    toastr.error('Necesita eligir una color');
                    valid = false;
                }

                if(_CreateProducts.product.price <= 0){
                    $('#price').addClass('has-error');
                    toastr.error('El precio necesita ser mas grande que zero');
                    valid = false;
                }

                if(_CreateProducts.product.cost <= 0){
                    $('#cost').addClass('has-error');
                    toastr.error('El costo necesita ser mas grande que zero');
                    valid = false;
                }

                if(_CreateProducts.product.cost >= _CreateProducts.product.price){
                    $('#price').addClass('has-error');
                    $('#cost').addClass('has-error');
                    toastr.error('El precio hay que ser mas grande que el costo');
                    valid = false;
                }


                if(valid == true) {
                    $('#price').removeClass('has-error');
                    $('#cost').removeClass('has-error');
                }
                return valid;
            },

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
        },
        watch: {
            'product.grids': function (val, oldVal) {
                if(val.length > 0){
                    $('#grids').removeClass('has-error');
                }
            }


        }
    }



</script>
