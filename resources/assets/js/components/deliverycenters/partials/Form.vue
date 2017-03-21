<template>
    <div class="profile-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">Centro de entrega</span>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1_1" data-toggle="tab">Informaciones</a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <!-- PERSONAL INFO TAB -->
                            <div class="tab-pane active" id="tab_1_1">

                                    <div class="form-group" id="name-input" >
                                        <label  class="control-label">Nombre</label>
                                        <input type="text" placeholder="la tienda" class="form-control" v-model="deliverycenter.name" /> </div>

                                    <div class="form-group">
                                        <label class="control-label"  id="about-input" >Descripción</label>
                                        <textarea class="form-control" rows="3" placeholder="Una breve descripcion de la tienda" v-model="deliverycenter.description"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <small>Ubicación del centro</small>
                                        <div class="input-group" id="address">

                                            <input id="address-input" class="form-control" type="text"
                                                   v-model="deliverycenter.address"
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
                                                    <!--<info-window v-show="m.ifw" content="{{m.ifw2text}}"></info-window>-->
                                                </marker>
                                            </map>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="col-md-3 pull-right">
                                                <div v-show="canedit" class="form-group">
                                                    <a href="/deliverycenters/"><button type="button" class="btn grey btn-block" id="cancel-btn">Cancel</button></a>
                                                </div>
                                                <div v-show="!canedit" class="form-group">
                                                    <a href="/deliverycenters/"><button type="button" class="btn grey btn-block" id="cancel-btn">Voltar</button></a>
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
                            </div>
                            <!-- END PERSONAL INFO TAB -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .map {
        width: 100%;
        height: 200px;
    }
</style>
<script>
    import VueStrap from 'vue-strap'
    import toastr from 'toastr'
    import Dropzone from 'dropzone'
    import {Map, load, Marker, InfoWindow} from 'vue-google-maps'

    export default{
        components:{
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            Map,
            load,
            Marker,
            InfoWindow
        },
        data(){
            return{
                msg:'hello vue'
            }
        },
        methods:{
            configureMapsApi: function(){
                //load(Maps.maps_key,Maps.maps_version);
            },
            fetchAddress: function(){
                if(_this.deliverycenter.address !=  '') {
                    $('#address').removeClass('has-error');

                    this.getGeocode(_this.deliverycenter.address);
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

                    _this.emptyMarkers();
                    _this.centerMap(position.lat, position.lng);
                    _this.addMarker(position.lat, position.lng);

                    _this.deliverycenter.geo = JSON.stringify(position);
                });

            },
            centerMap: function (lat, lng) {
                _this.map.center = {lat, lng};
            },
            addMarker: function(lat, lng) {
                _this.map.markers.push({
                    position: { lat: lat, lng: lng },
                    opacity: 1,
                    draggable: false,
                    enabled: true,
                    clicked: 0,
                    rightClicked: 0,
                    dragended: 0,
                    ifw: true,
                    ifw2text: this.deliverycenter.name
                });
                return _this.map.markers[_this.map.markers.length - 1];
            },
            emptyMarkers: function(){
                _this.map.markers = [];
                _this.deliverycenter.geo = "";
            },
        }
    }
</script>
