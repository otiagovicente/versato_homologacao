<template>
    <!-- BEGIN PROFILE SIDEBAR -->
    <div class="profile-sidebar">
        <!-- PORTLET MAIN -->
        <div class="portlet light profile-sidebar-portlet ">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <img :src="user.photo" class="img-responsive" alt=""> </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">{{ user.name }} {{ user.lastname }}</div>
                <div class="profile-usertitle-job">{{ user.occupation }} </div>
            </div>
            <!-- END SIDEBAR USER TITLE -->
            <!-- SIDEBAR BUTTONS -->
            <div class="profile-userbuttons">
                <a href="/users"><button type="button" class="btn btn-circle red btn-sm">Cancelar</button></a>
            </div>
            <!-- END SIDEBAR BUTTONS -->
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav">
                    <li>
                        <a href="/profile">
                            <i class="icon-home"></i> Perfil </a>
                    </li>
                    <li class="active">
                        <a href="/users/{{ user.name }}/edit">
                            <i class="icon-settings"></i> Cambiar Informaciones </a>
                    </li>
                    <li>
                        <a href="/help">
                            <i class="icon-info"></i> Help </a>
                    </li>
                </ul>
            </div>
            <!-- END MENU -->
        </div>
        <!-- END PORTLET MAIN -->
    </div>
    <!-- END BEGIN PROFILE SIDEBAR -->
    
    <!-- BEGIN PROFILE CONTENT -->
    <div class="profile-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">Conta de usuário</span>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1_1" data-toggle="tab">Informaciones Personales</a>
                            </li>
                            <li>
                                <a href="#tab_1_2" data-toggle="tab">Cambiar la Foto</a>
                            </li>
                            <li>
                                <a href="#tab_1_3" data-toggle="tab">Social Media</a>
                            </li>
                            <li>
                                <a href="#tab_1_4" data-toggle="tab">Cambiar Contraseña</a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <!-- PERSONAL INFO TAB -->
                            <div class="tab-pane active" id="tab_1_1">
                                <form role="form" action="#">
                                    <div class="form-group" id="email-input" >
                                        <label class="control-label">Email</label>
                                        <input type="text" placeholder="email@ejemplo.com" class="form-control" v-model="user.email" /> </div>
                                    <div class="form-group" id="name-input" >
                                        <label  class="control-label">Nombre</label>
                                        <input type="text" placeholder="Juan" class="form-control" v-model="user.name" /> </div>
                                    <div class="form-group" id="lastname-input" >
                                        <label class="control-label">Apellido</label>
                                        <input type="text" placeholder="Reyes" class="form-control" v-model="user.lastname" /> </div>
                                    <div class="form-group" id="telefono-input" >
                                        <label class="control-label">Telefono</label>
                                        <input type="text" placeholder="+54 9916 2573" v-model="user.mobile" class="form-control" /> </div>
                                    <div class="form-group">
                                        <label class="control-label" id="occupation-input" >Ocupación</label>
                                        <input type="text" placeholder="Web Developer" class="form-control" v-model="user.occupation"/> </div>
                                    <div class="form-group">
                                        <label class="control-label"  id="about-input" >Sobre</label>
                                        <textarea class="form-control" rows="3" placeholder="Una breve descripcion de su persona." v-model="user.about"></textarea>
                                    </div>
                                    <hr>
                                    <div class="margin-top-10">
                                        <a href="javascript:;" v-on:click="submitData" class="btn green"> Guardar </a>
                                        <a href="/users" class="btn default"> Cancel </a>
                                    </div>
                                </form>
                            </div>
                            <!-- END PERSONAL INFO TAB -->
                            <!-- CHANGE AVATAR TAB -->
                            <div class="tab-pane" id="tab_1_2">
                                <p> Cambia tu foto! ;) </p>
                                <form id="image-form" action="#" role="form">
                                    <div class="form-group">
                                        <div class="thumbnail" style="width: 100%;">
                                            <img :src="user.photo" alt="" style="width:auto;"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="photo" class="dropzone" style="min-height:150px; border: 2px dashed #eaeaea; background: white; padding: 20px 20px; text-align:center;">

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="margin-top-10">
                                        <a href="javascript:;" v-on:click="submitData" class="btn green"> Guardar </a>
                                        <a href="/users" class="btn default"> Cancel </a>
                                    </div>
                                </form>

                            </div>
                            <!-- END CHANGE AVATAR TAB -->
                            <!-- CHANGE PASSWORD TAB -->
                            <div class="tab-pane" id="tab_1_3">
                                <form>

                                    <div class="input-group input-icon">
                                        <span class="input-group-addon">
                                            <i class="fa fa-facebook tooltips" data-original-title="Facebook User." data-container="body"></i> facebook.com/
                                        </span>
                                        <input id="facebook" class="form-control" type="text" v-model="user.facebook" >

                                    </div>
                                    <br>
                                    <div class="input-group input-icon">
                                        <span class="input-group-addon">
                                            <i class="fa fa-twitter tooltips" data-original-title="Twitter User." data-container="body"></i> twitter.com/
                                        </span>

                                        <input id="twitter" class="form-control" type="text" v-model="user.twitter" >

                                    </div>
                                    <br>
                                    <div class="input-group input-icon">
                                        <span class="input-group-addon">
                                            <i class="fa fa-instagram tooltips" data-original-title="Instagram User." data-container="body"></i> instagram.com/
                                        </span>

                                        <input id="instagram" class="form-control" type="text" v-model="user.instagram" >
                                    </div>

                                    <hr>
                                    <div class="margin-top-10">
                                        <a href="javascript:;" v-on:click="submitData" class="btn green"> Guardar </a>
                                        <a href="/users" class="btn default"> Cancel </a>
                                    </div>
                                </form>
                            </div>
                            <!-- END CHANGE PASSWORD TAB -->
                            <div class="tab-pane" id="tab_1_4">
                                <form id="redefine-password-form">
                                    <div id="password-current" class="form-group">
                                        <label class="control-label">Contraseña Actual</label>
                                        <input  v-model="password.current" type="password" class="form-control" /> </div>
                                    <div id="password-new" class="form-group">
                                        <label class="control-label">Nueva Contraseña</label>
                                        <input  v-model="password.password" v-on:keyup="comparePasswords" type="password" class="form-control" />

                                    </div>
                                    <div id="password-retype" class="form-group" data-container="body" animation="true" data-placement="left" data-toggle="popover" data-trigger="manual" data-content="Repitas tu contraseña">
                                        <label class="control-label">Repitas Nueva Contraseña</label>
                                        <input  v-model="password.password_confirmation" v-on:keyup="comparePasswords" type="password" class="form-control" />

                                    </div>
                                    <div class="margin-top-10">
                                        <a href="javascript:;" v-on:click="changePassword" class="btn green"> Change Password </a>
                                        <a href="javascript:;" class="btn default"> Cancel </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import VueStrap from 'vue-strap'
