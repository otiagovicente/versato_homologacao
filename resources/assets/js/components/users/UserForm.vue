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
                            
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-group form-line-input" id="name">
                                        <small>Name</small>
                                        <input 
                                            name="name"
                                            type="text"
                                            v-model="user.name"
                                            class="form-control input-sm"
                                            id="cost-input"
                                        >
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-group form-line-input" id="lastname">
                                        <small>Sobrenome</small>
                                        <input 
                                            name="lastname"
                                            type="text"
                                            v-model="user.lastname"
                                            class="form-control input-sm"
                                            id="lastname-input"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-group form-line-input" id="email">
                                        <small>E-Mail</small>
                                        <input 
                                            name="email"
                                            type="text"
                                            v-model="user.email"
                                            class="form-control input-sm"
                                            id="email-input"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-group form-line-input" id="password">
                                        <small>Senha</small>
                                        <input 
                                            name="password"
                                            type="password"
                                            v-model="user.password"
                                            class="form-control input-sm"
                                            id="password-input"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-group form-line-input" id="password_confirmation">
                                        <small>Confirmar Senha</small>
                                        <input 
                                            name="password_confirmation"
                                            type="password"
                                            v-model="user.password_confirmation"
                                            class="form-control input-sm"
                                            id="password_confirmation-input"
                                        >
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-group form-line-input" id="role">
                                        <small>Tipo de usuário</small>
                                        <select id="role-input" name="role" class="form-control" v-model="user.role">
                                            <option value="1">Super Admin</option>
                                            <option value="2">Admin</option>
                                            <option value="3">Gestor</option>
                                            <option value="4" selected>Editor</option>
                                            <option value="5">Representante</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button
                                        type="button"
                                        class="btn btn-primary pull-right"
                                        @click="submitData()"
                                    >
                                        <i class="fa fa-btn fa-user"></i> 
                                        Criar
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
                _method: 'POST',
                name: '',
                lastname: '',
                email: '',
                role: '',
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
            console.log(this.user);
            
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