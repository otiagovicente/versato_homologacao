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
    <!-- BEGIN PROFILE CONTENT -->
    <div class="profile-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">Tienda</span>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1_1" data-toggle="tab">Informaciones</a>
                            </li>
                            <li>
                                <a href="#tab_1_2" data-toggle="tab">Añadir el logotipo</a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <!-- PERSONAL INFO TAB -->
                            <div class="tab-pane active" id="tab_1_1">
                                <form role="form" action="#">
                                    
                                    <div class="form-group" id="name-input" >
                                        <label  class="control-label">Nombre</label>
                                        <input type="text" placeholder="la tienda" class="form-control" v-model="shop.name" /> </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label"  id="about-input" >Description</label>
                                        <textarea class="form-control" rows="3" placeholder="Una breve descripcion de la tienda" v-model="shop.description"></textarea>
                                    </div>

                                    <div class="form-group" id="address-input" >
                                        <label class="control-label">Endereço</label>
                                        <input  type="text" placeholder="avenida aa" v-model="shop.address" class="form-control" /> </div>
                                    
                                    <hr>
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="col-md-3 pull-right">
                                                <div v-show="canedit" class="form-group">
                                                    <a href="/shops/"><button type="button" class="btn grey btn-block" id="cancel-btn">Cancel</button></a>
                                                </div>
                                                <div v-show="!canedit" class="form-group">
                                                    <a href="/shops/"><button type="button" class="btn grey btn-block" id="cancel-btn">Voltar</button></a>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pull-right">
                                                <div class="form-group">
                                                    <button v-show="canedit" type="button" @click="submitData" class="btn blue btn-block" id="send-btn">
                                                        Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- END PERSONAL INFO TAB -->
                            
                            <div class="tab-pane" id="tab_1_2">
                                <p> Cambia el logo! ;) </p>
                                <form id="image-form" action="#" role="form">
                                    <div class="form-group">
                                        <div class="thumbnail" style="width: 100%;">
                                            <img :src="shop.logo" alt="" style="width:auto;"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="photo" class="dropzone" style="min-height:150px; border: 2px dashed #eaeaea; background: white; padding: 20px 20px; text-align:center;"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueStrap from 'vue-strap'
import toastr from 'toastr'
import Dropzone from 'dropzone'

export default{
    
    components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
    },
    
    props:['pshop','isedit'],
    
    data(){
        return{
            canedit:true,
            shop: {
                id:'',
                name: '',
                description: '',
                logo: '',
                address: '',
                geo:'',
                customer_id: 1,
            },
        }
    },
    
    ready(){
        toastr.options.closeButton = true;
        this.configureDropbox(this.shop);
        this.canedit = this.isedit;
        if(this.pshop) this.loadShop();
    },

    methods:{
        submitData: function(){ 
            if(!this.shop.id)
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
            this.$http.put('/shops/'+this.shop.id, this.shop)
            .then(function (response) {
                toastr.success('Sucesso!', 'Tienda actualizada con sucesso.');
            }).catch(function (response) {
                $.each(response.data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#'+key).addClass('has-error');
                });
            });
        },
        
        loadShop:function(){
            this.shop.id = this.pshop.id;
            this.shop.name = this.pshop.name;
            this.shop.description = this.pshop.description;
            this.shop.logo = this.pshop.logo;
            this.shop.address = this.pshop.address;
            this.shop.geo = this.pshop.geo;
            this.shop.customer_id = this.pshop.customer_id;
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
                    Vue.set(callback, 'logo', response);
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

                bootbox.confirm("Seguro que quieres hacer el upload de una imágene de la tienda?", function(result) {
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