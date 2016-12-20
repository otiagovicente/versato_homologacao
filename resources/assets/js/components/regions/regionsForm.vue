<style>
    map {
        width:100%;
        height: 600px;
        display: block;
    }
    .form-container{
        position: absolute;
        z-index:2;
    }
    .control-ui{
      background-color: white;
      cursor: pointer;
      text-align: center;
  }
  .control-text{
    font-family: Arial,sans-serif;
    font-size: 12px;
    padding: 4px 4px;
  }
</style>

<template>
  <div class="form-container">
        <div class="button-group">
            <button
                type="button"
                @click="submitData"
                class="btn blue btn-block"
            >
                Salvar
            </button>
            <button v-show="selectedShape" id="delete-button" class="btn blue btn-block">
                Borrar Macro Región
            </button>
            <a href="/regions/">
                <button type="button" class="btn grey btn-block">Cancel</button>
            </a>
        </div>
    </div>

    <div class="map" v-el:regionmap style="width:100%;height:800px;"></div>
    
<!-- MODAL  -->
    <div id="region-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="infowindow-modal">
                        <div class="iw-container" style="display:block">
                            <div class="iw-title">Región</div>
                            <div class="iw-content">
                                <div class="row">
                                    <div class="col-md-10">
                                        <span class="blue">Codigo</span>
                                        <div class="form-group form-line-input">
                                            <input id="code-input" v-model="region.code" class="form-control input-sm" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <span class="blue">Descrición</span>
                                        <div class="form-group form-line-input">
                                            <input id="description-input" v-model="region.description" class="form-control input-sm" type="text" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="ModalSave">Salvar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

  <div id="control-div" class="control-div">
    <div id= "control-ui" class="control-ui" title = "Click to set the map to Home">
      <div id="control-text" class="control-text">
        <v-select 
          v-bind:options.sync="macroregions_select"
          :value.sync="macroregion"  
          placeholder="Elige la macro región"
          id="macroregions-input" 
          name="macroregions[]" 
          search justified required close-on-select
        ></v-select>
      </div>
    </div>
  </div>
</template>

<script>
    import toastr from 'toastr'
    import VueStrap from 'vue-strap'

