<template>  
    <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">    
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <span class="caption-subject font-blue bold uppercase"> <i class="fa fa-user"></i> Conta de usuário</span>
                        </div>
                    </div>
                    
                    <div class="portlet-body">
                        <form class="form-horizontal">    
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Nome</label>
                                <div class="col-md-7" id="code">                
                                    <input type="text" 
                                    name="code"
                                    class="form-control" 
                                    placeholder="Nombre"
                                    v-model="user.name"
                                    >
                                </div>
                            </div>   
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Apellido</label>
                                <div class="col-md-7" id="lastname">                
                                    <input type="text" 
                                    name="lastname"
                                    class="form-control" 
                                    placeholder="Apellido"
                                    v-model="user.lastname"
                                    >
                                </div>
                            </div>   
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">E-mail</label>
                                <div class="col-md-7" id="email">                
                                    <input type="text" 
                                    name="email"
                                    class="form-control" 
                                    placeholder="E-mail"
                                    v-model="user.email"
                                    >
                                </div>
                            </div> 
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Contraseña</label>
                                <div class="col-md-7" id="password">                
                                    <input type="password"
                                    name="contrasena"
                                    class="form-control" 
                                    placeholder="Contraseña"
                                    v-model="user.password"
                                    >
                                </div>
                            </div>  
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Confirmar la Contraseña</label>
                                <div class="col-md-7" id="password_confirmation">                
                                    <input type="password"
                                    name="confirmarcontrasena"
                                    class="form-control" 
                                    placeholder="Confirmar la Contraseña"
                                    v-model="user.password_confirmation"
                                    >
                                </div>
                            </div> 
                            <div id="code-input" class="form-group" >
                                <label class="col-md-3 control-label">Tipo de Usuario</label>
                                <div class="col-md-7" id="role_id">                
                                    <select id="role-id-input" name="role_id" class="form-control" v-model="user.role_id">
                                        <option value="1">Super Admin</option>
                                        <option value="2">Admin</option>
                                        <option value="3">Gestor</option>
                                        <option value="4" selected>Editor</option>
                                        <option value="5">Representante</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="button" class="btn btn-primary pull-right" @click="submitData()">
                                        <i class="fa fa-btn fa-user"></i>
                                        Crear
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import VueStrap from 'vue-strap'
import toastr from 'toastr'

export default{
    components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
    },
    data(){
        return{
            user: {
                name: '',
                lastname: '',
                email: '',
                role_id: '',
                password:'',
                password_confirmation: ''
            },
            password: {
                password: '',
                password_confirmation: ''
            },
        }
    },
    ready(){
        console.log(this.user);
        toastr.options.closeButton = true;
    },
    methods:{
        submitData: function(){             
            this.$http.post('/users', this.user)
            .then(function (response) {
                toastr.success('Sucesso!', 'Usuário criado con sucesso.');
            }).catch(function (response) {
                console.log(response);
                $.each(response.data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#'+key).addClass('has-error');
                });
            });
        }//end submit data
    }, //end methods
    filters: {

    }
}
</script>