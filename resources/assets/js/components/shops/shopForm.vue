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

    <div class="modal fade" id="create-shop" tabindex="-1" role="create-shop" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">


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
                                                        <div class="row">

                                                            <div class="form-group" id="name" >
                                                                <label  class="control-label">Nombre</label>
                                                                <input type="text" placeholder="la tienda" class="form-control" v-model="shop.name" />
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label"  id="about-input" >Descripción</label>
                                                                <textarea class="form-control" rows="3" placeholder="Una breve descripcion de la tienda" v-model="shop.description"></textarea>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <small>Ubicación de la tienda</small>
                                                                <div class="input-group" id="address">

                                                                    <input id="address-input" class="form-control" type="text"
                                                                        v-model="shop.address"
                                                                        debounce="800"
                                                                    />
                                                                    <span class="input-group-btn">
                                                                        <button class="btn blue" type="button" @click="fetchAddress">Go!</button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr>
                                                                <div class="map" v-el:shopmap>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <hr>
                                                        </div>

                                                        <div class="row">
                                                            <div class="container-fluid">
                                                                <div class="col-md-3 pull-right">
                                                                    <div v-show="canedit" class="form-group">
                                                                        <button type="button" class="btn grey btn-block" data-dismiss="modal" id="cancel-btn">Cerrar</button>

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



                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</template>

