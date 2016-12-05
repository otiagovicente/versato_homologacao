<style>
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

    <div class="map" v-el:macroregionmap></div>

</template>

<script >
    import toastr from 'toastr'
	
    export default{
        props: [
            'pmacroregions'
        ],
        data(){
            return {
                center: {lat: -34.612829, lng: -58.434704},
                zoom: 5,
                selectedShape: null,
                drawingManager: null,
                lstPolygons:[],
                infowindow:null,
                
                macroregion: {
                    id: '',
                    code: '',
                    description: '',
                    geo: '',
                },
            }
        },

        ready(){
            window._Macroregion = this;
            toastr.options.closeButton = true;
            //if (_Macroregion.pmacroregions) this.loadMacroregions();
        },

        methods: {
            /*
             *  Funções de inicialização do GoogleMaps
             */
            createMap: function () {
                var map = new google.maps.Map(_Macroregion.$els.macroregionmap, {
                    center: _Macroregion.center,
                    zoom: _Macroregion.zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    zoomControl: true
                });
                _Macroregion.googleMap = map;
                _Macroregion.initDrawer();
                _Macroregion.initInfoWindow();
                if(_Macroregion.pmacroregions) this.loadMacroregions(map);
            },

            initDrawer: function () {
                var polyOptions = {
                    strokeWeight: 0,
                    fillOpacity: 0.50,
                    strokeColor: '#FF0000',
                    strokeWeight:2,
                    fillColor: '#FF0000',
                    editable: true
                };

                _Macroregion.drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.POLYGON,
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

            initListeners: function (map) {
                google.maps.event.addListener(_Macroregion.drawingManager, 'overlaycomplete', function (e) {
                    if (e.type !== google.maps.drawing.OverlayType.MARKER) {
                        _Macroregion.drawingManager.setDrawingMode(null);
                        var polygon = e.overlay;
                        polygon.type = e.type;
                        polygon.setDraggable(true);
                        _Macroregion.createPolygonListeners(polygon, map);
                    }
                });

                //google.maps.event.addListener(_Macroregion.drawingManager, 'drawingmode_changed', _Macroregion.clearSelection);
                _Macroregion.initClickListener();
                _Macroregion.initDeleteButtonListener();
            },
            initClickListener(){
                google.maps.event.addListener(_Macroregion.googleMap, 'click', _Macroregion.clearSelection);
            },
            initDeleteButtonListener(){
                google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', _Macroregion.deleteSelectedShape);
            },
            initInfoWindow(){
                _Macroregion.infowindow = new google.maps.InfoWindow({
                    size: new google.maps.Size(150, 50)
                });
            },
            
            createPolygon(map, objMacroregion) {
                //alert(objMacroregion.geo);
                
                var polygon = new google.maps.Polygon({
                    paths: JSON.parse(objMacroregion.geo),
                    strokeWeight: 2,
                    fillOpacity: 0.50,
                    editable: true,
                    draggable:true,
                    id: objMacroregion.id,
                    code: objMacroregion.code,
                    description: objMacroregion.description,
                });
                polygon.setMap(map);
                _Macroregion.createPolygonListeners(polygon, map);
            },

            createPolygonListeners(polygon,map){
                google.maps.event.addListener(polygon, 'click', function (event) {
                    _Macroregion.setSelection(polygon);

                    _Macroregion.infowindow.setContent('info window maneira');
                    _Macroregion.infowindow.setPosition(event.latLng);
                    _Macroregion.infowindow.open(map);
                });
                
                google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
                    console.log(polygon.getPath().getArray());
                });
                google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
                    console.log(polygon.getPath().getArray());
                });
                //_Macroregion.setSelection(polygon);
                _Macroregion.lstPolygons.push(polygon);
            },

            /*
             * Funções de manipulação do GoogleMaps
             */
            clearSelection: function () {
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

            deleteSelectedShape: function () {
                if (_Macroregion.selectedShape) {
                    _Macroregion.selectedShape.setMap(null);
                    _Macroregion.selectedShape = null;
                }
            },
            loadMacroregions: function (map) {
                for (var i = 0; i < this.pmacroregions.length; i ++ ){
                    _Macroregion.createPolygon(map, this.pmacroregions[i]);
                }
                //_Macroregion.macroregion.id = _Macroregion.pmacroregion.id,
                //_Macroregion.macroregion.code = _Macroregion.pmacroregion.code,
                //_Macroregion.macroregion.description = _Macroregion.pmacroregion.description,
                //_Macroregion.loadPolygon = JSON.parse(_Macroregion.pmacroregion.geo);
            },

            /*
             * Funções de envio de dados
             */

            submitData: function () {
                for (var i = 0; i < this.lstPolygons.length; i ++ ){
                    var macroregion = {
                        id:''
                        , code: this.lstPolygons[i].code
                        , description:this.lstPolygons[i].description
                        , geo:JSON.stringify(this.lstPolygons[i].getPath().getArray())
                    };
                    //this.insertData(macroregion);
                }
                //if (!this.macroregion.id) this.insertData();
                //else this.updateData();
            },

            insertData: function (macroregion) {
                //_Macroregion.macroregion.geo = JSON.stringify(_Macroregion.loadPolygon);
                this.$http.post('/macroregions', macroregion)
                .then( (response) => {
                    toastr.success('Sucesso!', 'Macro Região incluída com sucesso');
                }).catch( (response) => {
                    this.showErrors(response.data);
                });
            },

            updateData: function () {
                this.macroregion.geo = JSON.stringify(_Macroregion.loadPolygon);
                this.$http.put('/macroregions/' + this.macroregion.id, this.macroregion)
                .then((response) => {
                    toastr.success('Sucesso!', 'Macro Região atualizada com sucesso');
                }).catch((response) => {
                    this.showErrors(response.data);
                });
            },

            showErrors: function (data) {
                $.each(data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#' + key).addClass('has-error');
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