<template>
    <div class="content">
        <div class="col-md-8">
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
                                    <h4 v-else class="font-red">Eligir Usuário</h4>
                                </div>
                                <div class="col-md-12" @click="openSelectRegion()" style="cursor:pointer;">
                                    <small>Región</small>

                                    <h4 class="font-blue" >
                                        <div v-if="regions">
                                            <span v-for=" region in regions">
                                            {{region.description}},
                                        </span>
                                        </div>
                                        <div v-else>
                                            <span class="font-red">Elige la región</span>
                                        </div>
                                    </h4>


                                </div>
                                <div class="col-md-12" @click="openSelectBrands()">
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


                            </div>
                            <div class="col-md-4">

                                <img v-bind:src="user.photo" class="user-photo" @click="openSelectUser()"/>

                            </div>

                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <button class="btn grey">Cancelar</button>
                                    <button class="btn blue" @click="submitData()">Guardar</button>
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
<script type="text/babel">
    import VueStrap from 'vue-strap'
    export default{
        data(){
            return {
                representative: {
                    code: '',
                    user_id: null,
                },
                user: {
                    photo: '/images/default-placeholder.jpg',
                    name: '',
                    lastname: ''
                },
                regions: null,
                brands: null
            }

        },
        computed: {
            'representative.user_id': function () {
                _CreateRepresentative.representative.user_id = _CreateRepresentative.user.id;

            },
            'representative.regions': function () {
                _CreateRepresentative.representative.regions = [];
                _.forEach(_CreateRepresentative.regions, function (region) {
                    _CreateRepresentative.representative.regions.push(region.id);
                });
            },
            'representative.brands': function () {
                _CreateRepresentative.representative.brands = [];
                _.forEach(_CreateRepresentative.brands, function (brand) {
                    var brandArray = { brand_id : brand.id, comission : brand.comission };
                    _CreateRepresentative.representative.brands.push(brandArray);
                });
            },
        },
        ready(){
            window._CreateRepresentative = this;
        },
        methods: {

            submitData: function () {
                this.$http.post('/representatives', _CreateRepresentative.representative)
                        .then(response => {
                            console.log();
                            toastr.success('Representante creado con exito');
                        })
                        .catch(response => {
                            $.each(response.data, function (key, value) {
                                toastr.error(value);
                                $('#' + key).addClass('has-error');
                            });
                        });


            },
            openSelectUser: function () {
                _SelectUser.openWindow();
            },
            openSelectRegion: function () {
                _SelectRegion.openWindow();
            },
            openSelectBrands: function () {
                _SelectBrands.openWindow();
            }

        }
    }
</script>
