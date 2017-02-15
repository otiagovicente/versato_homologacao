<template>
    <div>
        <div class="modal fade" id="select-user" tabindex="-1" role="select-user" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">


                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption font-blue">
                                    <i class="fa fa-users font-blue"></i>Usuarios
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="row search-box">
                                    <div class="col-lg-12">
                                        <div class="input-icon input-icon-sm right">
                                            <i class="fa fa-search font-green"></i>
                                            <input id="search-input" class="form-control input-sm" type="text"
                                                   v-model="search" v-on:keyup.enter="searchUsers()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                </div>
                                <div style="height:400px; overflow-y: scroll;">
                                    <div v-for="user in users | filterBy search" class="row">
                                        <div class="col-md-12" v-if="!user.representative">

                                            <div class="user-box" @click="selectUser(user.id)">

                                                <div class="col-md-3">
                                                    <img v-if="user.photo" class="user-photo" v-bind:src="user.photo"/>
                                                    <img v-else class="user-photo"
                                                         v-bind:src="/images/default-placeholder.jpg"/>
                                                </div>
                                                <div class="col-md-8" style="padding-top:5px;">
                                                    <h3 class="caption"> {{user.name+' '+user.lastname}} </h3>
                                                    <br>
                                                    <span class="caption"> {{user.email}} </span>

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
<style scoped>
    .user-box{
        height: 125px;
        position: relative;
        cursor:pointer;
        margin-bottom: 10px;
        padding : 5px;
        color: #3598DC;
       /* margin: 10px 10px 5px 10px;*/
    }
    .user-box:hover{
        color: #FFFFFF;
        background-color: #3598DC;
    }
    .user-box .user-photo{
        height:100px;
        right: 10px;
        top: 15px;
    }

    .user-representative{

    }

</style>
<script type="text/babel">
    export default{
        data(){
            return {
                users: [],
                search: ''
            }
        },
        props: {
            user_id: {
                twoWay: true
            }
        },
        events: {
            'open-user-select-window': function () {
                this.openWindow();
            }
        },
        watch: {},
        ready(){
        },
        methods: {
            searchUsers(){
                this.$http.get('/api/users/search?search=' + this.search)
                        .then(response => {
                            this.users = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fue possible cargar los usuarios');
                        }).bind(this);
            },
            selectUser(user_id){
                this.user_id = user_id;
                this.closeWindow();
            },

            /*
             * Funcões de Janela
             */

            openWindow: function () {
                // $('#select-user').on("hide.bs.modal", function (e) {
                //     this.reload();
                // }).bind(this);
                $('#select-user').modal();

            },
            closeWindow: function () {
                $('#select-user').modal('hide');
            },
            reload: function () {
                this.users = {};
                this.search = '';
            },
        }
    }
</script>
