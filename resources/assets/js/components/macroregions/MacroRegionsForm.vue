<style>
    map {
        width:600px;
        height: 600px;
        display: block;
    }
</style>

<template>
  <div id="code-input" class="form-group" >
    <label class="col-md-3 control-label">Nome</label>
      <div class="col-md-7" id="code">                
        <input type="text" 
          name="code"
          class="form-control" 
          placeholder="Nome"
          v-model="macroregion.code"
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
          v-model="macroregion.description"
        >
      </div>
  </div>

  <div id="code-input" class="form-group">
    <label class="col-md-3 control-label">Macro Região</label>
    <hr>
    <div class="row">
      <div class="col-md-12">
          <button v-show="selectedShape" id="delete-button" class="btn blue btn-block">Borrar Macro Región</button>
          <div class="map" v-el:macroregionmap></div>
      </div>
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
            @click="submitData" 
            class="btn blue btn-block"
          >
            Salvar
          </button>
        </div>
      </div>  
      
      <div class="col-md-3 pull-right" >
        <div class="form-group">
          <a href="/macroregions/">
              <button type="button" class="btn grey btn-block" v-show="canedit">Cancel</button>
          </a>
        </div>
      </div>
    </div>
  </div>
  <pre>
    {{$data | json}}
  </pre>
</template>

<script>
    //import {load, Map, Polygon} from 'vue-google-maps'
    import toastr from 'toastr'
    


export default{
    props:[
      'pmacroregion',
      'isedit'
    ],
    events: {
      MapsApiLoaded: function () {
        this.createMap();
        return true;
      },
    },
    data(){
        return{
            center: { lat: -34.612829, lng: -58.434704 },
            zoom: 5,
            canedit:true,
            selectedShape: null, 
            selectColor: null,
            drawingManager: null,
            loadpolygon:null,
            macroregion: {
                id:'',
                code: '',
                description: '',
                geo: ''
            },
        }
    },
    ready(){
        window._Macroregion = this;
        toastr.options.closeButton = true;
        if(_Macroregion.pmacroregion) this.loadMacroregion();
    },
    methods:{
      
      createMap: function () {
        _Macroregion.googleMap = new google.maps.Map(_Macroregion.$els.macroregionmap, {
            center: _Macroregion.center,
            zoom: _Macroregion.zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            zoomControl: true
        });
        _Macroregion.initDrawer();
      },
      
      initDrawer: function(){
        var polyOptions = {
          strokeWeight: 0,
          fillOpacity: 0.45,
          editable: true
        };
        
        _Macroregion.drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: google.maps.drawing.OverlayType.POLYGON,
          drawingControl: true,
          drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [
              google.maps.drawing.OverlayType.POLYGON,
              //google.maps.drawing.OverlayType.RECTANGLE
            ]
          },
          rectangleOptions: polyOptions,
          polygonOptions: polyOptions
        });
        
        _Macroregion.drawingManager.setMap(_Macroregion.googleMap);
        _Macroregion.initListeners();
      },
      
      initListeners: function(){
        google.maps.event.addListener(_Macroregion.drawingManager, 'overlaycomplete', function (e) {
          if (e.type !== google.maps.drawing.OverlayType.MARKER) {
            _Macroregion.drawingManager.setDrawingMode(null);
            var newShape = e.overlay;
            newShape.type = e.type;
            newShape.setDraggable(true);
            google.maps.event.addListener(newShape, 'click', function (e) {
              _Macroregion.setSelection(newShape);
            });
            _Macroregion.setSelection(newShape);
          }
        });
        
        //google.maps.event.addListener(_Macroregion.drawingManager, 'drawingmode_changed', _Macroregion.clearSelection);
        google.maps.event.addListener(_Macroregion.googleMap, 'click', _Macroregion.clearSelection);
        google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', _Macroregion.deleteSelectedShape);
        
        google.maps.event.addListener(_Macroregion.drawingManager, 'polygoncomplete', function (polygon) {
          _Macroregion.loadpolygon = (polygon.getPath().getArray());
          _Macroregion.drawingManager.setOptions({
            drawingControl: false
          });
        });
        
        google.maps.event.addListener(_Macroregion.drawingManager, 'rectanglecomplete', function (rectangle) {
          var coordinates = (rectangle.getBounds());
          console.log(coordinates);
          _Macroregion.drawingManager.setOptions({
            drawingControl: false
          });
        });
      },
      
      clearSelection: function(){
        if (_Macroregion.selectedShape) {
            _Macroregion.selectedShape.setEditable(false);
            _Macroregion.selectedShape = null;
        }
      },
      
      setSelection: function (shape) {
        _Macroregion.clearSelection();
        _Macroregion.selectedShape = shape;
        shape.setEditable(true);
      },
      
      deleteSelectedShape: function() {
        if (_Macroregion.selectedShape) {
          _Macroregion.selectedShape.setMap(null);
          _Macroregion.selectedShape = null;
          _Macroregion.macroregion.geo = null;
           _Macroregion.drawingManager.setOptions({
            drawingControl: true
          });
        }
      },
      
      loadMacroregion: function(){
        _Macroregion.macroregion.id = _Macroregion.pmacroregion.id,
        _Macroregion.macroregion.code = _Macroregion.pmacroregion.code,
        _Macroregion.macroregion.description = _Macroregion.pmacroregion.description,
        _Macroregion.loadpolygon = JSON.parse(_Macroregion.pmacroregion.geo);
        _Macroregion.canedit = _Macroregion.isedit;
        _Macroregion.createpolygon();
      },
      createpolygon: function(){
        console.log(_Macroregion.loadpolygon);
        
        var triangleCoords = [
          {lat: 25.774, lng: -80.190},
          {lat: 18.466, lng: -66.118},
          {lat: 32.321, lng: -64.757},
          {lat: 25.774, lng: -80.190}
        ];
        var bermudaTriangle = new google.maps.Polygon({});
        /*var bermudaTriangle = new google.maps.Polygon({
          paths: triangleCoords,
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.35
        });
        */
        //bermudaTriangle.setMap(_Macroregion.googlemap);
      },
      submitData: function(){
          if(!this.macroregion.id)
            this.insertData();
          else
            this.updateData();
      },
        
      insertData: function(){
        _Macroregion.macroregion.geo = JSON.stringify(_Macroregion.loadpolygon);
        this.$http.post('/macroregions', this.macroregion)
        .then((response) => {
          toastr.success('Sucesso!','Macro Região incluída com sucesso');
        }, (response) => { 
          this.showErrors(response.data); 
        }); 
      },
        
      updateData: function(){
        this.macroregion.geo = JSON.stringify(_Macroregion.loadpolygon);
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