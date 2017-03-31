<template>
    <div class="content">
        <div class="col-md-7">
            <div class="portlet light">

                <div class="portlet-title">
                    <small>Código</small>
                    <div class="form-group form-line-input" id="code">
                        <input id="code-input" class="form-control input-sm" type="text" v-model="representative.code" />
                    </div>
                </div>
                <div class="portlet-body form">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="col-md-12" style="cursor:pointer;" @click="openSelectUser()">
                                    <small>Nombre</small>

                                    <h4 v-if="user.id"  class="font-blue" style="cursor:pointer;">{{user.name+' '+user.lastname}}</h4>
                                    <h4 v-else class="font-red" style="cursor:pointer;">Eligir Usuário</h4>
                                </div>
                                <div class="col-md-12" @click="openSelectRegion()" style="cursor:pointer;">
                                    <small>Región</small>

                                    <h4 class="font-blue" >
                                        <div v-if="regions" >
                                            <span v-for=" region in regions">
                                                {{region.description}},
                                            </span>
                                        </div>
                                        <div v-else>
                                            <span class="font-red" >Elige la región</span>
                                        </div>
                                    </h4>


                                </div>
                                <div class="col-md-12" @click="openSelectBrands()" style="cursor:pointer;">
                                    <small>Marcas</small>
                                    <div v-if="brands">
                                        <div class="row font-blue" v-for="brand in brands">
                                            <div class="col-md-5">
                                                {{brand.name}}
                                            </div>
                                            <div class="col-md-2">
                                                {{brand.comission}}%
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="row">
                                            <div class="container">
                                                <h4 class="font-red">Elige las Marcas</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                            </div>
                            <div class="col-md-4">

                                <img v-bind:src="user.photo" class="user-photo pull-right" @click="openSelectUser()"/>

                            </div>

                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <button class="btn grey">Cancelar</button>
                                    <button class="btn blue" @click="submit()">Guardar</button>
                                </div>
                            </div>
                        </div>


                </div>
            </div>
        </div>
    </div>

    <select-user></select-user>
    <select-region></select-region>
    <select-brands></select-brands>
</template>

<style>
    .user-photo{
        height: 280px;
        cursor:pointer;
        right : 10px;
    }
