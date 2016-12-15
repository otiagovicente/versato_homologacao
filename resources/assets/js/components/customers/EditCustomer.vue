<template>
    <div class="content">
        <div class="portlet light">

            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>Cambiar Cliente
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
                            <input data-toggle="tooltip" title="Solo numeros!" id="cuit-input" class="form-control input-sm" type="text" v-model="customer.cuit" />
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
                        <small>Ubicación de la sede</small>
                        <div class="form-group form-line-input">
                            <input id="address-input" class="form-control" type="text" v-model="customer.address"/>
                            <div class="map" v-el:customermap style="width:100%;height:150px;"></div>   
                        </div>
                    </div>
                    <div class="col-md-8">
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-line-input">
                            <small>Ciudad</small>
                            <input id="locality" class="form-control input-sm" type="text" v-model="customer.city" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <small>Província</small>
                        <div class="form-group form-line-input">
                            <input id="administrative_area_level_1" class="form-control input-sm" type="text" v-model="customer.state" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <small>CPA</small>
                        <div class="form-group form-line-input">
                            <input id="postal_code" class="form-control input-sm" type="text" v-model="customer.zip" />
                        </div>
                    </div>
                    
                    <hr>
                    <div class="col-md-offset-4 col-md-8">
                        <!--<div class="map" v-el:customermap style="width:100%;height:150px;"></div>-->
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

    export default{
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            datepicker: VueStrap.datepicker,
        },
        
        props:['pcustomer'],
        
        data(){
            return{
                customer: {
                    id:'',
                    logo: "/images/default-placeholder.jpg",
                    address: "",
                    code:'',
                    company:'',
                    cuit:'',
                    name:'',
                    region_id:[],
                    geo:''
                },
                regions_select: [],
                infowindow: null,
                regions_select: [],
                center: {lat: -34.6248187, lng: -58.3761432},
                googleMap:'',
                zoom: 12,
                autocomplete:'',
                marker:'',
            }
        },
        ready(){
            window._editCustomer = this;
            _editCustomer.configureDropbox();
            _editCustomer.getRegions();
            _editCustomer.loadCustomer();
        },
        methods:{
            createMap() {
                _editCustomer.googleMap = new google.maps.Map(_editCustomer.$els.customermap, {
                    center: _editCustomer.center,
                    zoom: _editCustomer.zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    zoomControl: false
                });
                _editCustomer.initAutoComplete();
                if(_editCustomer.pcustomer){
                    if (_editCustomer.pcustomer.geo) {
                        var geo = JSON.parse(_editCustomer.pcustomer.geo);
                        _editCustomer.createMarkerAndCenterWithGeo(geo, _editCustomer.pcustomer.address);
                    }
                }
                
            },
            initAutoComplete(){
                _editCustomer.autocomplete = new google.maps.places.Autocomplete(
                    (document.getElementById('address-input')),
                    {types: ['geocode']}
                );
                _editCustomer.autocomplete.addListener('place_changed', _editCustomer.fillInAddress);
            },
            cleanAddressFields(){
                _editCustomer.customer.state = '';
                _editCustomer.customer.city = '';
                _editCustomer.customer.zip = '';
            },
            createMarkerAndCenterWithPlace(place){
                if(_editCustomer.marker) _editCustomer.marker.setMap(null);
                
                _editCustomer.marker = new google.maps.Marker({
                    map: _editCustomer.googleMap,
                    title: place.formatted_address,
                    position: place.geometry.location,
                    animation: google.maps.Animation.DROP,
                });
                
                _editCustomer.googleMap.setCenter(place.geometry.location);
            },
            createMarkerAndCenterWithGeo(geo, strAddress){
                _editCustomer.marker = new google.maps.Marker({
                    map: _editCustomer.googleMap,
                    title: strAddress,
                    position: geo,
                    animation: google.maps.Animation.DROP,
                });
                
                _editCustomer.googleMap.setCenter(geo);
            },
            setCustomerGeo(place){
                var geo = {lat:place.geometry.location.lat(), lng:place.geometry.location.lng()}
                _editCustomer.customer.geo = JSON.stringify(geo);
            },
            fillInAddress() {
                var place = _editCustomer.autocomplete.getPlace();
                if(place) {
                    _editCustomer.createMarkerAndCenterWithPlace(place);
                    _editCustomer.setCustomerGeo(place);
                    _editCustomer.cleanAddressFields();
                    _editCustomer.customer.address = place.formatted_address;

                    for (var i = 0; i < place.address_components.length; i++) {
                        var addressType = place.address_components[i].types[0];
                        switch (addressType){
                            case 'locality':
                                _editCustomer.customer.city = place.address_components[i].long_name;
                            break;
                            case 'administrative_area_level_1':
                                _editCustomer.customer.state = place.address_components[i].short_name;
                            break;
                            case 'postal_code':
                                _editCustomer.customer.zip = place.address_components[i].short_name;
                            break;
                        }
                    }
                } 
            },

            loadCustomer:function(){
                _editCustomer.customer = _editCustomer.pcustomer;
            },
            getRegions: function(){
                this.$http.get('/api/macroregions/selectlist')
                .then((response) => {
                    _editCustomer.regions_select = response.json();
                }, (response) => { 
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
                        _editCustomer.customer.logo = response;
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
                _editCustomer.$http.patch('/customers/'+_editCustomer.customer.id, _editCustomer.customer)
                .then((response) => {
                    toastr.success('Sucesso!','Região actualizada com sucesso');
                }, (response) => { 
                    $.each(response, function (key, value) {
                        toastr.warning('Atención', value);
                        $('#'+key).addClass('has-error');
                    });
                });
            }
        },
        events: {
            MapsApiLoaded: function () {
                this.createMap();
                return true;
            },
        },
    }
</script>