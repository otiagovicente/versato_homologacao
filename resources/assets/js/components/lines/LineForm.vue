
<template>
    <div class="content">
        <div class="portlet light">

            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>
                    Criar Linha
                </div>
            </div>
            
            <div class="portlet-body form">
                <form id="form-product">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-line-input" id="code-input">
                                <small>Código</small>
                                <input  
                                    class="typeahead form-control input-sm" 
                                    v-model="line.code"
                                    type="number"
                                >
                            </div>
                            
                            <div id="message-code" v-show="line.code_error" class="alert alert-danger" data-error="code" role="alert" style="margin-top:10px;">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Erro:</span>
                                    Você deve inserir um código
                            </div>
                            
                            <div class="form-group form-line-input " id="description-input">
                                <small>Descrição</small>
                                <input 
                                    class="typeahead form-control input-sm" 
                                    type="text"
                                    v-model="line.description"
                                >
                            </div>

                            <div id="message-description" v-show="line.description_error" class="alert alert-danger" data-error="description" role="alert" style="margin-top:10px;">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Erro:</span>
                                Você deve inserir uma descrição
                            </div>

                        </div>
                    </div>
                    
                    <div class="row">
                        <hr>
                        
                        <div class="container-fluid">
                            
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <button 
                                        type="button" 
                                        @click="submitData()" 
                                        class="btn blue btn-block"
                                    >
                                        Salvar
                                    </button>
                                </div>
                            </div>
                            
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <a href="/lines/"><button type="button" class="btn grey btn-block">Cancel</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
            line: {
                code: '',
                description: '',
                code_error: '',
                description_error:'',
            },
        }
    },
    ready(){
        this.line.code_error = false;
        this.line.description_error = false;
        toastr.options.closeButton = true;
    },
    methods:{
        submitData: function(){ 
            if(this.fieldsValidate()) this.saveLine(this.line);
        },
        
        saveLine: function(line){
            this.$http.post('/lines/store', {
                code:        line.code, 
                description: line.description, 
                brand_id:    line.brand_id
            }).then((response) => {
                toastr.success('Sucesso!','Linha incluída com sucesso');
                // this.$set('someData', response.body);
                }, (response) => {
                   var msg = '';
                  
                    switch (response.status){
                        case 422:
                            msg = 'Já existe uma linha de mesmo código.';
                            break;
                        default:
                            msg = responde.body;
                            break;
                    }
                    
                    toastr.warning("Atenção!", msg);
                    console.log(response);
                    // error callback
                }
            );
        },
        
        fieldsValidate: function(){
            this.line.code        ? this.line.code_error        = false: this.line.code_error        = true;
            this.line.description ? this.line.description_error = false: this.line.description_error = true;

            if(this.line.code && this.line.description){
                return true;
            }
            return false;
        }
    },
    filters: {

    }
}
</script>