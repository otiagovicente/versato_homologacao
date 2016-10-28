<template>
    <div class="col-md-6">
        <div class="row">
            <div class="content">
                <div class="portlet light">
                    <div class="portlet-body form">
                         <div class="row">
                             <div class="col-md-6">
                                 <img id="photo-image"  v-bind:src="customer.logo" class="figure-img img-fluid img-rounded customer-logo" alt="sem logo do cliente.">

                                 <h3>{{customer.name}}</h3>
                                 <h4>{{customer.company}}</h4>
                                 <h4>código: {{customer.code}}</h4>
                                 <h4>cuit: {{customer.cuit}}</h4>
                             </div>
                             <div class="col-md-6">
                                 <div class="well">
                                     <h3>{{customer.company}}</h3>
                                     <address>
                                         <strong>{{customer.address}}</strong>
                                         <br>{{customer.city}}, {{customer.state}}
                                         <br>{{customer.zip}}
                                         <br><abbr v-show="customer.phone1" title="Phone">P:</abbr> {{customer.phone1}}
                                         <br><abbr v-show="customer.phone2" title="Phone">P:</abbr> {{customer.phone2}}
                                         <br><abbr v-show="customer.phone3" title="Phone">P:</abbr> {{customer.phone3}}
                                     </address>
                                 </div>
                             </div>

                         </div>
                         <hr>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="map" v-el:customermap>


                                </div>
                            </div>
                         </div>
                        <hr>
                         <div class="row">
                             <div class="col-md-12">
                                 <a class="btn blue btn-outline sbold pull-right" @click="showShopsForm()"> Crear Tienda </a>
                                 <a class="btn green btn-outline sbold pull-right" style="margin-right:10px;" @click="showCreateDeliveryCenter()"> Crear Centro de Entrega </a>
                             </div>
                         </div>


                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <list-shops :pcustomer_id="pcustomer_id"></list-shops>
    </div>

    <div class="col-md-6">
        <list-deliverycenter :pcustomer_id="pcustomer_id" ></list-deliverycenter>
    </div>

    <shop-form
            :isedit="true" :pcustomer_id="pcustomer_id">
    </shop-form>



    <create-deliverycenter
            :isedit="true" :pcustomer_id="pcustomer_id">
    </create-deliverycenter>

</template>
<style>
    .customer-logo {
        width:200px;
    }

    .map {
        width: 100%;
        height: 200px;
    }
</style>
<script type="text/babel">
    //    import shopForm from '../shops/shopForm.vue'
    import VueStrap from 'vue-strap'
    import Dropzone from 'dropzone'
    import {Map, load, Marker, InfoWindow} from 'vue-google-maps'


    export default{
        components: {
            Map,
            load,
            Marker,
            InfoWindow,
//            'shop-form': shopForm,
        },
        props: ['pcustomer_id'],
        data(){
            return {
                customer: {
                    id: '',
                    logo: "/images/default-placeholder.jpg",
                    address: "",
                    code: '',
                    company: '',
                    cuit: '',
                    name: '',
                    region_id: [],
                    geo: ''
                },

                googleMap: {},

                map: {
                    markers: [],
                    center: {lat: -34.6248187, lng: -58.3761432},
                    zoom: 14
                },

                shops: [],
                shopsearch: ''
            }
        },
        watch: {
            'map.center': function(){
                console.log(_showCustomer.map.center)
            }
        },
        events: {
            MapsApiLoaded: function () {
                _showCustomer.createMap();
                _showCustomer.getCustomer();
                return true;
            }
        },
        ready(){
            window._showCustomer = this;
        },
        methods: {
            getCustomer: function () {

                this.$http.get('/api/customers/' + _showCustomer.pcustomer_id)
                        .then((response)=> {
                            _showCustomer.customer = response.json();
                            if (!(_showCustomer.customer.geo == '')) {
                                var geo = JSON.parse(_showCustomer.customer.geo);
                                _showCustomer.centerMap(geo.lat, geo.lng);
                                _showCustomer.addMarker(geo.lat, geo.lng);
                            }

                        }).catch((response)=> {
                    toastr.error('No se puede conectar al servidor. getCustomer Fails');
                });

            },

            createMap: function () {
                _showCustomer.googleMap = new google.maps.Map(this.$els.customermap, {
                    center: _showCustomer.map.center,
                    zoom: _showCustomer.map.zoom
                });
            },
            centerMap: function (lat, lng) {

                _showCustomer.googleMap.setCenter({lat: lat, lng: lng});

            },
            addMarker: function (lat, lng) {

                var marker = new google.maps.Marker({
                    map: _showCustomer.googleMap,
                    animation: google.maps.Animation.DROP,
                    position: {lat: lat, lng: lng}
                });
                _showCustomer.map.markers.push(marker);

            },
            emptyMarkers: function(){

                _.forEach(_showCustomer.map.markers, function(value) {
                    value.setMap(null);
                });
                _showCustomer.map.markers = [];
                _showCustomer.customer.geo = "";
            },
            showCreateDeliveryCenter: function () {

                this.$broadcast('showCreateDeliveryCenterModal');

            },
            showShopsForm: function () {
                this.$broadcast('showShopsFormModal');


            }
        }
    }
</script>
