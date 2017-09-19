<style>
    
</style>

<template>
    <div class="portlet light">
        <div class="portlet-title">
        <div class="caption font-blue">
            <i class="fa fa-plus font-blue"></i>Crear Color
        </div>
    </div>
    <div class="portlet-body form">
        <form id="form-color" class="form-horizontal">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div id="code-input" class="form-group form-line-input">
                            <label class="col-md-3 control-label">Código</label>
                            <div class="col-md-5">
                                <input type="text" name="code" v-model="color.code" class="form-control" placeholder="Código da Cor">
                            </div>
                        </div>
        				<div id="description-input" class="form-group form-line-input">
                            <label class="col-md-3 control-label">Descrição</label>
                            <div class="col-md-5">
                              	<input type="text" name="description" v-model="color.description" class="form-control" placeholder="Nome da Cor">
                            </div>
                        </div>	
                    </div>
                    <div class="col-md-6 pull-right">
                        <div id="color-input" class="form-group form-line-input">
                            <label class="col-md-2 control-label">Cor</label>
                            <div class="col-md-6">
                                <input type="text" name="color" v-model="color.color" id="color-selector" class="form-control demo" data-control="hue" > 
                            </div>
                        </div>
                        <div id="pantone-input" class="form-group form-line-input">
                            <label class="col-md-2 control-label">Pantone</label>
                            <div class="col-md-6">
                                <input type="text" name="pantone" v-model="color.pantone" id="pantone" class="form-control " data-control="hue"> 
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="pull-right col-md-3">
                        <a href="/colors/">
                            <button type="button" class="btn grey-salsa btn-outline">Cancelar</button>
                        </a>
                        <button @click="submitData" type="button" class="btn blue">Salvar</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>

</div>
</template>

<script>
    import toastr from 'toastr'

export default{
    props:[
      'pcolor',
      'isedit'
    ],
    events: {
     
    },
    data(){
        return{
            color: {
                id:'',
                code: '',
                color: '',
                description: '',
                pantone:'',
            },
        }
    },
    ready(){
        toastr.options.closeButton = true;
        if(this.pcolor) this.loadColor();
    },
    methods:{
      loadColor: function(){
        this.color = this.pcolor;
      },
      
      submitData: function(){
          if(!this.color.id) this.insertData();
          else this.updateData();
      },
        
      insertData: function(){
        this.$http.post('/colors', this.color)
        .then((response) => {
          toastr.success('Sucesso!','Color incluída com sucesso');
        }, (response) => { 
          this.showErrors(response.data); 
        }); 
      },
        
      updateData: function(){
        this.$http.put('/colors/'+this.color.id, this.color)
        .then((response) => {
          toastr.success('Sucesso!','Color atualizada com sucesso');
        }, (response) => { 
          this.showErrors(response.data); 
        }); 
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