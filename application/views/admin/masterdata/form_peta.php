<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet.css">
<script src="<?=base_url()?>assets/leaflet/leaflet.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet-panel-layers-master/src/leaflet-panel-layers.css">
<script src="<?=base_url()?>assets/leaflet/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>
<script src="<?=base_url()?>assets/leaflet/leaflet.ajax.js"></script>
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<style>
/* html,
body {
    height: 100%;
    margin: 0;
} */

#map {
    width: 100%;
    height: 400px;
}
</style>

<script>
var marker;
$('#map-view').on('shown.bs.collapse', function(e) {
    //creation of map
    var map = L.map('map').setView([-7.977014, 112.634056], 15)
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

    var overLayers = [{
        group: "Layer Kecamatan",
        layers: []
    }];

    var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers, {
        collapsibleGroups: true
    });
    map.addControl(panelLayers);

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);
    if ($("[name=id]").val() != "") {
        var latawal = $('[name="lat_awal"]').val();
        var longawal = $('[name="long_awal"]').val();
        var latakhir = $('[name="lat_akhir"]').val();
        var longakhir = $('[name="long_akhir"]').val();

        var pointAwal = new L.LatLng(latawal, longawal);
        var pointAkhir = new L.LatLng(latakhir, longakhir);
        var pointList = [pointAwal, pointAkhir];
        var polyline = new L.Polyline(pointList, {
            color: 'red',
            weight: 5,
            opacity: 0.5
        }).addTo(drawnItems);
        map.fitBounds(polyline.getBounds());
    }
    // draw control 
    var drawControl = new L.Control.Draw({
        draw: {
            rectangle: false,
            circle: false,
            polygon: false,
            circlemarker: false,
            marker: false
        },
        edit: {
            featureGroup: drawnItems
        }
    });
    map.addControl(drawControl);
    // draw created 
    map.on('draw:created', function(e) {
        e.layer.options.color = 'blue';
        e.layer.options.weight = 5;
        var type = e.layerType,
            layer = e.layer;
        var latLng = layer.getLatLngs();

        $('[name="lat_awal"]').val(latLng[0].lat);
        $('[name="long_awal"]').val(latLng[0].lng);
        $('[name="lat_akhir"]').val(latLng[1].lat);
        $('[name="long_akhir"]').val(latLng[1].lng);
        drawnItems.addLayer(layer);
    });

    // draw edited
    map.on('draw:edited', function(e) {
        var latLng = e.layers.getLayers()[0].getLatLngs();
        $('[name="lat_awal"]').val(latLng[0].lat);
        $('[name="long_awal"]').val(latLng[0].lng);
        $('[name="lat_akhir"]').val(latLng[1].lat);
        $('[name="long_akhir"]').val(latLng[1].lng);

    });
    // draw deleted
    map.on('draw:deleted', function(e) {
        var latLng = e.layers.getLayers()[0].getLatLngs();
        $('[name="lat_awal"]').val("");
        $('[name="long_awal"]').val("");
        $('[name="lat_akhir"]').val("");
        $('[name="long_akhir"]').val("");
    });
    // draw drawvertex 
    map.on('draw:drawvertex', function(e) {
        const layerLength = Object.keys(e.layers._layers);
        if (layerLength.length > 1) {
            const secondVertex = e.layers._layers[layerLength[1]]._icon;
            requestAnimationFrame(() => secondVertex.click());
        }
    });
});
</script>