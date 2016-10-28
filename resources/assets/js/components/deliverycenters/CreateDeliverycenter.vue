<template>

    <div class="modal fade" id="create-deliverycenter" tabindex="-1" role="create-shop" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">




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
                                                       debounce="800"
                                                />
                                                <span class="input-group-btn">
                                                    <button class="btn blue" type="button" @click="fetchAddress">Go!</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <hr>
                                            <div class="map" v-el:deliverycentermap >

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




                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
    //    import google from 'google-maps'


    export default{
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            datepicker: VueStrap.datepicker,
        },
        props: ['pcustomer_id'],
        data(){
            return {
                deliverycenter: {
                    id: '',
                    logo: "/images/default-placeholder.jpg",
                    address: "",
                    city: "",
                    state: "",
                    zip: "",
                    company: '',
                    cuit: '',
                    name: '',
                    region_id: [],
                    geo: ''
                },
                regions_select: [],
                map: {
                    markers: [],
                    center: {lat: -34.6248187, lng: -58.3761432},
                    zoom: 12
                },
            }
        },
        events: {
            MapsApiLoaded: function () {

                _CreateDeliveryCenter.createMap();

                if (_CreateDeliveryCenter.pdeliverycenter) _CreateDeliveryCenter.loadDeliveryCenter();

                return true;
            },
            showCreateDeliveryCenterModal: function () {

                $("#create-deliverycenter").on("shown.bs.modal", function (e) {
                    google.maps.event.trigger(_CreateDeliveryCenter.googleMap, "resize");
                });

                $("#create-deliverycenter").on("hidden.bs.modal", function (e) {

                    _CreateDeliveryCenter.reload();
                    console.log('dispara.');

                });

                _CreateDeliveryCenter.openWindow();
                return true;
            }
        },
        watch: {
            'deliverycenter.address': function () {
                if (_CreateDeliveryCenter.deliverycenter.address != '') {
                    _CreateDeliveryCenter.fetchAddress();
                }
            }
        },
        ready(){
            window._CreateDeliveryCenter = this;
            _CreateDeliveryCenter.loadCustomer();
        },
        methods: {

            loadCustomer: function () {
                _CreateDeliveryCenter.deliverycenter.customer_id = _CreateDeliveryCenter.pcustomer_id;
            },
            loadDeliveryCenter: function (deliveryCenterId) {

                this.$http.get('/api/deliverycenters/' + deliveryCenterId)
                        .then(response => {
                            _CreateDeliveryCenter.deliverycenter = response.json();
                            if (!(_CreateDeliveryCenter.deliverycenter.geo == '')) {
                                var geo = JSON.parse(_CreateDeliveryCenter.deliverycenter.geo);
                                _CreateDeliveryCenter.centerMap(geo.lat, geo.lng);
                                _CreateDeliveryCenter.addMarker(geo.lat, geo.lng);
                            }
                        }).catch(response => {
                    toastr.error('No fue possible cargar a la tienda');
                });

            },


            /*
             *  Funções de Mapa
             *
             */


            createMap: function () {
                _CreateDeliveryCenter.googleMap = new google.maps.Map(this.$els.deliverycentermap, {
                    center: _CreateDeliveryCenter.map.center,
                    zoom: _CreateDeliveryCenter.map.zoom
                });
            },
            centerMap: function (lat, lng) {

                _CreateDeliveryCenter.googleMap.setCenter({lat: lat, lng: lng});

            },
            addMarker: function (lat, lng) {

                var marker = new google.maps.Marker({
                    map: _CreateDeliveryCenter.googleMap,
                    animation: google.maps.Animation.DROP,
                    position: {lat: lat, lng: lng}
                });
                _CreateDeliveryCenter.map.markers.push(marker);

            },
            emptyMarkers: function () {

                _.forEach(_CreateDeliveryCenter.map.markers, function (value) {
                    value.setMap(null);
                });
                _CreateDeliveryCenter.map.markers = [];
                _CreateDeliveryCenter.deliverycenter.geo = "";
            },
            fetchAddress: function () {
                if (_CreateDeliveryCenter.deliverycenter.address != '') {
                    $('#address').removeClass('has-error');

                    this.getGeocode(_CreateDeliveryCenter.deliverycenter.address);
                } else {
                    toastr.error('informa la ubicación');
                    $('#address').addClass('has-error');
                }
            },
            getGeocode: function (address) {
                new google.maps.Geocoder().geocode({address: address}, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        var position = {lat: '', lng: ''};
                        position.lat = results[0].geometry.location.lat();
                        position.lng = results[0].geometry.location.lng();

                        _CreateDeliveryCenter.emptyMarkers();
                        _CreateDeliveryCenter.centerMap(position.lat, position.lng);
                        _CreateDeliveryCenter.addMarker(position.lat, position.lng);

                        _CreateDeliveryCenter.deliverycenter.geo = JSON.stringify(position);
                    } else {
                        toastr.error('No se puede encontrar la ubicación!');
                    }
                });

            },


            /*
             * Funcões de Janela
             */

            openWindow: function (deliveryCenterId) {
                if (deliveryCenterId) {
                    _CreateDeliveryCenter.loadDeliveryCenter(deliveryCenterId);
                }
                $('#create-deliverycenter').modal();
            },
            closeWindow: function () {
                $('#create-deliverycenter').modal('hide');
            },
            reload: function () {

                _CreateDeliveryCenter.emptyMarkers();
                _CreateDeliveryCenter.deliverycenter = {
                    id: '',
                    logo: "/images/default-placeholder.jpg",
                    address: "",
                    city: "",
                    state: "",
                    zip: "",
                    company: '',
                    cuit: '',
                    name: '',
                    region_id: [],
                    geo: ''
                };
                _CreateDeliveryCenter.regions_select= [];

                _CreateDeliveryCenter.map = {
                    markers: [],
                    center: {lat: -34.6248187, lng: -58.3761432},
                    zoom: 12
                };

            },

            /*
             *   Funções de Envio
             */

            submitData: function () {
                _CreateDeliveryCenter.fetchAddress();
                if (!_CreateDeliveryCenter.deliverycenter.id) {
                    _CreateDeliveryCenter.store();
                }
                else {
                    _CreateDeliveryCenter.update();
                }
            },
            store: function(){
                this.$http.post('/deliverycenters', _CreateDeliveryCenter.deliverycenter)
                        .then(function (response) {
                            toastr.success('Exito!', 'Centro de Entrega criada con sucesso.');
                            this.$dispatch('DeliveryCenterCreated');
                            _CreateDeliveryCenter.closeWindow();
                        }).catch(function (response) {
                    $.each(response.data, function (key, value) {
                        toastr.warning('Atención', value);
                        $('#' + key).addClass('has-error');
                    });
                });
            },
            update: function(){
                this.$http.patch('/deliverycenters/'+_CreateDeliveryCenter.deliverycenter.id, _CreateDeliveryCenter.deliverycenter)
                        .then(function (response) {
                            toastr.success('Exito!', 'Centro de Entrega criada con sucesso.');
                            this.$dispatch('DeliveryCenterUpdated');
                            _CreateDeliveryCenter.closeWindow();
                        }).catch(function (response) {
                    $.each(response.data, function (key, value) {
                        toastr.warning('Atención', value);
                        $('#' + key).addClass('has-error');
                    });
                });
            }
        }
    }
</script>
