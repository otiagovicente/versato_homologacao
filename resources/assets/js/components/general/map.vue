<style>
    #map {
        height: 100%;
    }
</style>

<template>
    bla bla bla
    <div id="map"></div>
</template>

<script>
    //load('AIzaSyBvsUfqhKn021ZZOZtRGyuRIIKE96vfQ8U', '3.23')
export default{ 
    components: {

    },
    
    data(){
        return{
            maps: {
              center: { lat: -34.612829, lng: -58.434704 },
              zoom: 6,
              mapType: 'roadmap',
              mapStyle: 'normal',
              scrollwheel: true
            },
        }
    },
    ready(){
        console.log('chegou aqui');
        var myOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: new google.maps.LatLng(25.761680, -80.19179)
        };
        var map = new google.maps.Map(document.getElementById("map"), myOptions);
        //this.initMap();
    },

    methods: {
        initMap: function(){
            console.log('iniciou');
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            });

            var drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.MARKER,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [
                        google.maps.drawing.OverlayType.MARKER,
                        google.maps.drawing.OverlayType.CIRCLE,
                        google.maps.drawing.OverlayType.POLYGON,
                        google.maps.drawing.OverlayType.POLYLINE,
                        google.maps.drawing.OverlayType.RECTANGLE
                    ]
                },
                markerOptions: {icon: 'images/beachflag.png'},
                circleOptions: {
                fillColor: '#ffff00',
                fillOpacity: 1,
                strokeWeight: 5,
                clickable: false,
                editable: true,
                zIndex: 1
                }
            });
            drawingManager.setMap(map);
        },
    },
}
</script>