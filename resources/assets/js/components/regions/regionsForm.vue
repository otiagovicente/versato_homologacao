<style>
    map {
        width:100%;
        height: 600px;
        display: block;
    }
</style>

<template> 
  <div id="code-input" class="form-group" >
    <label class="col-md-3 control-label">Macro Regiones</label>
      <div class="col-md-7" id="code">                
        
        <v-select 
          v-bind:options.sync="macroregions_select"
          :value.sync="macroregion"  
          placeholder="Elije la macro región"  
          id="macroregions-input" 
          name="macroregions[]" 
          search justified required close-on-select
        ></v-select>
      </div>
  </div>

  <div id="code-input" class="form-group">
      <div class="col-md-12" style="padding:15px">
        <button v-show="macroregion" type="button" class="btn grey btn-block" @click="addNewRegion">Nueva Región</button>
        <br/>
        
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th class="col-md-3">Región</th>
              <th class="col-md-3">Descripción</th>
              <th class="col-md-3">Borrar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="r in regions">
              <td>
                <input type="text" 
                  name="code"
                  class="form-control" 
                  placeholder="Región"
                  v-model="r.code"
                >
              </td>
              <td>
                <input type="text" 
                  name="description"
                  class="form-control" 
                  placeholder="Descripción"
                  v-model="r.description"
                >
              </td>
              <td>
                <button 
                  v-show="canedit"
                  type="button" 
                  class="btn blue btn-block"
                  
                  @click="deleteRegion($index)"
                >Borrar</button> 
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  </div>
  
  <div id="code-input" class="form-group">
    <label class="col-md-3 control-label">Regiones</label>
      <div class="col-md-12" style="padding:15px">
        <br/>
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
            :options="{geodesic:true, strokeColor:'#8080ff', fillColor:'#668cff', draggable: false}"
          ></polygon>
          
          <polygon
            v-for="r in regions"
            :paths.sync="r.path" 
            :editable="true" 
            :options="{geodesic:true, strokeColor:'#33ff33', fillColor:'#00e600', draggable: true}"
          >
          </polygon>
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
    import VueStrap from 'vue-strap'
    

export default{
    props:[
      'pregions',
      'isedit',
      'pmacroregions'
    ],
    components: {
      vSelect: VueStrap.select,
      vOption: VueStrap.option,
      Map,
      Polygon
    },
    
    data(){
        return{
            center: { lat: -34.612829, lng: -58.434704 },
            zoom: 5,
            mapType: 'roadmap',
            mapStyle: 'normal',
            scrollwheel: true,
            mapBounds: {},
            canedit:true,
            macroregions_select: new Array(),
            regions:[],
            deleteRegions:[],
            macroregion:[],
            loadpolygon:[],
            regionsEven: false,
        }
    },
    
    ready(){
        load(Maps.maps_key, Maps.maps_version)
        toastr.options.closeButton = true;
        this.getMacroRegions();

    },
    
    methods:{
        submitData: function(){
            if(this.regions){
              if(this.deleteRegions)
                this.cleanRegions();

              for (var i = 0; i < this.regions.length; i ++ ){
                if(this.regions[i].id)
                  this.updateData(this.regions[i]);
                else
                  this.insertData(this.regions[i]);
              }
            }
        },

        getMacroRegions: function(){
            this.$http.get('/api/macroregions/selectlist')
            .then(response => {
                this.macroregions_select = response.json();
            });
        },

        addNewRegion: function(){
          this.regions.push({
              id:'',
              code:'',
              description: '',
              macroregion_id:this.macroregion, 
              path:[[
                {lat: -34.81375546971009, lng: -63.63490624999997},
                {lat: -34.83179331290262, lng: -61.23988671874997},
                {lat: -36.4565891377291, lng: -61.26185937499997},
                {lat: -36.42123554842336, lng: -63.61293359374997},
              ]],
              geo:'',
            });
            return this.regions[this.regions.length - 1];
        },

        addRegion: function(region){
          this.regions.push({
              id:region.id,
              code:region.code,
              description: region.description,
              macroregion_id:region.macroregion_id, 
              path:JSON.parse(region.geo),
              geo:region.geo,
            });
            return this.regions[this.regions.length - 1];
        },

        deleteRegion: function(index){
          this.deleteRegions.push(this.regions[index]);
          this.regions.splice(index, 1);
        },
        
        insertData: function(region){
          region.geo = JSON.stringify(region.path);
          this.$http.post('/regions', region)
          .then((response) => {
            toastr.success('Sucesso!','Região incluída com sucesso');
          }, (response) => { 
            this.showErrors(response.data); 
          });
        },
        
        updateData: function(region){
          region.geo = JSON.stringify(region.path);
          this.$http.put('/regions/'+region.id, region)
          .then((response) => {
            toastr.success('Sucesso!','Região alterada com sucesso');
          }, (response) => { 
            this.showErrors(response.data); 
          });
        },

        cleanRegions(){
          for (var i = 0; i < this.deleteRegions.length; i ++ ){
            this.$http.delete('/regions/'+this.deleteRegions[i].id)
            .then((response) => {
              console.log('Região excluída com sucesso');
            }, (response) => { 
              consolo.log(response.data); 
            });
          }
        },

        showErrors: function(data){
          $.each(data, function (key, value) {
            toastr.warning('Atención', value);
            $('#'+key).addClass('has-error');
          }); 
        },
    },
    
    watch: {
        'macroregion': function (val, oldVal) {
          this.regions = [];
          this.deleteRegions = [];

          if(this.macroregion){
            this.$http.get('/api/macroregions/geo/'+this.macroregion)
            .then((response) => {
              var objMacroregions = response.json();
               
              //seta variáveis
              this.loadpolygon = JSON.parse(objMacroregions.geo);
              this.zoom = 6;

              // calcula o centro 
              var objCenter = {lat:'', lng:''};
              objCenter.lat = this.loadpolygon[0][0].lat + ((this.loadpolygon[0][3].lat - this.loadpolygon[0][0].lat) / 2);
              objCenter.lng = this.loadpolygon[0][0].lng + ((this.loadpolygon[0][3].lng - this.loadpolygon[0][0].lng) / 2);
              this.center = objCenter;
              
              
              //se a macro região possui regiões cadastradas, carrega as regiões na tela
              if(objMacroregions.regions){
                for (var i = 0; i < objMacroregions.regions.length; i ++ ){
                  this.addRegion(objMacroregions.regions[i]);
                }
              }
            }, (response) => {
              toastr.error('erro!', console.log(response.data));
            });
          }
        },
    }
}
</script>