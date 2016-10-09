<template>
    bla bla bla
</template>

<script>
    //import {load, Map, Polygon} from 'vue-google-maps'
    import toastr from 'toastr'
    
    //load(Maps.maps_key, Maps.maps_version)

export default{
    props:[
      'porder'
    ],
    components: {
            
    },
    
    data(){
        return{
            order: {
                id:'',
                code: '',
                description: '',
                geo: ''

            },
        }
    },
    ready(){
        toastr.options.closeButton = true;
        if(this.pmacroregion) this.loadMacroregion(); 
    },
    methods:{
        submitData: function(){
            //if(!this.macroregion.id)
            //  this.insertData();
            //else
            //  this.updateData();
        },
        
        insertData: function(){
          this.macroregion.geo = JSON.stringify(this.loadpolygon);
            this.$http.post('/macroregions', this.macroregion)
            .then((response) => {
              toastr.success('Sucesso!','Macro Região incluída com sucesso');
            }, (response) => { 
              this.showErrors(response.data); 
            }); 
        },
        
        updateData: function(){
          this.macroregion.geo = JSON.stringify(this.loadpolygon);
          this.$http.put('/macroregions/'+this.macroregion.id, this.macroregion)
          .then((response) => {
            toastr.success('Sucesso!','Macro Região atualizada com sucesso');
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