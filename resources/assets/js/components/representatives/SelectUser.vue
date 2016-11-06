<template>
    <div>
        <div class="modal fade" id="select-user" tabindex="-1" role="create-shop" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">


                        <div class="portlet light" >
                            <div class="portlet-title">
                                <div class="caption font-blue">
                                    <i class="fa fa-users font-blue"></i>Users
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="row search-box">
                                    <div class="col-lg-12">
                                        <div class="input-icon input-icon-sm right">
                                            <i class="fa fa-search font-green"></i>
                                            <input id="search-input" class="form-control input-sm" type="text" v-model="search" />
                                        </div>
                                    </div>
                                </div>
                                <div style="height:400px; overflow-y: scroll;">
                                    <div v-for="user in users | filterBy search" class="row">
                                        <div class="col-md-12" v-if="!user.representative">

                                            <div class="user-box"  @click="chooseUser(user)">


                                                <div class="col-md-8" style="padding-top:5px;">
                                                    <h3 class="caption font-blue"> {{user.name+' '+user.lastname}} </h3>
                                                    <br>
                                                    <span class="caption font-blue"> {{user.email}} </span>

                                                </div>
                                                <div class="col-md-4 pull-right">
                                                    <img v-if="user.photo" class="user-photo" v-bind:src="user.photo" />
                                                    <img v-else class="user-photo" v-bind:src="/images/default-placeholder.jpg" />
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .user-photo{
        height:100px;
        right: 10px;
        top: 15px;
    }
    .user-box{
        height: 125px;
        position: relative;
        cursor:pointer;
        border-radius: 15px;
        border: 1px solid #3598DC;
        margin-bottom: 10px;
       /* margin: 10px 10px 5px 10px;*/
    }
    .user-representative{

    }
</style>
<script type="text/babel">
    export default{
        data(){
            return{
                users: [],
                search: ''
            }
        },
        ready(){
            window._SelectUser = this;
            _SelectUser.getUsers();
        },
        methods:{
            getUsers: function(){
                this.$http.get('/api/users')
                        .then(response=>{
                            _SelectUser.users = response.json();
                        })
                        .catch(response=>{
                            toastr.error('No fue possible cargar los usuarios');
                        });
            },
            chooseUser: function(user){

                _CreateRepresentative.user = user;
                _SelectUser.closeWindow();

            },
            /*
             * Funcões de Janela
             */

            openWindow: function () {
                $('#select-user').modal();

            },
            closeWindow: function () {
                $('#select-user').modal('hide');
            },
            reload: function () {

            },
        }
    }
</script>
