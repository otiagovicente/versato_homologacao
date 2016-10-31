<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div id="cover">
                        <figure class="brand-cover" >
                            <img  v-bind:src="brand.image" alt="brand.name">

                        </figure>
                        <div id="cover-dropzone" class="dropzone-previews clickable block cover-button-div" >
                            <button class="cover-button btn grey"><i class="icon-camera"></i></button>
                            <div class="dz-message" data-dz-message></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="col-md-4">

                        <small>Logo</small>
                        <div id="brand-logo" class="form-group">
                            <div class="">
                                <img class="brand-logo" v-bind:src="brand.logo" />
                            </div>
                            <div id="logo-dropzone" class="dropzone-previews clickable block logo-button-div">
                                <button class="logo-button btn grey"><i class="icon-camera"></i></button>
                                <div class="dz-message" data-dz-message></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <br>
                        <div class="form-group" id="name">
                            <input type="text" class="form-control input-lg" placeholder="Nombre" v-model="brand.name">
                        </div>

                        <div class="form-group" id="description">
                            <textarea class="form-control" placeholder="Descripción" rows="3" v-model="brand.description"></textarea>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <button class="btn blue pull-right" v-on:click="submitData()">Guardar</button>
                    <button class="btn grey pull-right" style="margin-right:10px;">Cancelar</button>
                </div>
            </div>

        </div>
    </div>
</template>
<style>

    .brand-cover{
        margin-bottom: 40px;
    }
    .brand-cover img{
        width: 100%;
        max-height: 200px;
    }
    .brand-cover-uploader{

    }
    .brand-logo{
        width: 200px;
    }

    .cancel-button{
        margin-right: 10px;
    }

    .cover-button-div{
        position: absolute;
        right: 27px;
        top: 10px;
    }
    .logo-button-div{
        position: absolute;
        left: 27px;
        top: 30px;
    }

    .clickable {
        cursor: pointer;
    }
    .block{
        display: inline-block;
    }

    .logo-dropzone {
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


</style>
<script type="text/babel">

    import Dropzone from 'dropzone'

    export default{
        data(){
            return{
                brand: {
                    id: '',
                    name: '',
                    description: '',
                    logo: '/images/default-placeholder.jpg',
                    image: '/images/horizontal-placeholder.png',
                }
            }
        },
        props: ['pbrandid'],
        ready(){
            window._CreateBrand = this;
            if (_CreateBrand.pbrandid){
                _CreateBrand.loadBrand();
            }
            _CreateBrand.configureCoverDropzone();
            _CreateBrand.configureLogoDropzone();
        },
        methods: {

            /*
             * Funções de envio
             */
            submitData: function () {
                if (!_CreateBrand.brand.id) {
                    _CreateBrand.store();
                }
                else {
                    _CreateBrand.update();
                }
            },
            store: function (){
                this.$http.post('/brands', _CreateBrand.brand)
                          .then(response => {
                              _CreateBrand.brand = response.json();
                              toastr.success('Marca creada con exito!');
                          })
                          .catch(response => {
                              $.each(response.data, function (key, value) {
                                  toastr.warning('Atención', value);
                                  $('#' + key).addClass('has-error');
                              });
                          });
            },
            update: function (){
                this.$http.patch('/brands/'+_CreateBrand.brand.id, _CreateBrand.brand)
                          .then(response => {
                              toastr.success('Marca guardada con exito!');
                          })
                          .catch(response => {
                              $.each(response.data, function (key, value) {
                                  toastr.warning('Atención', value);
                                  $('#' + key).addClass('has-error');
                              });
                          });
            },

            /*
             *  Funções de carregamento
             */
            loadBrand: function () {
                this.$http.get('/api/brands/'+_CreateBrand.pbrandid)
                        .then( response => {
                            _CreateBrand.brand = response.json();
                        }).catch( response => {
                    toastr.error('No puede cargar la marca');
                });
            },

            /*
             * Configuração dos Dropzones
             */

            configureLogoDropzone: function(callback){
                Dropzone.autoDiscover = false;
                var logoDropzoneOptions = {
                    maxFiles: 1,
                    maxFileSize: 8,
                    paramName: 'logo',
                    clickable: ['.logo-button'],
                    acceptedFiles: '.jpeg, .jpg, .png',
                    autoProcessQueue: false,
                    dictDefaultMessage: 'Eligir el logo',
                    url: "/brands/logo",
                    headers: {
                        'X-CSRF-TOKEN': Laravel.csrfToken
                    },

                    success: function(file, response){
                        _CreateBrand.brand.logo = response;
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
                var logoDropzone = new Dropzone("div#logo-dropzone", logoDropzoneOptions);

                logoDropzone.accept = function(file, done) {

                    bootbox.confirm("Seguro que quieres hacer el upload del logo?", function(result) {
                        if(result){
                            done();
                            logoDropzone.processQueue();
                        }else{
                            logoDropzone.removeAllFiles(true);
                            done(result);
                        }
                    });
                };



            },
            configureCoverDropzone: function(callback){

                Dropzone.autoDiscover = false;

                var coverDropzoneOptions = {
                    maxFiles: 1,
                    maxFileSize: 8,
                    paramName: 'photo',
                    clickable: ['.cover-button'],
                    acceptedFiles: '.jpeg, .jpg, .png',
                    autoProcessQueue: true,
                    dictDefaultMessage: 'Eligir la imagen de pantalla',
                    url: "/brands/photo",
                    headers: {
                        'X-CSRF-TOKEN': Laravel.csrfToken
                    },

                    success: function(file, response){
                        _CreateBrand.brand.image = response;
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
                var coverDropzone = new Dropzone("div#cover-dropzone", coverDropzoneOptions);

            },


        }
    }
</script>
