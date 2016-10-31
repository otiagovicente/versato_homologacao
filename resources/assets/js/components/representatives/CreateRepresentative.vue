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

                                    <h4 @click="openSelectRegion()" class="font-blue" style="cursor:pointer;">{{user.name+' '+user.lastname}}</h4>


                                </div>
                                <div class="col-md-12">
                                    <small>Marcas</small>
                                    <h4 @click="openSelectBrands()" class="font-blue" style="cursor:pointer;">{{user.name+' '+user.lastname}}</h4>

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
        height: 200px;
        cursor:pointer;
        right : 50px;
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
                regions:{},
                brands:{}
            }
        },
        components:{
            vSelect: VueStrap.select,
            vOption: VueStrap.option
        },
        ready(){
            window._CreateRepresentative = this;
        },
        methods : {

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
