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
    .product-photo {
        width:200px;
    }
</style>

<template>  
    <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">    
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <span class="caption-subject font-blue bold uppercase"> <i class="fa fa-user"></i> 
                            Tienda</span>
                        </div>
                    </div>
                    
                    <div class="portlet-body">
                        <form class="form-horizontal">    
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Nome</label>
                                <div class="col-md-7" id="name">                
                                    <input type="text" 
                                    name="name"
                                    class="form-control" 
                                    placeholder="Nombre"
                                    v-model="shop.name"
                                    >
                                </div>
                            </div>
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Descricion</label>
                                <div class="col-md-7" id="description">                
                                    <input type="text" 
                                    name="description"
                                    class="form-control" 
                                    placeholder="Descricion"
                                    v-model="shop.description"
                                    >
                                </div>
                            </div> 
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Endereço</label>
                                <div class="col-md-7" id="address">                
                                    <input type="text" 
                                    name="address"
                                    class="form-control" 
                                    placeholder="Endereço"
                                    v-model="shop.address"
                                    >
                                </div>
                            </div> 
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Endereço</label>
                                <div id="photo-input" class="form-group">
                                    <div class="">
                                        <img id="photo-image"  v-bind:src="shops.logo" class="figure-img img-fluid img-rounded product-photo" alt="sem imagem do produto.">
                                    </div>
                                    <div class="form-group">
                                        <div id="photo" class="dropzone"></div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <hr>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="button" class="btn btn-primary pull-right" @click="submitData()">
                                        <i class="fa fa-btn fa-user"></i>
                                        Crear
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import VueStrap from 'vue-strap'
import toastr from 'toastr'

export default{
    components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
    },
    data(){
        return{
            shop: {
                id:'',
                name: '',
                description: '',
                logo: '',
                address: '',
                geo:'',
                customer_id: ''
            },
        }
    },
    ready(){
        toastr.options.closeButton = true;
        this.configureDropbox(this.shop);
    },
    methods:{
        submitData: function(){ 
            if(this.shop.id)
                this.insertShop();
            else
                this.updateShop();
        },//end submit data
        insertShop:function(){
            this.$http.post('/shops', this.shop)
            .then(function (response) {
                toastr.success('Sucesso!', 'Tienda criada con sucesso.');
            }).catch(function (response) {
                $.each(response.data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#'+key).addClass('has-error');
                });
            });
        },
        updateShop: function(){
            this.$http.put('/shops', this.shop)
            .then(function (response) {
                toastr.success('Sucesso!', 'Tienda actualizada con sucesso.');
            }).catch(function (response) {
                $.each(response.data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#'+key).addClass('has-error');
                });
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
                dictDefaultMessage: 'Elija el arquivo',
                url: "/shops/photo",
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
    }, //end methods
    filters: {

    }
}
</script>