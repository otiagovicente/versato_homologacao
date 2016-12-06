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
    	.gm-style-iw {
	width: 350px !important;
	top: 15px !important;
	left: 0px !important;
	background-color: #fff;
	box-shadow: 0 1px 6px rgba(178, 178, 178, 0.6);
	border: 1px solid rgba(72, 181, 233, 0.6);
	border-radius: 2px 2px 10px 10px;
}
.iw-container {
	margin-bottom: 10px;
	width: 100%;
}
.iw-container .iw-title {
	font-family: 'Open Sans Condensed', sans-serif;
	font-size: 22px;
	font-weight: 400;
	padding: 10px;
	background-color: #48b5e9;
	color: white;
	margin: 0;
	border-radius: 2px 2px 0 0;
}
.iw-container .iw-content {
	font-size: 13px;
	line-height: 18px;
	font-weight: 400;
	margin-right: 1px;
	padding: 15px 5px 20px 15px;
	max-height: 140px;
	overflow-y: auto;
	overflow-x: hidden;
}
.iw-content img {
	float: right;
	margin: 0 5px 5px 10px;	
}
.iw-subTitle {
	font-size: 16px;
	font-weight: 700;
	padding: 5px 0;
}
.iw-bottom-gradient {
	position: absolute;
	width: 326px;
	height: 25px;
	bottom: 10px;
	right: 18px;
	background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
	background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
	background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
	background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
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

    <div v-for="lstPolygons in polygon">
        oi
        <div v-bind:id="amem-$index" class="iw-container">
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
            <div class="iw-bottom-gradient"></div>
        </div>
    </div>



</template>

<script type="text/babel">
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
                macroregions: {},
                teste: 'alok',
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
            createMap: function () {
                _Macroregion.googleMap = new google.maps.Map(_Macroregion.$els.macroregionmap, {
                    center: _Macroregion.center,
                    zoom: _Macroregion.zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    zoomControl: true
                });
                _Macroregion.initDrawer();
                _Macroregion.initInfoWindow();
                if(_Macroregion.pmacroregions) this.loadMacroregions();
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

            initListeners: function () {
                google.maps.event.addListener(_Macroregion.drawingManager, 'overlaycomplete', function (e) {
                    if (e.type !== google.maps.drawing.OverlayType.MARKER) {
                        _Macroregion.drawingManager.setDrawingMode(null);
                        var polygon = e.overlay;
                        polygon.type = e.type;
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
                    var iwOuter = $('.gm-style-iw');
                    var iwBackground = iwOuter.prev();
                    iwBackground.children(':nth-child(2)').css({'display' : 'none'});
                    iwBackground.children(':nth-child(4)').css({'display' : 'none'});
                    iwOuter.parent().parent().css({left: '115px'});
                    iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;'});
                    iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;'});
                    iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});
                    var iwCloseBtn = iwOuter.next();
                    iwCloseBtn.css({opacity: '1', right: '38px', top: '3px', border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});
                    if($('.iw-content').height() < 140){
                        $('.iw-bottom-gradient').css({display: 'none'});
                    }
                    iwCloseBtn.mouseout(function(){
                        $(this).css({opacity: '1'});
                    });
                });
            },
            
            createPolygon(objMacroregion) {
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
                polygon.setMap(_Macroregion.googleMap);
                _Macroregion.createPolygonListeners(polygon);
            },

            createPolygonListeners(polygon){
                google.maps.event.addListener(polygon, 'click', function (event) {
                    _Macroregion.setSelection(polygon);
                    _Macroregion.loadInfoWindow(event, polygon);
                });
                
                google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
                    //console.log(polygon.getPath().getArray());
                });
                google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
                   //console.log(polygon.getPath().getArray());
                });
                //_Macroregion.setSelection(polygon);
                _Macroregion.lstPolygons.push(polygon);
            },
            
            loadInfoWindow(event, polygon){
                _Macroregion.infowindow.setContent(_Macroregion.loadInfoWindowContent(polygon));
                _Macroregion.infowindow.setPosition(event.latLng);
                _Macroregion.infowindow.open(_Macroregion.googleMap);
            },
            loadInfoWindowContent(polygon){
                return '<div id="iw-container">'+
                '    <div class="iw-title">Macro Região</div>'+
                '    <div class="iw-content">'+
                '        <div class="row">'+
                '            <div class="col-md-10">'+
                '                <span class="blue">Codigo</span>'+
                '                <div class="form-group form-line-input" id="code">'+
                '                    <input id="code-input" v-model="teste" class="form-control input-sm" type="text" value="'+polygon.code+'"/>'+
                '                </div>'+
                '            </div>'+
                '        </div>'+
                '        <div class="row">'+
                '            <div class="col-md-10">'+
                '                <span class="blue">Descrición</span>'+
                '                <div class="form-group form-line-input" id="description">'+
                '                    <input id="description-input" class="form-control input-sm" type="text" value="'+polygon.description+'"/>'+
                '                </div>'+
                '            </div>'+
                '        </div>'+
                '    </div>'+
                '    <div class="iw-bottom-gradient"></div>'+
                '</div>';
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
            
            loadMacroregions: function () {
                for (var i = 0; i < this.pmacroregions.length; i ++ ){
                    _Macroregion.createPolygon(this.pmacroregions[i]);
                }
            },

            /*
             * Funções de envio de dados
             */
            submitData: function () {
                for (var i = 0; i < this.lstPolygons.length; i ++ ){
                    var macroregion = {
                        id: this.lstPolygons[i].id
                        , code: this.lstPolygons[i].code
                        , description:this.lstPolygons[i].description
                        , geo:JSON.stringify(this.lstPolygons[i].getPath().getArray())
                    };
                    //if (!macroregion.id) this.insertData(macroregion);
                    //else this.updateData(macroregion);
                }
            },

            insertData: function (macroregion) {
                this.$http.post('/macroregions', macroregion)
                .then( (response) => {
                    toastr.success('Sucesso!', 'Macro Região incluída com sucesso');
                }).catch( (response) => {
                    this.showErrors(response.data);
                });
            },

            updateData: function (macroregion) {
                this.$http.put('/macroregions/' + macroregion.id, macroregion)
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