// Bornes monde
var nwWorld = L.latLng(90, -180);
var seWorld = L.latLng(-90, 180);
var boundsWorld = L.latLngBounds(nwWorld, seWorld);
// Bornes Europe
var nwEur = L.latLng(75,-25);
var seEur = L.latLng(30,40);
var boundsEur = L.latLngBounds(nwEur, seEur);
// Bornes Asie
var nwAsia = L.latLng(85,25);
var seAsia = L.latLng(-20,185);
var boundsAsia = L.latLngBounds(nwAsia, seAsia);
// Bornes Afrique
var nwAfr = L.latLng(40,-30);
var seAfr = L.latLng(-40,60);
var boundsAfr = L.latLngBounds(nwAfr, seAfr);
// Bornes Amérique
var nwAme = L.latLng(85,-175);
var seAme = L.latLng(-60,-20);
var boundsAme = L.latLngBounds(nwAme, seAme);
// Bornes Océanie
var nwOce = L.latLng(8,105);
var seOce = L.latLng(-50,215);
var boundsOce = L.latLngBounds(nwOce, seOce);
// Création de la map
var map = null;

// Initialisation de la couche StamenWatercolor
var coucheStamenWatercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
    attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    subdomains: 'abcd',
    ext: 'jpg'
});

// Initialisation de la carte et association avec la div
if($_GET("mode") === "europe"){
    map = new L.Map('map', {
        center: [50, 10],
        minZoom: 3,
        maxZoom: 18,
        zoom: 3,
        maxBounds: boundsEur
    });
}

else if($_GET("mode") === "asie"){
    var map = new L.Map('map', {
        center: [40, 80],
        minZoom: 2,
        maxZoom: 18,
        zoom: 2,
        maxBounds: boundsAsia
    });
}

else if($_GET("mode") === "afrique"){
    var map = new L.Map('map', {
        center: [1, 17],
        minZoom: 3,
        maxZoom: 18,
        zoom: 3,
        maxBounds: boundsAfr
    });
}

else if($_GET("mode") === "amerique"){
    var map = new L.Map('map', {
        center: [10, -90],
        minZoom: 2,
        maxZoom: 18,
        zoom: 2,
        maxBounds: boundsAme
    });
}

else if($_GET("mode") === "oceanie"){
    var map = new L.Map('map', {
        center: [-22, 165],
        minZoom: 3,
        maxZoom: 18,
        zoom: 3,
        maxBounds: boundsOce
    });
}

else if($_GET("mode") === "monde"){
    var map = new L.Map('map', {
        center: [48.858376, 2.294442],
        minZoom: 2,
        maxZoom: 18,
        zoom: 2,
        maxBounds: boundsWorld
    });
}

// Affichage de la carte
map.addLayer(coucheStamenWatercolor);
// Juste pour changer la forme du curseur par défaut de la souris
document.getElementById('map').style.cursor = 'crosshair';

/**
*   Récupère un paramètre GET dans l'URL
*/
function $_GET(param) {
    var curr_url = new URL(window.location.href);
    return curr_url.searchParams.get(param);
}