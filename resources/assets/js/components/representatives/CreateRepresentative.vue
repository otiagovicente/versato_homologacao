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

                                <div class="col-md-12">
                                    <small>Nombre</small>
                                    <h4 @click="openSelectUser()" class="font-blue" style="cursor:pointer;">{{user.name+' '+user.lastname}}</h4>
                                </div>
                                <div class="col-md-12">
                                    <small>Región</small>

                                    <div class="form-group form-line-input" id="region_id">
                                        <v-select v-bind:options.sync="regions_select" :value.sync="representative.region_id"
                                                  placeholder="Elije la región" class="form-control"
                                                  id="region-input" name="region[]"
                                                  search justified required close-on-select></v-select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <small>Marcas</small>
                                    <div class="form-group form-line-input" id="brands">
                                        <v-select v-bind:options.sync="brands_select" :value.sync="representative.brands"
                                                  placeholder="Elije las marcas" class="form-control"
                                                  id="brands-input" name="brands[]"
                                                  search justified required close-on-select multiple></v-select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <small>Comision</small>
                                    <div class="form-group form-line-input" id="representative_comision">
                                        <div class="form-group" id="name-input" >
                                            <input
                                                    type="number"
                                                    step="0.10"
                                                    placeholder="Comision"
                                                    class="form-control"
                                                    v-model="representative.representative_comision" />
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
</template>

<style>
    .user-photo{
        width: 100%;
        height: auto;
        cursor:pointer;
    }
</style>
<script type="text/babel">
    import VueStrap from 'vue-strap'
    export default{
        data(){
            return{
                representative:{
                    code : '',
                    user_id : null,
                    representative_comision:'0.00'
                },
                user :{
                    photo: '/images/default-placeholder.jpg',
                    name: 'eligir',
                    lastname: 'usuario'
                },
                users_select : [],
                regions_select : [],
                brands_select :[]
            }
        },
        components:{
            vSelect: VueStrap.select,
            vOption: VueStrap.option
        },
        ready(){
            window._CreateRepresentative = this;
            _CreateRepresentative.getRegions();
            _CreateRepresentative.getBrands();
        },
        methods : {


            getRegions: function(){
                this.$http.get('/api/regions/selectlist')
                        .then(response => {
                            _CreateRepresentative.regions_select = response.json();
                        });
            },
            getBrands: function(){
                this.$http.get('/api/brands/selectlist')
                        .then(response => {
                            _CreateRepresentative.brands_select = response.json();
                        });
            },
            submitData: function(){
                this.$http.post('/representatives', _CreateRepresentative.representative)
                    .then(response => {
                        console.log();
                        toastr.success('Representante creado con exito');
                    })
                    .catch(response => {
                        $.each(response.data, function (key, value) {
                            toastr.error(value);
                            $('#'+key).addClass('has-error');
                        });
                    });



            },
            openSelectUser: function(){
                _SelectUser.openWindow();
            }

        }
    }
</script>
