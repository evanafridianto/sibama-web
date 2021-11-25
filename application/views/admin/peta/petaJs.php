<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet.css">
<script src="<?=base_url()?>assets/leaflet/leaflet.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet-panel-layers-master/src/leaflet-panel-layers.css">
<script src="<?=base_url()?>assets/leaflet/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>
<script src="<?=base_url()?>assets/leaflet/leaflet.ajax.js"></script>

<style>
html,
body {
    height: 100%;
    margin: 0;
}

#map {
    width: 100%;
    height: 680px;
}

.dot {
    height: 15px;
    width: 15px;
    border-radius: 50%;
    display: inline-block;
}
</style>


<script>
var map = L.map('map').setView([-7.977014, 112.634056], 14);

var Osm = L.tileLayer(
    'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    })

Satellite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    maxZoom: 18,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
})

map.addLayer(Osm, Satellite);

var baseLayers = [{
        name: "OpenStreetMap",
        layer: Osm
    },
    {
        name: "GoogleSatellite",
        layer: Satellite
    }
];

L.polyline([
    [45.51, -122.68],
    [37.77, -122.43],
    [34.04, -118.2]

], {
    color: 'red'
})


// var polyline = L.polyline(latlngs, {
//     color: 'blue'
// }).addTo(map);
// map.fitBounds(polyline.getBounds());


var overLayers = [{
    group: "Layer Kecamatan",
    layers: []
}];

var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers, {
    collapsibleGroups: true
});

map.addControl(panelLayers);
</script>