/**
 * Created by otiagovicente on 26/01/17.
 */
window.Raphael = require("webpack-raphael");
window.axios = require("axios");

window.Magna = {};

window.Magna.geo = {
        /*
        *   Funções de manipulação Geoespacial
        *
        */
        geojson2svgPoints(geoJson){
            var svgPoints = [];

            _.forEach(geoJson, function(point) {
                svgPoints.push(Magna.geo.latLng2point(point));
            });
            return svgPoints;
        },
        latLng2point(latLng){
            return {
                x:(latLng.lng+180)*(256/360),
                y:(256/2)-(256*Math.log(Math.tan((Math.PI/4)
                    +((latLng.lat*Math.PI/180)/2)))/(2*Math.PI))
            };
        }
    };


window.Magna.svg = {

        createSVGPolygon(options){
            console.log(Raphael);
        },

    };

window.Magna.dialog = {



};

window.Magna.http = axios;