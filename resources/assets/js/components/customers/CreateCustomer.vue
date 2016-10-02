<template>
    <div>
        oi
    </div>
</template>
<style>
    body{
        background-color:#ff0000;
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
                msg:'hello vue'
            }
        },
        methods:{
            configureDropbox: function(callback){
                Dropzone.autoDiscover = false;
                var dropzoneOptions = {
                    maxFiles: 1,
                    maxFileSize: 8,
                    paramName: 'photo',
                    acceptedFiles: '.jpeg, .jpg, .png',
                    autoProcessQueue: false,
                    dictDefaultMessage: 'Elije el archivo',
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
        }
    }
</script>
