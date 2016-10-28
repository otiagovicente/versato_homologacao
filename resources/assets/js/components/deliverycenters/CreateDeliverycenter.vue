<template>
    <div class="content">
        <div class="portlet light">

            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>Crear Centro de Entrega
                </div>

            </div>
            <div class="portlet-body form">
                <div class="row">

                    <div class="col-md-12">
                        <small>Nombre</small>
                        <div class="form-group form-line-input" id="name">
                            <input id="name-input" class="form-control input-sm" type="text" v-model="deliverycenter.name" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <small>Descripción</small>
                        <div class="form-group form-line-input" id="description">
                            <input id="description-input" class="form-control input-sm" type="text" v-model="deliverycenter.description" />
                        </div>
                    </div>

                    <div class="col-md-5">
                        <small>Ciudad</small>
                        <div class="form-group form-line-input" id="city">
                            <input id="city-input" class="form-control input-sm" type="text" v-model="deliverycenter.city" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <small>Província</small>
                        <div class="form-group form-line-input" id="state">
                            <input id="state-input" class="form-control input-sm" type="text" v-model="deliverycenter.state" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <small>CPA</small>
                        <div class="form-group form-line-input" id="zip">
                            <input id="zip-input" class="form-control input-sm" type="text" v-model="deliverycenter.zip" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <small>Ubicación</small>
                        <div class="input-group" id="address">

                            <input id="address-input" class="form-control" type="text"
                                   v-model="deliverycenter.address"
                                   @keyup.enter="fetchAddress()"
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
                                    <!--<info-window v-show="m.ifw" content="{{m.ifw2text}}"></info-window>-->
                                </marker>

                            </map>

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
<script type="text/babel">
    import VueStrap from 'vue-strap'
    import Dropzone from 'dropzone'
    import {Map, load, Marker, InfoWindow} from 'vue-google-maps'
    //    import google from 'google-maps'


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
        props:['pcustomer_id'],
        data(){
            return{
                deliverycenter: {
                    id:'',
                    logo: "/images/default-placeholder.jpg",
                    address: "",
                    city: "",
                    state: "",
                    zip: "",
                    company:'',
                    cuit:'',
                    name:'',
                    region_id:[],
                    geo:''
                },
                regions_select: [],
                map :{
                    markers: [],
                    center : {lat: -34.6248187, lng: -58.3761432},
                    zoom: 12
                },
            }
        },
        events: {
            MapsApiLoaded: function () {

                _createDeliveryCenter.createMap();

                if (_createDeliveryCenter.pshop) _createDeliveryCenter.loadShop();

                return true;
            },
            showCreateDeliveryCenterModal: function () {

                $("#create-deliverycenter").on("shown.bs.modal", function (e) {
                    google.maps.event.trigger(_createDeliveryCenter.googleMap, "resize");
                });

                $("#create-deliverycenter").on("hidden.bs.modal", function (e) {

                    if (!_createDeliveryCenter.pshop) {
                        _createDeliveryCenter.reload();
                        _createDeliveryCenter.emptyMarkers();
                    }
                    console.log('dispara.');

                });

                _createDeliveryCenter.openWindow();
                return true;
            }
        },
        watch: {
            'deliverycenter.address': function () {
                if (_createDeliveryCenter.shop.address != '') {
                    _createDeliveryCenter.fetchAddress();
                }
            }
        },
        ready(){
            window._createDeliveryCenter = this;
//            _createDeliveryCenter.configureMapsApi();
            _createDeliveryCenter.loadCustomer();
        },
        methods:{
            loadCustomer:function(){
                _createDeliveryCenter.deliverycenter.customer_id = _createDeliveryCenter.pcustomer_id;
            },




            /*
             *  Funções de Mapa
             *
             */


            createMap: function () {
                _createDeliveryCenter.googleMap = new google.maps.Map(this.$els.shopmap, {
                    center: _createDeliveryCenter.map.center,
                    zoom: _createDeliveryCenter.map.zoom
                });
            },
            centerMap: function (lat, lng) {

                _createDeliveryCenter.googleMap.setCenter({lat: lat, lng: lng});

            },
            addMarker: function (lat, lng) {

                var marker = new google.maps.Marker({
                    map: _createDeliveryCenter.googleMap,
                    animation: google.maps.Animation.DROP,
                    position: {lat: lat, lng: lng}
                });
                _createDeliveryCenter.map.markers.push(marker);

            },
            emptyMarkers: function () {

                _.forEach(_createDeliveryCenter.map.markers, function (value) {
                    value.setMap(null);
                });
                _createDeliveryCenter.map.markers = [];
                _createDeliveryCenter.shop.geo = "";
            },

            fetchAddress: function(){
                if(_createDeliveryCenter.deliverycenter.address !=  '') {
                    $('#address').removeClass('has-error');
                    _createDeliveryCenter.getGeocode(_createDeliveryCenter.deliverycenter.address+', '+_createDeliveryCenter.deliverycenter.city+', '+_createDeliveryCenter.deliverycenter.state);
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

                    _createDeliveryCenter.emptyMarkers();
                    _createDeliveryCenter.centerMap(position.lat, position.lng);
                    _createDeliveryCenter.addMarker(position.lat, position.lng);
                });

            },

            /*
             * Funcões de Janela
             */

            openWindow: function(){
                $('#create-deliverycenter').modal();
            },
            closeWindow: function () {
                $('#create-deliverycenter').modal('hide');
            },

            /*
             *   Funções de Envio
             */

            submitData: function(){
                _createDeliveryCenter.$http.post('/deliverycenters/', data().deliverycenter)
                        .then((response) => {
                            toastr.success('Sucesso!','Centro de Entrega incluyida com exito!');
                        }, (response) => {
                            _createDeliveryCenter.showErrors(response.data);
                        });
            }
        }
    }
</script>
