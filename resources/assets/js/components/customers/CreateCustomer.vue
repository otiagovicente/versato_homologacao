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

    #address-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 0px;
        padding: 0 0px 0 0px;
        text-overflow: ellipsis;
        width: 100%;
    }
</style>

<template>
    <div class="content">
        <div class="portlet light">

            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>Crear Cliente 
                    <button type="button" @click="showModal" class="btn blue btn-block" id="send-btn">Atención al Cliente</button>
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

    <!-- MODAL  -->
    <div id="cliente-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="infowindow-modal">
                        <div class="iw-container" style="display:block">
                            <div class="iw-title"></div>
                            
                            <div class="iw-content">
                                <div class="md-col-12">
                                    <div class="row">
                                        <div class="form-group form-line-input search">
                                            <h4>Buscar</h4>
                                            <div class="input-icon input-icon-lg right">
                                                <i class="fa fa-search font-green"></i>
                                                <input id="search-input" class="form-control input-lg" type="text" name="search" v-model="query" v-on:keyup.enter="search()">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-md-5">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <li>
                                                        <a aria-label="Previous" v-on:click="paginate(pagination.prev_page_url)" v-show="pagination.prev_page_url">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <li v-for="page in paginationLinks">
                                                        <a v-on:click="paginate(page.url)">{{ page.page }}1</a>
                                                    </li>
                                                    <li>
                                                        <a aria-label="Next" v-on:click="paginate(pagination.next_page_url)" v-show="pagination.next_page_url">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                     </div>
                                     <hr>
                                     <div class="row">

                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /MODAL  -->
</template>

<script>
    import VueStrap from 'vue-strap'
    import Dropzone from 'dropzone'

    export default{
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            datepicker: VueStrap.datepicker,
        },

        data(){
            return{
                customer: {
                    logo: "/images/default-placeholder.jpg",
                    address: "",
                    zip: "",
                    city: "",
                    state: "",
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
                infowindow: null,
                regions_select: [],
                center: {lat: -34.6248187, lng: -58.3761432},
                googleMap:'',
                zoom: 12,
                autocomplete:'',
                marker:'',
                query: '',
                pagination : {},
                paginationLinks : {},
                customers:{},
                type:null,
            }
        },
        
        ready(){
            window._createCustomer = this;
            _createCustomer.configureDropbox();
            _createCustomer.getRegions();
            _createCustomer.getImportedCustomers('search');
        },
        
        methods:{
            getImportedCustomers(){
                switch (_createCustomer.type) {
                    case 'search':
                        _createCustomer.getCustomersBySearch();
                        break;
                    default:
                        _createCustomer.getAllImportedCustomers();
                }
            },
            getCustomersBySearch(){
                _createCustomer.url = '/api/customers/getImportedCustomersBySearch?search=bla bla'; //+ _createCustomer.query;
                _createCustomer.paginate(this.url);
            },
            getAllImportedCustomers(){
                _createCustomer.url = '/api/customers/getImportedCustomers';
                _createCustomer.paginate(this.url);
            },

            paginate(paginationUrl){
                console.log(paginationUrl);
                this.$http.get(paginationUrl)
                        .then(response => {
                            _createCustomer.pagination = response.json();
                            _createCustomer.pagination.data = null;
                            _createCustomer.customers = response.json().data;
                            _createCustomer.buildPaginationLinks();
                        })
                        .catch(response => {
                            toastr.error('no fue possible cargar los productos');
                        });
            },
            buildPaginationLinks(){
                var o = {};
                for (var i = 0; i < _ListProducts.pagination.last_page; i++) {
                    o.url = _createCustomer.url+'?page='+(i + 1);
                    o.page = (i+1);
                    _createCustomer.paginationLinks[i] = o;
                }
            },

            createMap() {
                _createCustomer.googleMap = new google.maps.Map(_createCustomer.$els.customermap, {
                    center: _createCustomer.center,
                    zoom: _createCustomer.zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    zoomControl: false
                });
                _createCustomer.initAutoComplete();
            },
            initAutoComplete(){
                _createCustomer.autocomplete = new google.maps.places.Autocomplete(
                    (document.getElementById('address-input')),
                    {types: ['geocode']}
                );
                _createCustomer.autocomplete.addListener('place_changed', _createCustomer.fillInAddress);
            },
            cleanAddressFields(){
                _createCustomer.customer.state = '';
                _createCustomer.customer.city = '';
                _createCustomer.customer.zip = '';
            },
            createMarkerAndCenter(place){
                if(_createCustomer.marker) _createCustomer.marker.setMap(null);
                
                _createCustomer.marker = new google.maps.Marker({
                    map: _createCustomer.googleMap,
                    title: place.formatted_address,
                    position: place.geometry.location,
                    animation: google.maps.Animation.DROP,
                });
                _createCustomer.googleMap.setCenter(place.geometry.location);
            },
            setCustomerGeo(place){
                var geo = {lat:place.geometry.location.lat(), lng:place.geometry.location.lng()}
                _createCustomer.customer.geo = JSON.stringify(geo);
            },
            fillInAddress() {
                var place = _createCustomer.autocomplete.getPlace();
                if(place) {
                    _createCustomer.createMarkerAndCenter(place);
                    _createCustomer.setCustomerGeo(place);
                    
                    _createCustomer.cleanAddressFields();
                    _createCustomer.customer.address = place.formatted_address;

                    for (var i = 0; i < place.address_components.length; i++) {
                        var addressType = place.address_components[i].types[0];
                        switch (addressType){
                            case 'locality':
                                _createCustomer.customer.city = place.address_components[i].long_name;
                            break;
                            case 'administrative_area_level_1':
                                _createCustomer.customer.state = place.address_components[i].short_name;
                            break;
                            case 'postal_code':
                                _createCustomer.customer.zip = place.address_components[i].short_name;
                            break;
                        }
                    }
                } 
            },

            getRegions: function(){
                this.$http.get('/api/macroregions/selectlist')
                .then((response) => {
                    _createCustomer.regions_select = response.json();
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

            submitData: function(){
                this.$http.post('/customers', this.customer)
                .then((response) => {
                    toastr.success('Sucesso!','Cliente creado con sucesso');
                }, (response) => { 
                    this.showErrors(response.data); 
                });
            },

            showErrors: function(data){
                $.each(data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#'+key).addClass('has-error');
                });
            },
            showModal(polygon){
                $('#cliente-modal').modal('show');
            },
        },
        events: {
            MapsApiLoaded: function () {
                this.createMap();
                return true;
            },
        },
    }
</script>
