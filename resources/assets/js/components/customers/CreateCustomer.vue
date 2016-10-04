<template>

    <div class="content">
        <div class="portlet light">

            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>Crear Cliente
                </div>
            </div>
            <div class="portlet-body form">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <small>Codigo</small>
                        <div class="form-group form-line-input" id="code">
                            <input id="code-input" class="form-control input-sm" type="text" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Cuit</small>
                        <div class="form-group form-line-input" id="cuit">
                            <input id="cuit-input" class="form-control input-sm" type="text" />
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">

                    <div class="col-md-4">
                        <small>Logo</small>
                        <div id="photo-input" class="form-group">
                            <div class="">
                                <img id="photo-image"  v-bind:src="customer.logo" class="figure-img img-fluid img-rounded product-photo" alt="sem imagem do produto.">
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="photo" class="dropzone">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Nombre</small>
                        <div class="form-group form-line-input" id="name">
                            <input id="name-input" class="form-control input-sm" type="text" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Región</small>
                        <div class="form-group form-line-input" id="region_id">
                            <v-select v-bind:options.sync="regions_select"
                                      :value.sync="customer.region_id"
                                      placeholder="Elije la región"
                                      class="form-control" id="region-input"
                                      name="region[]" search justified required close-on-select>

                            </v-select>

                        </div>
                    </div>

                    <div class="col-md-8">
                        <small>Address</small>
                        <div class="form-group form-line-input" id="address">
                            <input id="address-input" class="form-control input-sm" type="text" />
                        </div>

                    </div>



                </div>
                <hr>
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


            </div>
        </div>
    </div>
</template>
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
<script>
    import VueStrap from 'vue-strap'
    import Dropzone from 'dropzone'

    export default{
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            datepicker: VueStrap.datepicker
        },
        data(){
            return{
                customer: {
                    logo: "/images/default-placeholder.jpg"
                },
                regions_select: []
            }
        },
        ready(){
            window._this = this;
            _this.configureDropbox();
            _this.getRegions();
        },
        methods:{

            getRegions: function(){
                this.$http.get('/api/regions/selectlist')
                    .then(response => {
                        _this.regions_select = response.json();
                    })
                    .catch(responseError => {
                        toastr.error('No se puede conectar al servidor');
                    });
            },
            configureDropbox: function(callback){
                Dropzone.autoDiscover = false;
                var dropzoneOptions = {
                    maxFiles: 1,
                    maxFileSize: 8,
                    paramName: 'photo',
                    acceptedFiles: '.jpeg, .jpg, .png',
                    autoProcessQueue: false,
                    dictDefaultMessage: 'Elije el archivo',
                    url: "/customers/photo",
                    headers: {
                        'X-CSRF-TOKEN': Laravel.csrfToken
                    },

                    success: function(file, response){
                        Vue.set(callback, 'photo', response);
                        this.removeAllFiles(true);
                    },

                    init: function() {
                        this.on("maxfilesexceeded", function(file){
                            toastr.warning('Número de arquivos excedido!', 'Você só pode inserir um arquivo');
                        });
                        this.on("error", function(file, errorMessage){
                            toastr.error('Erro!', "Confira se o arquivo possui as características necessárias!");
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
            submitData: function(){
                //
            }
        }
    }
</script>