import algoliasearch from 'algoliasearch'
import Dropzone from 'dropzone'
import toastr from 'toastr'
import bootbox from 'bootbox'

export default{
   props: ['logged_user'],
    components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
    },
    data(){
        return{
            actionUrl : '/users/' + this.logged_user.id,
            user: {
                id: this.logged_user.id,
                _method: 'PATCH',
                name: this.logged_user.name,
                lastname: this.logged_user.lastname,
                mobile: this.logged_user.mobile,
                occupation: this.logged_user.occupation,
                about: this.logged_user.about,
                facebook: this.logged_user.facebook,
                twitter: this.logged_user.twitter,
                instagram: this.logged_user.instagram,
                email: this.logged_user.email,
                role: this.logged_user.role,
                photo: this.logged_user.photo,
            },
            password: {
                email:this.logged_user.email,
                current:'',
                password: '',
                password_confirmation: ''
            }
        }
    },
    
    ready(){
        console.log(this.user);
        toastr.options.closeButton = true;
        this.configureDropbox(this.user);
    },

    methods:{
        
        submitData: function(){ 
            this.$http.put(this.actionUrl, this.user)
            .then(function (response) {
                toastr.success('Sucesso!', 'Perfil actualizado con sucesso.');
            }).catch(function (response) {
                $.each(response.data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#'+key).addClass('has-error');
                });
            });

        }, //end submit data

        changePassword: function(){
            this.$http.post('/users/changepassword', this.data.password).then(function (response){
                toastr.success('Sucesso!','Contraseña cambiada con sucesso!');
            }).catch( function (response){
                var errors = response.json();
                $.each(errors, function (key, value) {
                    toastr.error('Atención', value);
                });
            });
        },
        comparePasswords: function(){
            if(this.data.password.password != this.data.password.password_confirmation){
                $('#password-new').addClass('has-error');
                $('#password-retype').addClass('has-error');
                $('#password-retype').popover('show');
            }else{
                $('#password-new').removeClass('has-error');
                $('#password-retype').removeClass('has-error');
                $('#password-retype').popover('hide');
            }
        },

        configureDropbox: function(callback){
            Dropzone.autoDiscover = false;
            var dropzoneOptions = {
                maxFiles: 1,
                maxFileSize: 8,
                paramName: 'photo',
                acceptedFiles: '.jpeg, .jpg, .png',
                autoProcessQueue: false,
                dictDefaultMessage: 'Elija el arquivo',
                url: "/users/photo",
                headers: {
                    'X-CSRF-TOKEN': Laravel.csrfToken
                },

                success: function(file, response){
                    Vue.set(callback, 'photo', response);
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

                bootbox.confirm("Seguro que quieres hacer el upload de una imágene del usuario?", function(result) {
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
    }, //end methods
    filters: {

    }
}
</script>