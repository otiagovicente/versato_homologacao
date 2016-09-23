
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
    props: ['line_id'],
    
    data(){
        return{
            line: {
                id: '',
                code: '',
                description: '',
                code_error: '',
                description_error:'',
            },
        }
    },
    ready(){
        console.log(this.line);
        this.line.code_error = false;
        this.line.description_error = false;
        toastr.options.closeButton = true;

        if(this.line_id) this.loadLine();
    },
    methods:{
        submitData: function(){ 
            if(this.fieldsValidate()){
                if(!this.line.id)
                    this.saveLine(this.line);
                else
                    this.updateLine(this.line);
            } 
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

        updateLine: function(line){
            this.$http.post('/lines/update', {
                id:          line.id,
                code:        line.code, 
                description: line.description, 
                brand_id:    line.brand_id
            }).then((response) => {
                toastr.success('Sucesso!','Linha atualizada com sucesso');
                }, (response) => {
                    console.log(response);
                }
            );
        },

        loadLine: function(){
            this.$http.post('/lines/line/3', {
                code:this.line_code, 
            }).then((response) => {
                var line = JSON.parse(response.body);
                this.line.id          = line.id;
                this.line.code        = line.code;
                this.line.description = line.description;
                
                }, (response) => {
                    console.log(response);
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