export default{
    components: {
        vSelect: VueStrap.select,
        vOption: VueStrap.option,
    },

    data(){
        return {
            center: {lat: -34.612829, lng: -58.434704},
            zoom: 5,
            selectedShape: null,
            drawingManager: null,
            lstPolygons:[],
            infowindow:null,
            inside_id:0,
            deletePolygons:[],
            selectedMacroRegion:null,
            macroregions_select:[],
            macroregion:[], 
            region: {
                inside_id:'',
                code: '',
                description:''
            },
            fillColorEdit: 'yellow',
            fillColorNew: 'red',
            fillColorSaved: 'green',
            fillColorMouseOver: 'black',
            fillColorMacroregion: 'blue',
        }
    },
    
    ready(){
        window._Region = this;
        toastr.options.closeButton = true;
        this.getMacroRegions();
    },
    
    methods:{
        ModalSave(){
            var index = _Region.lstPolygons.indexOf(_Region.selectedShape);
            _Region.lstPolygons[index].code = _Region.region.code;
            _Region.lstPolygons[index].description = _Region.region.description;
            
            if(_Region.lstPolygons[index].id) {
                _Region.lstPolygons[index].edited = true;
                _Region.lstPolygons[index].setOptions({fillColor: _Region.fillColorEdit});
            }
        },
        createMap() {
            _Region.googleMap = new google.maps.Map(_Region.$els.regionmap, {
                center: _Region.center,
                zoom: _Region.zoom,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true,
                zoomControl: true
            });
            _Region.initDrawer();
            _Region.initInfoWindow();
            _Region.initControls();
        },
        initDrawer(){
            var polyOptions = {
                strokeWeight: 0,
                fillOpacity: 0.50,
                fillColor: _Region.fillColorNew,
                editable: true
            };
            _Region.drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: null,
                drawingControl: false,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP,
                    drawingModes: [
                        google.maps.drawing.OverlayType.POLYGON,
                    ]
                },
                polygonOptions: polyOptions
            });
            _Region.drawingManager.setMap(_Region.googleMap);
            _Region.initListeners(_Region.googleMap);
        },
        initListeners() {
            google.maps.event.addListener(_Region.drawingManager, 'overlaycomplete', function (e) {
                if (e.type !== google.maps.drawing.OverlayType.MARKER) {
                    _Region.drawingManager.setDrawingMode(null);
                    var polygon = e.overlay;
                    polygon.type = e.type;
                    polygon.setDraggable(true);
                    polygon.set('id', '');
                    polygon.set('code', '');
                    polygon.set('description', '');
                    polygon.set('macroregion_id', _Region.selectedMacroregion.id);
                    _Region.createRegionPolygonListeners(polygon);
                }
            });
            
            _Region.initClickListener();
            _Region.initDeleteButtonListener();
        },
        initClickListener(){
            google.maps.event.addListener(_Region.googleMap, 'click', function() {
                _Region.clearSelection();
                _Region.infowindow.close();
            });
        },
        initDeleteButtonListener(){
            google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', _Region.deleteSelectedShape);
        },
        initInfoWindow(){
            _Region.infowindow = new google.maps.InfoWindow({
                maxWidth: 350
            });
            _Region.initInfoWindowListeners();
        },
        initInfoWindowListeners(){
            google.maps.event.addListener(_Region.infowindow, 'domready', function() {
                
            });
        },
        showModal(polygon){
            _Region.region.code = polygon.code;
            _Region.region.description = polygon.description; 
            $('#region-modal').modal('show');
        },
        initControls(){
            var controlDiv =$("#control-div");
            var controlUI = $("#control-ui");
            var controlText = $("#control-text");
            controlDiv.index = 1;
            _Region.googleMap.controls[google.maps.ControlPosition.TOP_CENTER].push(controlDiv[0]);
        },
        getPolygonCenter(polygon){
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < polygon.getPath().getArray().length; i++) {
                bounds.extend(polygon.getPath().getArray()[i]);
            }
            return bounds.getCenter();
        },
        createPolygon(obj, type) {
            var polygon;
            switch (type){
                case 'macroregion':
                    polygon = new google.maps.Polygon({
                    paths: JSON.parse(obj.geo),
                    fillOpacity: 0.50,
                    strokeWeight:0,
                    editable: false,
                    fillColor: _Region.fillColorMacroregion,
                    draggable:false,
                    id: obj.id,
                    code: obj.code,
                    description: obj.description,
                    });
                    _Region.createMacroRegionPolygonListeners(polygon);
                break;
            
                case 'region':
                    polygon = new google.maps.Polygon({
                        paths: JSON.parse(obj.geo),
                        fillOpacity: 0.50,
                        strokeWeight:0,
                        editable: true,
                        fillColor: _Region.fillColorSaved,
                        draggable:true,
                        id: obj.id,
                        code: obj.code,
                        description: obj.description,
                        macroregion_id:obj.macroregion_id,
                        edited:false,
                    });
                    _Region.createRegionPolygonListeners(polygon);
                break;
            }
            polygon.setMap(_Region.googleMap);
            return polygon;
        },
        createMacroRegionPolygonListeners(polygon){

        },
        createRegionPolygonListeners(polygon){
            google.maps.event.addListener(polygon, 'click', function (event) {
                _Region.setSelection(polygon);
                _Region.showModal(polygon);
                
            });
            google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
                if(polygon.id){
                    polygon.setOptions({fillColor: _Region.fillColorEdit});
                    polygon.set('edited', true);
                }
            });
            google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
                if(polygon.id){
                    polygon.setOptions({fillColor: _Region.fillColorEdit});
                    polygon.set('edited', true);
                }
            });
            google.maps.event.addListener(polygon, "mousemove", function(event) {
                _Region.setInfoDescription(polygon);
                polygon.setOptions({strokeWeight: 3.0, strokeColor:_Region.fillColorMouseOver});
            });
            google.maps.event.addListener(polygon, "mouseout", function(event) {
                polygon.setOptions({strokeWeight: 0});
                _Region.infowindow.close(_Region.googleMap);
            });
            
            polygon.set('inside_id', _Region.inside_id++);
            _Region.lstPolygons.push(polygon);
        },
        setInfoDescription(polygon){
            if(polygon.description){
                _Region.infowindow.setContent(_Region.setInfoDescriptionContent(polygon));
                _Region.infowindow.setPosition(_Region.getPolygonCenter(polygon));
                _Region.infowindow.open(_Region.googleMap);
            }
        },
        setInfoError(polygon){
            _Region.infowindow.setContent(_Region.setInfoErrorContent(polygon));
            _Region.infowindow.setPosition(_Region.getPolygonCenter(polygon));
            _Region.infowindow.open(_Region.googleMap);
        },
        setInfoErrorContent(polygon){
            return 'Complete la información de la región!';
            //$('.iw-container#'+ polygon.inside_id).html();
        },
        setInfoDescriptionContent(polygon){
            return polygon.description;
        },
        getMacroRegions(){
            this.$http.get('/api/macroregions/selectlist')
            .then(response => {
                _Region.macroregions_select = response.json();
            });
        },

        submitData(){
            if(_Region.lstPolygons){
                if(_Region.deleteRegions) _Region.cleanRegions();

                for (var i = 0; i < _Region.lstPolygons.length; i ++ ){
                    if(_Region.lstPolygons[i].code && _Region.lstPolygons[i].description){
                        if (!_Region.lstPolygons[i].id) _Region.insertData(_Region.lstPolygons[i]);
                        else {
                            if(_Region.lstPolygons[i].edited) _Region.updateData(_Region.lstPolygons[i]);
                        }
                    }else{
                        _Region.setInfoError(_Region.lstPolygons[i]);
                    }
                }
            }
        },
        
        loadRegion: function(polygon){
            return {
                id: polygon.id
                , code: polygon.code
                , description:polygon.description
                , macroregion_id: polygon.macroregion_id
                , geo:JSON.stringify(polygon.getPath().getArray())
            };
        },
        
        insertData: function(polygon){
            this.$http.post('/regions', _Region.loadRegion(polygon))
            .then((response) => {
                var index = _Region.lstPolygons.indexOf(_Region.selectedShape);
                if (index > -1) _Region.lstPolygons.splice(index, 1);
                
                _Region.setSelection(polygon);
                _Region.selectedShape.setMap(null);
                
                _Region.createPolygon(response.json(), 'region');
                
                toastr.success('Sucesso!','Região incluída com sucesso');
            }, (response) => { 
                console.log(response.data); 
            });
        },
        
        updateData: function(polygon){
            var region = _Region.loadRegion(polygon);
            this.$http.put('/regions/' + region.id, region)
            .then((response) => {
                var index = _Region.lstPolygons.indexOf(_Region.selectedShape);
                if (index > -1) _Region.lstPolygons.splice(index, 1);
                
                _Region.setSelection(polygon);
                _Region.selectedShape.setMap(null);

                _Region.createPolygon(response.json(), 'region');
                
                toastr.success('Sucesso!','Região alterada com sucesso');
            }, (response) => { 
                console.log(response.data); 
            });
        },

        cleanRegions(){
            for (var i = 0; i < this.deleteRegions.length; i ++ ){
                this.$http.delete('/regions/' + _Region.deleteRegions[i].id)
                .then((response) => {
                    console.log('Região excluída com sucesso');
                }, (response) => { 
                    console.log(response.data); 
                });
            }
        },
        clearPolygonsRegions(){
            for (var i = 0; i < _Region.lstPolygons.length; i ++ ){
                _Region.lstPolygons[i].setMap(null);
            }
            _Region.lstPolygons   = [];
            _Region.deleteRegions = [];
        },
        clearSelection() {
            if (_Region.selectedShape) {
                _Region.selectedShape.setEditable(false);
                _Region.selectedShape = null;
            }
        },
        setSelection(shape) {
            _Region.clearSelection();
            _Region.selectedShape = shape;
            shape.setEditable(true);
        },
        deleteSelectedShape() {
            if (_Region.selectedShape) {
                //Caso o polygon possua um id, ou seja, já esta na base de dados
                //inclui o polygon na lista de  regiões a serem deletadas
                if(_Region.selectedShape.id) _Region.deleteRegions.push(_Region.selectedShape);
                
                //Deleta o polygon da lista de polygons dinâmica
                var index = _Region.lstPolygons.indexOf(_Region.selectedShape);
                if (index > -1) _Region.lstPolygons.splice(index, 1);
                
                //Deleta o polygon do mapa
                _Region.selectedShape.setMap(null);
                _Region.selectedShape = null;
            }
        },
    },
    
    watch: {
        'macroregion': function (val, oldVal) {
            if(_Region.macroregion){
                _Region.drawingManager.setOptions({drawingControl: true});
                _Region.clearPolygonsRegions();
                
                if(_Region.selectedMacroregion) _Region.selectedMacroregion.setMap(null);

                this.$http.get('/api/macroregions/geo/' + _Region.macroregion)
                .then((response) => {
                    var objMacroregions = response.json();
                    _Region.selectedMacroregion = _Region.createPolygon(objMacroregions, 'macroregion');
                    _Region.googleMap.setCenter(_Region.getPolygonCenter(_Region.selectedMacroregion));
                    _Region.googleMap.setZoom(7);

                    //se a macro região possui regiões cadastradas, carrega as regiões na tela
                    if(objMacroregions.regions){
                        for (var i = 0; i < objMacroregions.regions.length; i ++ ){
                            _Region.createPolygon(objMacroregions.regions[i], 'region');
                        }
                    }
                }, (response) => {
                    toastr.error('erro!', console.log(response.data));
                });
            }else{
                if(!val && typeof(oldVal) != 'object'){
                    _Region.drawingManager.setOptions({drawingControl: false});
                }
            }
        },
    },
    events: {
            MapsApiLoaded: function () {
                this.createMap();
                return true;
            },
        },
}
</script>