<script type="text/babel">
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

        props: ['pshop', 'isedit', 'pcustomer_id'],

        data(){
            return {
                canedit: true,
                customers_select: [],
                shop: {
                    id: '',
                    name: '',
                    description: '',
                    logo: '',
                    address: '',
                    geo: '',
                    customer_id: [],
                },
                googleMap: {},
                map: {
                    markers: [],
                    center: {lat: -34.6248187, lng: -58.3761432},
                    zoom: 12
                },
            }
        },
        events: {
            MapsApiLoaded: function () {

                _shopForm.createMap();

                if (_shopForm.pshop) _shopForm.loadShop();

                return true;
            },
            showShopsFormModal: function () {

                $("#create-shop").on("shown.bs.modal", function (e) {
                    google.maps.event.trigger(_shopForm.googleMap, "resize");
                });

                $("#create-shop").on("hidden.bs.modal", function (e) {

                    _shopForm.reload();
                    google.maps.event.trigger(_shopForm.googleMap, "resize");
                    console.log('dispara.');

                });

                _shopForm.openWindow();
                return true;
            }
        },
        watch: {
            'shop.address': function () {
                if (_shopForm.shop.address != '') {
                    _shopForm.fetchAddress();
                }
            }
        },
        ready(){
            window._shopForm = this;

            toastr.options.closeButton = true;

            _shopForm.configureDropzone();

            _shopForm.canedit = _shopForm.isedit;

            if (_shopForm.pcustomer_id) _shopForm.loadCustomer();
        },

        methods: {
            getCustomers: function () {
                this.$http.get('/api/customers/selectlist')
                        .then(response => {
                            this.customers_select = response.json();
                        });
            },
            configureMapsApi: function () {
                if (!(typeof google === 'object' && typeof google.maps === 'object')) {
                    load(Maps.maps_key, Maps.maps_version);
                }
            },



            /*
             * Funções de Envio
             */
            submitData: function () {
                _shopForm.fetchAddress();
                if (!_shopForm.shop.id) {
                    _shopForm.store();
                }
                else {
                    _shopForm.update();
                }
            },//end submit data
            store: function () {
                this.$http.post('/shops', _shopForm.shop)
                        .then(function (response) {
                            toastr.success('Sucesso!', 'Tienda criada con sucesso.');
                            this.$dispatch('ShopCreated');
                            _shopForm.closeWindow();
                        }).catch(function (response) {
                    $.each(response.data, function (key, value) {
                        toastr.warning('Atención', value);
                        $('#' + key).addClass('has-error');
                    });
                });
            },
            update: function () {
                this.$http.put('/shops/' + _shopForm.shop.id, _shopForm.shop)
                        .then(function (response) {
                            toastr.success('Sucesso!', 'Tienda actualizada con sucesso.');
                            this.$dispatch('ShopUpdated');
                            _shopForm.closeWindow();
                        }).catch(function (response) {
                    $.each(response.data, function (key, value) {
                        toastr.warning('Atención', value);
                        $('#' + key).addClass('has-error');
                    });
                });
            },


            /*
             * Funções de carregamento
             */
            loadShop: function (shopId) {

                this.$http.get('/api/shops/' + shopId)
                        .then(response => {
                            _shopForm.shop = response.json();
                            if (!(_shopForm.shop.geo == '')) {
                                var geo = JSON.parse(_shopForm.shop.geo);
                                _shopForm.centerMap(geo.lat, geo.lng);
                                _shopForm.addMarker(geo.lat, geo.lng);
                            }
                        }).catch(response => {
                    toastr.error('No fue possible cargar a la tienda');
                });
            },
            loadCustomer: function () {
                _shopForm.shop.customer_id = _shopForm.pcustomer_id;
            },

            /*
             * Funcões de Janela
             */

            openWindow: function (shopId) {
                if (shopId) {
                    _shopForm.loadShop(shopId);
                }
                $('#create-shop').modal();
            },
            closeWindow: function () {
                $('#create-shop').modal('hide');
            },
            reload: function () {
                _shopForm.emptyMarkers();

                _shopForm.shop = {
                    id: '',
                    name: '',
                    description: '',
                    logo: '',
                    address: '',
                    geo: '',
                    customer_id: _shopForm.pcustomer_id
                };
                _shopForm.map = {markers: [], center: {lat: -34.6248187, lng: -58.3761432}, zoom: 14};


            },

            /*
             *  Funções de Mapa
             *
             */

            createMap: function () {
                _shopForm.googleMap = new google.maps.Map(this.$els.shopmap, {
                    center: _shopForm.map.center,
                    zoom: _shopForm.map.zoom
                });
            },
            fetchAddress: function () {
                if (_shopForm.shop.address != '') {
                    $('#address').removeClass('has-error');
                    this.getGeocode(_shopForm.shop.address);
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

                        _shopForm.emptyMarkers();
                        _shopForm.centerMap(position.lat, position.lng);
                        _shopForm.addMarker(position.lat, position.lng);

                        _shopForm.shop.geo = JSON.stringify(position);
                    } else {
                        toastr.error('No se puede encontrar la ubicación!');
                    }
                });

            },
            centerMap: function (lat, lng) {

                _shopForm.googleMap.setCenter({lat: lat, lng: lng});

            },
            addMarker: function (lat, lng) {

                var marker = new google.maps.Marker({
                    map: _shopForm.googleMap,
                    animation: google.maps.Animation.DROP,
                    position: {lat: lat, lng: lng}
                });
                _shopForm.map.markers.push(marker);

            },
            emptyMarkers: function () {

                _.forEach(_shopForm.map.markers, function (value) {
                    value.setMap(null);
                });
                _shopForm.map.markers = [];
                _shopForm.shop.geo = "";
            },


            /*
             *  Configuração do Dropzone
             */
            configureDropzone: function () {
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

                    success: function (file, response) {
                        _shopForm.shop.logo = response;
                        this.removeAllFiles(true);
                    },

                    init: function () {
                        this.on("maxfilesexceeded", function (file) {
                            toastr.warning('Número de arquivos excedido!', 'Você só pode inserir um arquivo');
                        });
                        this.on("error", function (file, errorMessage) {
                            toastr.error('Erro!', "Confira se o arquivo possui as características necessárias!");
                            this.removeAllFiles(true);
                        });
                    }

                };
                var photoDropzone = new Dropzone("div#photo", dropzoneOptions);

                photoDropzone.accept = function (file, done) {

                    bootbox.confirm("Seguro que quieres hacer el upload de una imágene de la tienda?", function (result) {
                        if (result) {
                            done();
                            photoDropzone.processQueue();
                        } else {
                            photoDropzone.removeAllFiles(true);
                            done(result);
                        }
                    });
                };
            },
        }, //end methods
        filters: {}
    }
</script>