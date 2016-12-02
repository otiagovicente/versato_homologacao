<style>
    .map {
        width:100%;
        height: 600px;
        display: block;
        z-index: 1;
    }
    .form-container{
        position: absolute;
        z-index:2;
    }
</style>

<template>
<div class="form-container">


    <div id="name-input" class="form-group">
            <input type="text"
                   name="code"
                   class="form-control"
                   placeholder="Nome"
                   v-model="macroregion.code"
            >
    </div>
    <div id="description-input" class="form-group">
            <input type="text"
                   name="code"
                   class="form-control"
                   placeholder="Descrição"
                   v-model="macroregion.description"
            >
    </div>
    <div class="button-group">

        <button
                v-show="canedit"
                type="button"
                @click="submitData"
                class="btn blue btn-block"
        >
            Salvar
        </button>
        <button v-show="selectedShape" id="delete-button" class="btn blue btn-block">Borrar Macro Región
        </button>
        <a href="/macroregions/">
            <button type="button" class="btn grey btn-block" v-show="canedit">Cancel</button>
        </a>
    </div>

</div>

    div
    <div class="map" v-el:macroregionmap></div>


    <pre> {{$data | json}} </pre>
</template>

<script >
    import toastr from 'toastr'
	
    export default{
        props: [
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
            return {
                center: {lat: -34.612829, lng: -58.434704},
                zoom: 5,
                canedit: true,
                selectedShape: null,
                selectColor: null,
                drawingManager: null,
                loadPolygon: null,
                macroregion: {
                    id: '',
                    code: '',
                    description: '',
                    geo: '',
                    teste:'',
                },
            }
        },
        ready(){
            window._Macroregion = this;
            toastr.options.closeButton = true;
            if (_Macroregion.pmacroregion) this.loadMacroregion();
        },
        methods: {

            /*
             *  Funções de inicialização do GoogleMaps
             */
            createMap: function () {
                _Macroregion.googleMap = new google.maps.Map(_Macroregion.$els.macroregionmap, {
                    center: _Macroregion.center,
                    zoom: _Macroregion.zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    zoomControl: true
                });
                if(_Macroregion.pmacroregion) _Macroregion.createPolygon(_Macroregion.googleMap);
                _Macroregion.initDrawer();
            },

            initDrawer: function () {
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

            initListeners: function () {
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
                _Macroregion.initClickListener();
                _Macroregion.initDeleteButtonListener();
                _Macroregion.initPolygonCompleteListener();
                //_Macroregion.initRectangleCompleteListener();

            },
            initClickListener(){
                google.maps.event.addListener(_Macroregion.googleMap, 'click', _Macroregion.clearSelection);
            },
            initDeleteButtonListener(){
                google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', _Macroregion.deleteSelectedShape);
            },
            initPolygonCompleteListener(){
                google.maps.event.addListener(_Macroregion.drawingManager, 'polygoncomplete', function (polygon) {
                    google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
                        _Macroregion.loadPolygon = (polygon.getPath().getArray());
                    });
                    google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
                        _Macroregion.loadPolygon = (polygon.getPath().getArray());
                    });
                    _Macroregion.loadPolygon = (polygon.getPath().getArray());
                    _Macroregion.drawingManager.setOptions({
                        drawingControl: false
                    });
                });
            },
            
            initRectangleCompleteListener(){
                google.maps.event.addListener(_Macroregion.drawingManager, 'rectanglecomplete', function (rectangle) {
                    var coordinates = (rectangle.getBounds());
                    _Macroregion.drawingManager.setOptions({
                        drawingControl: false
                    });
                });
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
                    _Macroregion.macroregion.geo = null;
                    _Macroregion.drawingManager.setOptions({
                        drawingControl: true
                    });
                }
            },
            createPolygon: function (map) {
                var polygon = new google.maps.Polygon({
                    paths: _Macroregion.loadPolygon,
                    strokeWeight: 0,
                    fillOpacity: 0.45,
                    editable: true,
                    draggable:true
                });
                polygon.setMap(map);

                google.maps.event.addListener(polygon.getPath(), 'insert_at', function(index, obj) {
                    _Macroregion.teste(polygon.getPath().getArray());
                });
                google.maps.event.addListener(polygon.getPath(), 'set_at', function(index, obj) {
                    _Macroregion.teste(polygon.getPath().getArray());
                });
            },
            teste: function(p){
                console.log(p);
                _Macroregion.macroregion.geo = p;
                _Macroregion.macroregion.teste = p;
            },
            loadMacroregion: function () {
                _Macroregion.macroregion.id = _Macroregion.pmacroregion.id,
                _Macroregion.macroregion.code = _Macroregion.pmacroregion.code,
                _Macroregion.macroregion.description = _Macroregion.pmacroregion.description,
                _Macroregion.loadPolygon = JSON.parse(_Macroregion.pmacroregion.geo);
                _Macroregion.canedit = _Macroregion.isedit;
            },
            /*
             * Funções de envio de dados
             */

            submitData: function () {
                if (!this.macroregion.id)
                    this.insertData();
                else
                    this.updateData();
            },

            insertData: function () {
                _Macroregion.macroregion.geo = JSON.stringify(_Macroregion.loadPolygon);
                this.$http.post('/macroregions', this.macroregion)
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

        filters: {}
    }
</script>