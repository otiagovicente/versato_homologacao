<div id="app">
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
                <div class="profile-usertitle-name">@{{ user.name }} @{{ user.lastname }}</div>
                <div class="profile-usertitle-job">@{{ user.occupation }} </div>
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
                        <a href="/users/{{$user->id}}/edit">
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
                                </form>

                            </div>
                            <!-- END CHANGE AVATAR TAB -->
                            <!-- CHANGE PASSWORD TAB -->
                            <div class="tab-pane" id="tab_1_3">
                                <form>
                                    <div class="form-group">
                                        <label class="control-label"><i class="fa fa-facebook font-blue"></i> Facebook</label>
                                        <input type="text" class="form-control" v-model="user.facebook" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><i class="fa fa-twitter font-blue"></i> Twitter</label>
                                        <input type="text" class="form-control" v-model="user.twitter" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><i class="fa fa-instagram font-blue"></i> Instagram</label>
                                        <input type="text" class="form-control" v-model="user.instagram" />
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
    <pre>
        @{{ $data | json }}
    </pre>
</div>


<!-- END PROFILE CONTENT -->


@section('metatags')
    <meta id="token" name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('styles')
    <link href="/dashboard/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css">

    <style>

    </style>
@endsection

@section('scripts')
    <script>
        var data = {
            actionUrl : '/users/{{$user->id}}',
            user: {
                id: {{$user->id}},
                _method: 'PATCH',
                name: '{{$user->name}}',
                lastname: '{{$user->lastname}}',
                mobile: '{{$user->mobile}}',
                occupation: '{!!$user->occupation!!}',
                about: '{{ $user->about }}',
                facebook: '{{$user->facebook}}',
                twitter: '{{$user->twitter}}',
                instagram: '{{$user->instagram}}',
                email: '{{$user->email}}',
                role: '{{$user->role}}',
                photo: '{{$user->photo}}'

            },
            password: {
                email: '{{$user->email}}',
                current:'',
                password: '',
                password_confirmation: ''
            }
        };
    </script>

    <script src="/dashboard/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/typeahead.js/0.11.1/typeahead.jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/dashboard/global/scripts/moment.min.js"></script>
    <script type="text/javascript">Dropzone.autoDiscover = false;</script>


    <script>
        //ProductDropzone - Begin
        var AvatarDropzone = function() {
            var dropzoneOptions = {
                autoDiscover: false,
                maxFiles: 1,
                maxFileSize: 5,
                paramName: 'photo',
                acceptedFiles: '.jpeg, .jpg, .png',
                autoProcessQueue: false,
                dictDefaultMessage: 'Elija la Foto',
                url: "/users/photo",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function (file, response) {
                    data.user.photo = response;
                    this.removeAllFiles(true);
                },

                init: function () {
                    this.on("maxfilesexceeded", function (file) {
                        toastr.warning('Número de arquivos excedido!', 'Você só pode inserir um arquivo');
                    });
                    this.on("error", function (file, errorMessage) {
                        console.log(errorMessage);
                        toastr.error('Erro!', "Confira se o arquivo possui as características necessárias!");
                        this.removeAllFiles(true);
                    });
                }
            };

            var photoDropzone = new Dropzone("div#photo", dropzoneOptions);
            photoDropzone.accept = function(file, done) {
                bootbox.confirm("Quieres cambiar tu foto?", function(result) {
                    if(result){
                        done();
                        photoDropzone.processQueue();
                    }else{
                        photoDropzone.removeAllFiles(true);
                        done(result);
                    }
                });
            };
        };

        var vm = new Vue({
            el: '#app',
            data: data,
            ready: function(){
                Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');
                AvatarDropzone();
                $('[data-toggle="popover"]').popover();
            },
            methods: {
                submitData: function(){
                    this.$http.put(data.actionUrl, data.user).then( function (response){
                        toastr.success('Sucesso!','Produto atualizado com sucesso');

                        var userResponse = response.json();
                        window.location.href ='/users/'+userResponse.id;
                        console.log(userResponse.id);
                    
                    }).catch( function(response){
                        var errors = response.json();
                        $.each(errors, function (key, value) {
                            var input = '#' + key + '-input';
                            $(input).addClass('has-error');
                            toastr.error('Atenção!', value);
                        });
                    });
                },
                cancelUpload: function(){},

                changePassword: function(){
                    this.$http.post('/users/changepassword', data.password).then(function (response){
                        toastr.success('Sucesso!','Contraseña cambiada con sucesso!');
                    }).catch( function (response){
                        var errors = response.json();
                        $.each(errors, function (key, value) {
                            toastr.error('Atención', value);
                        });
                    });
                },

                comparePasswords: function(){
                    if(data.password.password != data.password.password_confirmation){
                        $('#password-new').addClass('has-error');
                        $('#password-retype').addClass('has-error');
                        $('#password-retype').popover('show');
                    }else{
                        $('#password-new').removeClass('has-error');
                        $('#password-retype').removeClass('has-error');
                        $('#password-retype').popover('hide');
                    }
                }
            }
        });
    </script>
@endsection