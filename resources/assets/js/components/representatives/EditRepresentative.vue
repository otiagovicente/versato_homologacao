<template>

    <div class="content">
        <div class="portlet light">

            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>Crear Representante
                </div>
            </div>
            <div class="portlet-body form">
                <div class="row">
                    <div class="col-md-4">
                        <small>Código</small>
                        <div class="form-group form-line-input" id="code">
                            <input id="code-input" class="form-control input-sm" type="text" v-model="representative.code" disabled/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <small>Usuario</small>
                        <div class="form-group form-line-input" id="user_id">
                            <v-select v-bind:options.sync="users_select" :value.sync="representative.user_id"
                                      placeholder="Elije el usuario" class="form-control"
                                      id="user-input" name="user[]"
                                      search justified required close-on-select></v-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <small>Región</small>
                        <div class="form-group form-line-input" id="region_id">
                            <v-select v-bind:options.sync="regions_select" :value.sync="representative.region_id"
                                      placeholder="Elije la región" class="form-control"
                                      id="region-input" name="region[]"
                                      search justified required close-on-select></v-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <small>Marcas</small>
                        <div class="form-group form-line-input" id="brands">
                            <v-select v-bind:options.sync="brands_select" :value.sync="representative.brands"
                                      placeholder="Elije las marcas" class="form-control"
                                      id="brands-input" name="brands[]"
                                      search justified required close-on-select multiple></v-select>
                        </div>
                    </div>
                </div>
                <div class="row">
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

</template>

<style>
</style>
<script>
    import VueStrap from 'vue-strap'
    export default{
        data(){
            return{
                representative:{
                    code : '',
                    user_id : null
                },
                users_select : [],
                regions_select : [],
                brands_select : []
            }
        },
        props: ['representative_id'],
        components:{
            vSelect: VueStrap.select,
            vOption: VueStrap.option
        },
        ready(){
            window._this = this;
            _this.getUsers();
            _this.getRegions();
            _this.getBrands();
            _this.getRepresentative();
        },
        methods : {

            getUsers: function(){
                this.$http.get('/api/users/selectlist/')
                        .then(response => {
                            _this.users_select = response.json();
                        });
            },
            getRegions: function(){
                this.$http.get('/api/regions/selectlist')
                        .then(response => {
                            _this.regions_select = response.json();
                        });
            },
            getBrands: function(){
                this.$http.get('/api/brands/selectlist')
                        .then(response => {
                            _this.brands_select = response.json();
                        });
            },
            getRepresentative: function () {
                this.$http.get('/api/representatives/'+_this.representative_id)
                        .then(response => {
                            _this.representative = response.json();
                            _this.representative.brands = _this.representative.brands_list;
                        });
            },
            submitData: function(){
                this.$http.put('/representatives/'+_this.representative_id, _this.representative)
                        .then(response => {
                            console.log();
                            toastr.success('Representante gravado con exito');
                        })
                        .catch(response => {
                            $.each(response.data, function (key, value) {
                                toastr.error(value);
                                $('#'+key).addClass('has-error');
                            });
                        });



            }

        }
    }
</script>
