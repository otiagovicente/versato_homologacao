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
                    <div class="col-md-4">
                     <span class="blue">Codigo</span>
                        <div class="form-group form-line-input" id="code">
                            <input id="code-input" class="form-control input-sm" type="text" v-model="customer.code" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <span class="blue">Cuit</span>
                        <div class="form-group form-line-input" id="cuit">
                            <input id="cuit-input" class="form-control input-sm" type="text" v-model="customer.cuit" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <span class="blue">Company</span>
                        <div class="form-group form-line-input" id="company">
                            <input id="company-input" class="form-control input-sm" type="text" v-model="customer.company" />
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div class="col-md-4">
                        <small>Logo</small>
                        <div id="photo-input" class="form-group">
                            <div class="">
                                <img id="photo-image"  v-bind:src="customer.logo" class="figure-img img-fluid img-rounded customer-logo" alt="sem logo do cliente.">
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
                            <input id="name-input" class="form-control input-sm" type="text" v-model="customer.name" />
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
                        <small>Email:</small>
                        <div class="form-group form-line-input" id="email">
                            <input id="email-input" class="form-control input-sm" type="email" v-model="customer.email" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-line-input">
                            <small>Ciudad</small>
                            <input id="city-input" class="form-control input-sm" type="text" v-model="customer.city" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <small>Província</small>
                        <div class="form-group form-line-input">
                            <input id="state-input" class="form-control input-sm" type="text" v-model="customer.state" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <small>CPA</small>
                        <div class="form-group form-line-input">
                            <input id="zip-input" class="form-control input-sm" type="text" v-model="customer.zip" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <small>Ubicación de la sede</small>
                        <div class="input-group" id="address">

                            <input id="address-input" class="form-control" type="text"
                                   v-model="customer.address"
                                   @keyup.enter="fetchAddress"
                            />
                            <span class="input-group-btn">
                                <button class="btn blue" type="button" @click="fetchAddress">Go!</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <hr>
                    </div>
                    <div class="col-md-offset-4 col-md-8">

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
                                    <!--<info-window v-show="m.ifw" content="{{m.ifw2text}}"></info-window>-->
                                </marker>

                            </map>

                        </div>
                    </div>
                    <div class="col-md-offset-4 col-md-8 well">
                        <div class="col-md-4">
                            <small>Fone 1</small>
                            <div id="phone1" class="form-group form-line-input">
                                <input id="phone1-input" class="form-control input-sm" type="text" v-model="customer.phone1" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small>Fone 2</small>
                            <div id="phone2" class="form-group form-line-input">
                                <input id="phone2-input" class="form-control input-sm" type="text" v-model="customer.phone2" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small>Fone 3</small>
                            <div id="phone3" class="form-group form-line-input">
                                <input id="phone3-input" class="form-control input-sm" type="text" v-model="customer.phone3" />
                            </div>
                        </div>
                    </div>


                </div>
                <hr>
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-md-3 pull-right">
                            <div class="form-group">
                                <button type="button" @click="submitData" class="btn blue btn-block" id="send-btn">Salvar</button>
                            </div>
                        </div>
                        <div class="col-md-3 pull-right">
                            <div class="form-group">
                                <a href="/customers/"><button type="button" class="btn grey btn-block" id="cancel-btn">Cancel</button></a>
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
    .customer-logo {
        width:200px;
    }

    .map {
        width: 100%;
        height: 200px;
    }
</style>
<script>
    import VueStrap from 'vue-strap'
    import Dropzone from 'dropzone'
    import {Map, load, Marker, InfoWindow} from 'vue-google-maps'


    export default{
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            datepicker: VueStrap.datepicker,
            Map,
            load,
            Marker,
            InfoWindow
        },
        data(){
            return{
                customer: {
                    logo: "/images/default-placeholder.jpg",
                    address: "",
                    zip: "",
                    city: "",
                    state: "",
                    zip: "",
                    city: "",
                    phone1: "",
                    phone2: "",
                    phone3: "",
                    code:"",
                    company:"",
                    cuit:"",
                    name:"",
                    region_id:[],
                    geo:""
                },
                regions_select: [],
                map :{
                    markers: [],
                    center : {lat: -34.6248187, lng: -58.3761432},
                    zoom: 12
                },
            }
        },
        ready(){
            load(Maps.maps_key, Maps.maps_version)
            window._createCustomer = this;
            _createCustomer.configureDropbox();
            _createCustomer.getRegions();
            _createCustomer.configureMapsApi();
        },
        methods:{
            getRegions: function(){
                this.$http.get('/api/macroregions/selectlist')
                .then((response) => {
                    _createCustomer.regions_select = response.json();
                }, (response) => { 
                    toastr.error('No se puede conectar al servidor'); 
                });
            },
            configureMapsApi: function(){
                //load(Maps.maps_key,Maps.maps_version);
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
                        _createCustomer.customer.logo = response;
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
            fetchAddress: function(){
                if(_createCustomer.customer.address !=  '') {
                    $('#address').removeClass('has-error');

                    _createCustomer.getGeocode(_createCustomer.customer.address+', '+_createCustomer.customer.city+', '+_createCustomer.customer.state);
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
                    
                    _createCustomer.emptyMarkers();
                    _createCustomer.centerMap(position.lat, position.lng);
                    _createCustomer.addMarker(position.lat, position.lng);
                   
                    _createCustomer.customer.geo = JSON.stringify(position);
                });

            },
            centerMap: function (lat, lng) {
                _createCustomer.map.center = {lat, lng};
            },
            addMarker: function(lat, lng) {
                _createCustomer.map.markers.push({
                    position: { lat: lat, lng: lng },
                    opacity: 1,
                    draggable: false,
                    enabled: true,
                    clicked: 0,
                    rightClicked: 0,
                    dragended: 0,
                    ifw: true,
                    ifw2text: _createCustomer.customer.name
                });
                return _createCustomer.map.markers[_createCustomer.map.markers.length - 1];
            },
            emptyMarkers: function(){
                _createCustomer.map.markers = [];
            },
            submitData: function(){
                this.$http.post('/customers', this.customer)
                .then((response) => {
                    toastr.success('Sucesso!','Cliente creado con sucesso');
                }, (response) => { 
                    this.showErrors(response.data); 
                });
            }
        }
    }
</script>