</style>
<script>
    import VueStrap from 'vue-strap'

    export default{
        data(){
            return {
                representative: {
                    code: '',
                    user_id: '',
                    regions: [],
                    brands: []
                },
                user: {
                    photo: '/images/default-placeholder.jpg',
                    name: '',
                    lastname: ''
                },
                regions: null,
                brands: null,
                macroregions_select: new Array(),
            }
        },
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
        },
        props: ['prepresentativeid'],
        computed: {
            'computeUserId': function () {
                _CreateRepresentative.representative.user_id = _CreateRepresentative.user.id;

            },
            'computeRegionsArray': function () {
                _CreateRepresentative.representative.regions = new Array();
                _.forEach(_CreateRepresentative.regions, function (region) {
                    _CreateRepresentative.representative.regions.push({
                        id: region.id
                    });
                });
            },
            'computeBrandsArray': function () {
                _CreateRepresentative.representative.brands = new Array();
                _.forEach(_CreateRepresentative.brands, function (brand) {
                    _CreateRepresentative.representative.brands.push({
                        brand_id: brand.id, comission: parseFloat(brand.comission)
                    });
                });
            },
        },
        ready(){
            window._CreateRepresentative = this;
            if (_CreateRepresentative.prepresentativeid) {
                _CreateRepresentative.loadData();
            }
            //_CreateRepresentative.getMacroRegions();
        },
        methods: {
            getMacroRegions: function(){
                this.$http.get('/api/macroregions/selectlist')
                .then(response => {
                    this.macroregions_select = response.json();
                });
            },

            /*
             * Funções de Carregamento
             */

            loadData: function () {
                _CreateRepresentative.loadRepresentative();
                _CreateRepresentative.loadUser();
                _CreateRepresentative.getBrands();
                _CreateRepresentative.getRegions();
            },

            loadRepresentative: function () {

                this.$http.get('/api/representatives/' + _CreateRepresentative.prepresentativeid)
                        .then(response => {
                            _CreateRepresentative.representative = response.json();
                        })
                        .catch(response => {
                            console.log(response.json());
                            toastr.error('No Fue possible cargar el representante');
                        });

            },

            loadUser: function () {

                this.$http.get('/api/representatives/' + _CreateRepresentative.prepresentativeid + '/user')
                        .then(response => {
                            _CreateRepresentative.user = response.json();
                        })
                        .catch(response => {
                            console.log(response.json());
                            toastr.error('No fue possible cargar el user');
                        });

            },
            getBrands: function () {
                this.$http.get('/api/representatives/' + _CreateRepresentative.prepresentativeid + '/brands')
                        .then(response => {
                            _CreateRepresentative.brands = response.json();
                        })
                        .catch(response => {
                            console.log(response.json());
                            toastr.error('No fue possible cargar las marcas');
                        });
            },

            getRegions: function () {

                this.$http.get('/api/representatives/' + _CreateRepresentative.prepresentativeid + '/regions')
                        .then(response => {
                            _CreateRepresentative.regions = response.json();
                        })
                        .catch(response => {
                            console.log(response.json());
                            toastr.error('No fue possible cargar las regiones');
                        });
            },

            /*
             * Funções de envio
             */
            submit: function () {

                _CreateRepresentative.representative.user_id = _CreateRepresentative.user.id;

                if (!_CreateRepresentative.representative.id) {
                    _CreateRepresentative.store();
                } else {
                    _CreateRepresentative.update();
                }

            },
            store: function () {
                _CreateRepresentative.loadBrandsToData();
                _CreateRepresentative.loadRegionsToData();

                this.$http.post('/representatives', _CreateRepresentative.representative)
                        .then(response => {
                            console.log(response.json());
                            toastr.success('Representante creado con exito');
                            _CreateRepresentative.regions = null;
                            _CreateRepresentative.brands = null;
                        })
                        .catch(response => {
                            $.each(response.data, function (key, value) {
                                toastr.error(value);
                                $('#' + key).addClass('has-error');
                            });
                        });
            },
            loadRegionsToData: function(){
                _CreateRepresentative.representative.regions = new Array();
                _.forEach(_CreateRepresentative.regions, function (region) {
                    _CreateRepresentative.representative.regions.push(region.id);
                });

                var blAdd = true,
                    _this = _CreateRepresentative;

                _.forEach(_this.regions, function (region){
                    for (var i=0; i < _this.representative.regions.length; ++i) {
                        if (!!_this.representative.regions[i] == region.id) blAdd = false;
                    }
                    if(blAdd) _this.representative.regions.push(region.id);
                });
            },
            loadBrandsToData: function(){
                _CreateRepresentative.representative.brands = new Array();
                _.forEach(_CreateRepresentative.brands, function (brand) {
                    _CreateRepresentative.representative.brands.push({
                        brand_id: brand.id, commission: parseFloat(brand.comission)
                    });
                });

                var blAdd = true;
                _.forEach(_CreateRepresentative.brands, function (brand) {
                    for (var i=0; i < _CreateRepresentative.representative.brands.length; ++i) {
                        if (_CreateRepresentative.representative.brands[i].brand_id == brand.id) blAdd = false;
                    }
                    if(blAdd) _CreateRepresentative.representative.brands.push({brand_id: brand.id, commision:brand.comission});
                });
            },
            update: function () {
                _CreateRepresentative.loadBrandsToData();
                _CreateRepresentative.loadRegionsToData();

                this.$http.patch('/representatives/' + _CreateRepresentative.prepresentativeid, _CreateRepresentative.representative)
                        .then(response => {
                            console.log(response.json());
                            toastr.success('Representante guardado con exito');
                            _CreateRepresentative.regions = null;
                            _CreateRepresentative.brands = null;
                        })
                        .catch(response => {
                            $.each(response.data, function (key, value) {
                                toastr.error(value);
                                $('#' + key).addClass('has-error');
                            });
                        });

            },

            /*
             * Funções de manejo de Componentes
             */
            openSelectUser: function () {
                _SelectUser.openWindow();
            },
            openSelectRegion: function () {
                if (_CreateRepresentative.regions) {
                    _SelectRegion.openWindow(_CreateRepresentative.regions);
                }
                _SelectRegion.openWindow();
            },
            openSelectBrands: function () {
                if (_CreateRepresentative.brands) {
                    _SelectBrands.openWindow(_CreateRepresentative.brands);
                }
                _SelectBrands.openWindow();
            }

        }
    }
</script>
