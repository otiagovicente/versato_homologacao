
<template>
    <div id="code-input" class="form-group" >
    <label class="col-md-3 control-label">Nome</label>
      <div class="col-md-7" id="code">                
        <input type="text" 
          name="code"
          class="form-control" 
          placeholder="Nome"
          v-model="line.code"
        >
      </div>
  </div>
  <div id="code-input" class="form-group" >
    <label class="col-md-3 control-label">Descrição</label>
      <div class="col-md-7" id="description">                
        <input type="text" 
          name="code"
          class="form-control" 
          placeholder="Descrição"
          v-model="line.description"
        >
      </div>
  </div>
  
  <div class="row">
    <br/>
    <hr>
    
    <div class="container-fluid" >
      <div class="col-md-3 pull-right">
        <div class="form-group">
          <button 
            v-show="canedit"
            type="button" 
            @click="submitData()" 
            class="btn blue btn-block"
          >
            Salvar
          </button>
        </div>
      </div>  
      
      <div class="col-md-3 pull-right" >
        <div class="form-group">
          <a href="/lines/">
              <button type="button" class="btn grey btn-block" v-show="canedit">Cancel</button>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import toastr from 'toastr'

export default{
    
    
    components: {
           
    },
    props: ['pline'],
    
    data(){
        return{
            canedit:true,
            line: {
                id: '',
                code: '',
                description: '',
            },
        }
    },
    
    ready(){
        toastr.options.closeButton = true;
        if(this.pline) this.loadLine();
    },
    
    methods:{
        submitData: function(){ 
            if(!this.line.id)
                this.saveLine(this.line);
            else
                this.updateLine(this.line);
        },
        
        saveLine: function(line){
            this.$http.post('/lines/', this.line)
            .then((response) => {
                toastr.success('Sucesso!','Linha incluída com sucesso');
            }, 
            (response) => {
                this.showErrors(response.data);
            });
        },

        updateLine: function(line){
            this.$http.put('/lines/'+this.line.id, this.line)
            .then((response) => {
                toastr.success('Sucesso!','Linha atualizada com sucesso');
                }, (response) => {
                    this.showErrors(response.data);
                }
            );
        },

        loadLine: function(){
            this.line.id = this.pline.id;
            this.line.code = this.pline.code;
            this.line.description = this.pline.description;
        },
        
        showErrors: function(data){
          $.each(data, function (key, value) {
            toastr.warning('Atención', value);
            $('#'+key).addClass('has-error');
          }); 
        },
    },
    filters: {

    }
}
</script>