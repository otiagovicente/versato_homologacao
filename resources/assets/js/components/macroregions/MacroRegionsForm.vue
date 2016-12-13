<style scoped>
    .map {
        width:100%;
        height: 600px;
        z-index: 1;
    }
    .form-container{
        position: absolute;
        z-index:2;
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
            <a href="/macroregions/">
                <button type="button" class="btn grey btn-block">Cancel</button>
            </a>
        </div>
    </div>

    <div class="map" v-el:macroregionmap style="width:100%;height:800px;"></div>
    <!-- MODAL  -->
    <div id="macroregion-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div v-for="polygon in lstPolygons" class="infowindow-modal">
                        
                        <div v-bind:id="lstPolygons[$index].inside_id" class="iw-container" style="display:none">
                            <div class="iw-title">Macro Região</div>
                            <div class="iw-content">
                                <div class="row">
                                    <div class="col-md-10">
                                        <span class="blue">Codigo</span>
                                        <div class="form-group form-line-input">
                                            <input id="code-input" v-model="lstPolygons[$index].code" class="form-control input-sm" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <span class="blue">Descrición</span>
                                        <div class="form-group form-line-input">
                                            <input id="description-input" v-model="lstPolygons[$index].description" class="form-control input-sm" type="text" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import toastr from 'toastr'
    export default{
        data(){
            return {
                center: {lat: -34.612829, lng: -58.434704},
                zoom: 5,
                selectedShape: null,
                drawingManager: null,
                lstPolygons:[],
                infowindow:null,
                macroregions: {},
                inside_id:0,
                deletePolygons:[],
            }
        },
        ready(){
            window._Macroregion = this;
            toastr.options.closeButton = true;
        },

        methods: {
            /*
             *  Funções de inicialização do GoogleMaps
             */
            createMap() {
                _Macroregion.googleMap = new google.maps.Map(_Macroregion.$els.macroregionmap, {
                    center: _Macroregion.center,
                    zoom: _Macroregion.zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    zoomControl: true
                });
                _Macroregion.initDrawer();
                _Macroregion.initInfoWindow();
                _Macroregion.loadMacroregions();
            },

            initDrawer(){
                var polyOptions = {
                    strokeWeight: 0,
                    fillOpacity: 0.50,
                    fillColor: '#FF0000',
                    editable: true
                };
                _Macroregion.drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: null,//google.maps.drawing.OverlayType.POLYGON,
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: [
                            google.maps.drawing.OverlayType.POLYGON,
                        ]
                    },
                    polygonOptions: polyOptions
                });
                _Macroregion.drawingManager.setMap(_Macroregion.googleMap);
                _Macroregion.initListeners(_Macroregion.googleMap);
            },

            initListeners() {
                google.maps.event.addListener(_Macroregion.drawingManager, 'overlaycomplete', function (e) {
                    if (e.type !== google.maps.drawing.OverlayType.MARKER) {
                        _Macroregion.drawingManager.setDrawingMode(null);
                        var polygon = e.overlay;
                        polygon.type = e.type;
                        polygon.set('id', '');
                        polygon.set('code', '');
                        polygon.set('description', '');
                        polygon.setDraggable(true);
                        _Macroregion.createPolygonListeners(polygon);
                    }
                });
                _Macroregion.initClickListener();
                _Macroregion.initDeleteButtonListener();
            },
            
            initClickListener(){
                google.maps.event.addListener(_Macroregion.googleMap, 'click', function() {
                    _Macroregion.clearSelection();
                    _Macroregion.infowindow.close();
                });
            },

            initDeleteButtonListener(){
                google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', _Macroregion.deleteSelectedShape);
            },

            initInfoWindow(){
                _Macroregion.infowindow = new google.maps.InfoWindow({
                    maxWidth: 350
                });
                _Macroregion.initInfoWindowListeners();
            },

            initInfoWindowListeners(){
                google.maps.event.addListener(_Macroregion.infowindow, 'domready', function() {
                    
                });
            },
            
            createPolygon(objMacroregion) {
                var polygon = new google.maps.Polygon({
                    paths: JSON.parse(objMacroregion.geo),
                    fillOpacity: 0.50,
                    editable: true,
                    draggable:true,
                    id: objMacroregion.id,
                    code: objMacroregion.code,
                    description: objMacroregion.description,
                    edited:false,
                });
                polygon.setMap(_Macroregion.googleMap);
                _Macroregion.createPolygonListeners(polygon);
            },

            createPolygonListeners(polygon){
                google.maps.event.addListener(polygon, 'click', function (event) {
                    _Macroregion.showModal(polygon);
                    _Macroregion.setSelection(polygon);
                });
                google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
                    if(polygon.id){
                        polygon.setOptions({fillColor: 'yellow'});
                        polygon.set('edited', true);
                    }
                });
                google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
                   if(polygon.id){
                        polygon.setOptions({fillColor: 'yellow'});
                        polygon.set('edited', true);
                    }
                });
                google.maps.event.addListener(polygon, "mousemove", function(event) {
                    _Macroregion.setInfoDescription(polygon);
                    polygon.setOptions({strokeWeight: 3.0, strokeColor:'green'});
                });
                google.maps.event.addListener(polygon, "mouseout", function(event) {
                    polygon.setOptions({strokeWeight: 0, strokeColor:'green'});
                    _Macroregion.infowindow.close(_Macroregion.googleMap);
                });
                
                polygon.set('inside_id', _Macroregion.inside_id++);
                _Macroregion.lstPolygons.push(polygon);
            },
            showModal(polygon){
                $('.iw-container').each(function(i, obj) {
                    $(this).hide();
                });
                $('.iw-container#'+ polygon.inside_id).show();
                $('#macroregion-modal').modal('show');
            },
            
            setInfoDescription(polygon){
                if(polygon.description){
                    _Macroregion.infowindow.setContent(_Macroregion.setInfoDescriptionContent(polygon));
                    _Macroregion.infowindow.setPosition(_Macroregion.getPolygonCenter(polygon));
                    _Macroregion.infowindow.open(_Macroregion.googleMap);
                }
            },
            setInfoError(polygon){
                _Macroregion.infowindow.setContent(_Macroregion.setInfoErrorContent(polygon));
                _Macroregion.infowindow.setPosition(_Macroregion.getPolygonCenter(polygon));
                _Macroregion.infowindow.open(_Macroregion.googleMap);
            },
            setInfoErrorContent(polygon){
                return 'Complete la información de la macro región!';
                //$('.iw-container#'+ polygon.inside_id).html();
            },
            setInfoDescriptionContent(polygon){
                return polygon.description;
            },
            getPolygonCenter(polygon){
                var bounds = new google.maps.LatLngBounds();
                for (var i = 0; i < polygon.getPath().getArray().length; i++) {
                    bounds.extend(polygon.getPath().getArray()[i]);
                }
                return bounds.getCenter();
            },

            /*
             * Funções de manipulação do GoogleMaps
             */
            clearSelection() {
                if (_Macroregion.selectedShape) {
                    _Macroregion.selectedShape.setEditable(false);
                    _Macroregion.selectedShape = null;
                }
            },
            setSelection(shape) {
                _Macroregion.clearSelection();
                _Macroregion.selectedShape = shape;
                shape.setEditable(true);
            },
            deleteSelectedShape() {
                if (_Macroregion.selectedShape) {
                    if(_Macroregion.selectedShape.id) _Macroregion.deletePolygons.push(_Macroregion.selectedShape);
                    
                    var index = _Macroregion.lstPolygons.indexOf(_Macroregion.selectedShape);
                    if (index > -1) _Macroregion.lstPolygons.splice(index, 1);
                    
                    _Macroregion.selectedShape.setMap(null);
                    _Macroregion.selectedShape = null;
                }
            },

            /*
            * Funções de comunicação com a API
            */
            loadMacroregion: function(polygon){
                return {
                    id: polygon.id
                    , code: polygon.code
                    , description:polygon.description
                    , geo:JSON.stringify(polygon.getPath().getArray())
                };
            },
            submitData: function () {
                //deleta macro regiões 
                if(_Macroregion.deletePolygons.length > 0){
                    for (var x = 0; x < _Macroregion.deletePolygons.length; x++ ){
                        if(_Macroregion.deletePolygons[x].id) _Macroregion.deleteData(_Macroregion.deletePolygons[x].id);
                    }
                    _Macroregion.deletePolygons = [];
                }

                //salva e atualiza macro regioões criadas no mapa
                for (var i = 0; i < _Macroregion.lstPolygons.length; i ++ ){
                    if(_Macroregion.lstPolygons[i].code && _Macroregion.lstPolygons[i].description){
                        if (!_Macroregion.lstPolygons[i].id) _Macroregion.insertData(_Macroregion.lstPolygons[i]);
                        else {
                            if(_Macroregion.lstPolygons[i].edited) _Macroregion.updateData(_Macroregion.lstPolygons[i]);
                        }
                    }else{
                        _Macroregion.setInfoError(_Macroregion.lstPolygons[i]);
                    }
                }
            },
            loadMacroregions: function () {
                this.$http.get('/api/macroregions')
                .then( (response) => {
                    _.each(response.json(), function(value, key){
                        _Macroregion.createPolygon(value);
                    });
                })
                .catch((response) => {
                    console.log('no fue possible cargar las macroregiones');
                });
            },
            insertData: function (polygon) {
                var macroregion = _Macroregion.loadMacroregion(polygon);
                this.$http.post('/macroregions', macroregion)
                .then( (response) => {
                    var index = _Macroregion.lstPolygons.indexOf(_Macroregion.selectedShape);
                    if (index > -1) _Macroregion.lstPolygons.splice(index, 1);
                    
                    _Macroregion.setSelection(polygon);
                    _Macroregion.selectedShape.setMap(null);
                    _Macroregion.createPolygon(response.json());
                    
                    toastr.success('Sucesso!', 'Macro Região creada con successo!');
                }).catch( (response) => {
                    console.log(response);
                });
            },
            updateData: function (polygon) {
                var macroregion = _Macroregion.loadMacroregion(polygon);
                this.$http.put('/macroregions/' + macroregion.id, macroregion)
                .then((response) => {
                    var index = _Macroregion.lstPolygons.indexOf(_Macroregion.selectedShape);
                    if (index > -1) _Macroregion.lstPolygons.splice(index, 1);
                    
                    _Macroregion.setSelection(polygon);
                    _Macroregion.selectedShape.setMap(null);
                    _Macroregion.createPolygon(response.json());

                    toastr.success('Sucesso!', 'Macro Região actualizada con successo!');
                }).catch((response) => {
                    console.log(response);
                });
            },
            deleteData: function(id){
                this.$http.delete('/macroregions/' + id)
                .then((response) => {
                    toastr.success('Sucesso!', 'Macro Região borrada con successo!');
                }).catch((response) => {
                    console.log(response);
                });
            },
        },
        
        events: {
            MapsApiLoaded: function () {
                this.createMap();
                return true;
            },
        },

        filters: {

        },
    }
</script>