<style>
    map {
        width:100%;
        height: 600px;
        display: block;
    }
</style>

<template>
  
  <div id="code-input" class="form-group" >
    <label class="col-md-3 control-label">Nome</label>
      <div class="col-md-7" id="code">                
        
        <v-select 
          v-bind:options.sync="lstMacroRegiones"
          :value.sync="region.macroregiones"  
          placeholder="Elije las macro regiones" 
          multiple class="form-control" 
          id="macroregiones-input" 
          name="grids[]" 
          search justified required close-on-select
        ></v-select>
      </div>
  </div>
  <!--
  <div id="code-input" class="form-group" >
    <label class="col-md-3 control-label">Descrição</label>
      <div class="col-md-7" id="description">                
        <input type="text" 
          name="code"
          class="form-control" 
          placeholder="Descrição"
          v-model="macroregion.description"
        >
      </div>
  </div>
  -->
  <div id="code-input" class="form-group">
    <label class="col-md-3 control-label">Regiones</label>
      <div class="col-md-12" style="padding:15px">                
        <map
          :center.sync="center"
          :zoom.sync="zoom"
          :map-type-id.sync="mapType"
          :options="{styles: mapStyles, scrollwheel: scrollwheel}"
          :bounds.sync="mapBounds"
        >
          <polygon 
            :paths.sync="loadpolygon" 
            :editable="false" 
            :options="{geodesic:true, strokeColor:'#FF0000', fillColor:'#000000', draggable: false}"
          ></polygon>
        </map>
      </div>
  </div>
  
  <div class="row">
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
          <a href="/regions/">
              <button type="button" class="btn grey btn-block" v-show="canedit">Cancel</button>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import {load, Marker, Map, Cluster, InfoWindow, Polyline, Rectangle, Circle, Polygon, PlaceInput} from 'vue-google-maps'
    import toastr from 'toastr'
    
    load('AIzaSyBvsUfqhKn021ZZOZtRGyuRIIKE96vfQ8U', '3.21')

export default{
    props:[
      'pregions',
      'isedit'
    ],
    components: {
            Map,
            Marker,
            Cluster,
            InfoWindow,
            Polygon,
            Polyline,
            Rectangle,
            Circle,
            PlaceInput
    },
    data(){
        return{
            center: { lat: -34.612829, lng: -58.434704 },
            zoom: 5,
            mapType: 'roadmap',
            mapStyle: 'normal',
            scrollwheel: true,
            mapBounds: {},
            pgvisible: true,
            canedit:true,
            lstMacroRegiones: new Array(),
            macroregiones:[],
            polygons:[],
            loadpolygon:[[
                  {lat: -34.81375546971009, lng: -63.63490624999997},
                  {lat: -34.83179331290262, lng: -61.23988671874997},
                  {lat: -36.4565891377291, lng: -61.26185937499997},
                  {lat: -36.42123554842336, lng: -63.61293359374997},
                ]],
            
            regions: {
                id:'',
                code: '',
                description: '',
                geo: '',
                masterregion_id:''
            },
        }
    },
    ready(){
        toastr.options.closeButton = true;
        this.teste();
        //if(this.pmacroregion) this.loadRegions(); 
    },
    methods:{
        
        teste:function(){
            this.polygons.push({
                path:[[
                  {lat: -38.81375546971009, lng: -53.63490624999997},
                  {lat: -38.83179331290262, lng: -51.23988671874997},
                  {lat: -38.4565891377291, lng: -51.26185937499997},
                  {lat: -38.42123554842336, lng: -53.61293359374997},
                ]]
            });
            return this.polygons[this.polygons.length - 1];
        },
        loadRegions: function(){

        },
        
        submitData: function(){
            
        },
        
        insertData: function(){
          /*
          this.macroregion.geo = JSON.stringify(this.loadpolygon);
            this.$http.post('/regions', this.region)
            .then((response) => {
              toastr.success('Sucesso!','Macro Região incluída com sucesso');
            }, (response) => { 
              this.showErrors(response.data); 
            });*/ 
        },
        
        updateData: function(){
         /*
            this.macroregion.geo = JSON.stringify(this.loadpolygon);
            this.$http.post('/regions/update', this.region)
            .then((response) => {
                toastr.success('Sucesso!','Região incluída com sucesso');
            }, (response) => { 
                this.showErrors(response.data); 
            }); */
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