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
                            

                            <!-- local de incluir os campos-->


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
        toastr.options.closeButton = true;
    },
    methods:{
        submitData: function(){ 
            this.$http.post('/users', this.user)
            .then(function (response) {
                toastr.success('Sucesso!', 'Usuário criado con sucesso.');
            }).catch(function (response) {
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