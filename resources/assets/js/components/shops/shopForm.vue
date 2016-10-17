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
    .map {
        width: 100%;
        height: 200px;
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
                                        <label  class="control-label">Cliente</label>
                                        <v-select 
                                            v-bind:options.sync="customers_select" :value.sync="shop.customer_id"
                                            placeholder="Elije el cliente" class="form-control"
                                            id="customer-input" name="customer[]"
                                            search justified required close-on-select></v-select>
                                    </div>
                                    <div class="form-group" id="name-input" >
                                        <label  class="control-label">Nombre</label>
                                        <input type="text" placeholder="la tienda" class="form-control" v-model="shop.name" />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label"  id="about-input" >Description</label>
                                        <textarea class="form-control" rows="3" placeholder="Una breve descripcion de la tienda" v-model="shop.description"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <small>Ubicación de la tienda</small>
                                        <div class="input-group" id="address">

                                            <input id="address-input" class="form-control" type="text"
                                                v-model="shop.address"
                                                @keyup.enter="fetchAddress"
                                            />
                                            <span class="input-group-btn">
                                                <button class="btn blue" type="button" @click="fetchAddress">Go!</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <div class="map">
                                            <map style="width: 100%; height: 150px;"
                                                v-bind:center.sync="map.center"
                                                v-bind:zoom.sync="map.zoom"
                                            >
                                                <marker
                                                    v-for="m in map.markers"
                                                    :position.sync="m.position"
                                                    :clickable.sync="m.clickable"
                                                    :draggable.sync="m.draggable"
                                                    @g-click="center=m.position"
                                                >
                                                </marker>
                                            </map>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="col-md-3 pull-right">
                                                <div v-show="canedit" class="form-group">
                                                    <a href="/shops/"><button type="button" class="btn grey btn-block" id="cancel-btn">Cancel</button></a>
                                                </div>
                                                <div v-show="!canedit" class="form-group">
                                                    <a href="/shops/"><button type="button" class="btn grey btn-block" id="back-btn">Voltar</button></a>
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
import {Map, load, Marker, InfoWindow} from 'vue-google-maps'

export default{
    
    components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            Map,
            load,
            Marker,
            InfoWindow
    },
    
    props:['pshop','isedit','pcustomer_id'],
    
    data(){
        return{
            canedit:true,
            customers_select:[],
            shop: {
                id:'',
                name: '',
                description: '',
                logo: '',
                address: '',
                geo:'',
                customer_id: [],
            },
            map :{
                markers: [],
                center : {lat: -34.6248187, lng: -58.3761432},
                zoom: 12
            },
        }
    },
    
    ready(){
        load(Maps.maps_key, Maps.maps_version)
        window._shopForm = this;

        toastr.options.closeButton = true;

        _shopForm.configureDropbox(this.shop);
        _shopForm.configureMapsApi()

        _shopForm.canedit = _shopForm.isedit;
        if(_shopForm.pshop) _shopForm.loadShop();
        if(_shopForm.pcustomer_id) _shopForm.loadCustomer();
    },

    methods:{
        getCustomers: function(){
            this.$http.get('/api/customers/selectlist')
            .then(response => {
                this.customers_select = response.json();
            });
        },
        configureMapsApi: function(){
            //load(Maps.maps_key,Maps.maps_version);
        },
        fetchAddress: function(){
            if(_shopForm.shop.address !=  '') {
                $('#address').removeClass('has-error');

                this.getGeocode(_shopForm.shop.address);
            }else{
                toastr.error('informa la ubicación');
                $('#address').addClass('has-error');
            }
        },
        getGeocode: function(address){
                new google.maps.Geocoder().geocode({ address: address }, function(results, status) {
                    var position = {lat:'', lng:''};
                    position.lat = results[0].geometry.location.lat();
                    position.lng = results[0].geometry.location.lng();
                    
                    _shopForm.emptyMarkers();
                    _shopForm.centerMap(position.lat, position.lng);
                    _shopForm.addMarker(position.lat, position.lng);
                   
                    _shopForm.shop.geo = JSON.stringify(position);
                });

            },
            centerMap: function (lat, lng) {
                _shopForm.map.center = {lat, lng};
            },
            addMarker: function(lat, lng) {
                _shopForm.map.markers.push({
                    position: { lat: lat, lng: lng },
                    opacity: 1,
                    draggable: false,
                    enabled: true,
                    clicked: 0,
                    rightClicked: 0,
                    dragended: 0,
                    ifw: true,
                    ifw2text: this.shop.name
                });
                return _shopForm.map.markers[_shopForm.map.markers.length - 1];
            },
            emptyMarkers: function(){
                _shopForm.map.markers = [];
                _shopForm.shop.geo = "";
            },
        submitData: function(){ 
            if(!_shopForm.shop.id)
                _shopForm.insertShop();
            else
                _shopForm.updateShop();
        },//end submit data
        insertShop:function(){
            this.$http.post('/shops', _shopForm.shop)
            .then(function (response) {
                toastr.success('Sucesso!', 'Tienda criada con sucesso.');
                this.$emit('shop-created');
                this.reload();
            }).catch(function (response) {
                $.each(response.data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#'+key).addClass('has-error');
                });
            });
        },
        updateShop: function(){
            this.$http.put('/shops/'+_shopForm.shop.id, _shopForm.shop)
            .then(function (response) {
                toastr.success('Sucesso!', 'Tienda actualizada con sucesso.');
                this.$emit('shop-updated');
                this.reload();
            }).catch(function (response) {
                $.each(response.data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#'+key).addClass('has-error');
                });
            });
        },
        
        loadShop:function(){
            this.shop = this.pshop;
        },
        loadCustomer: function(){
            console.log(_shopForm.pcustomer_id);
            _shopForm.shop.customer_id = _shopForm.pcustomer_id;
        },
        reload: function(){

            _shopForm.data = {
                shop: {id:'', name: '', description: '', logo: '', address: '', geo:'', customer_id: 1},
                map :{ markers: [], center : {lat: -34.6248187, lng: -58.3761432}, zoom: 12}};


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