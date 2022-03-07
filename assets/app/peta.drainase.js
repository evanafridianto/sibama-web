var map = L.map("map", {
    zoomControl: false,
}).setView([-7.977014, 112.634056], 14);
var zoomHome = L.Control.zoomHome({
    position: "bottomright",
});
zoomHome.addTo(map);
var drainaseLayer = [];

var osm = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; Sistem Informasi Banyu Malang",
    maxZoom: 18,
});
satellite = L.tileLayer(
    "http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
        attribution: "google",
        maxZoom: 18,
    }
);
map.addLayer(osm);

function lineColor(feature) {
    if (feature.properties["status_genangan"] == "Melimpah") {
        return "#FF0000";
    } else {
        return "#4400FF";
    }
}

for (i = 0; i < dataKecamatan.length; i++) {
    var data = dataKecamatan[i];
    var layer = {
        name: data.nama_kecamatan,
        layer: new L.GeoJSON.AJAX(
            [
                $("meta[name=app-url]").attr("content") +
                "jsoncontroller/data/drainase/line/" +
                data.id_kecamatan,
            ], {
                style: function(feature) {
                    return {
                        color: lineColor(feature),
                        weight: 4,
                        opacity: 0.8,
                    };
                },
                filter: function(feature, layer) {
                    if (feature.properties) {
                        // If the property "underConstruction" exists and is true, return false (don't render features under construction)
                        return feature.properties.underConstruction !== undefined ?
                            !feature.properties.underConstruction :
                            true;
                    }
                    return false;
                },
                onEachFeature: onEachFeature,
            }
        ).addTo(map),
    };
    drainaseLayer.push(layer);
}

var searchControl = new L.Control.Search({
    placeholder: "Search for Location",
    layer: layer.layer,
    propertyName: "lokasi",
    marker: false,
    collapsed: false,
    initial: false,
    buildTip: function(text, val) {
        var lokasi = val.layer.feature.properties.lokasi;
        return '<a href="#" >' + text + "</b></a>";
    },
    moveToLocation: function(latlng, title, map) {
        //map.fitBounds( latlng.layer.getBounds() );
        var zoom = map.getBoundsZoom(latlng.layer.getBounds());
        map.setView(latlng, zoom); // access the zoom
    },
});

map.on("zoomstart", function(e) {
    console.log(e);
});

searchControl
    .on("search:locationfound", function(e) {
        //console.log('search:locationfound', );
        //map.removeLayer(this._markerSearch)
        e.layer.setStyle({ fillColor: "#3f0", color: "#0f0" });
        if (e.layer._popup) e.layer.openPopup();
    })
    .on("search:collapsed", function(e) {
        resetHighlight;
    });
map.addControl(searchControl); //inizialize search control

function highlightFeature(e) {
    var layer = e.target;
    layer.setStyle({
        weight: 7,
        color: "#FBFF00",
        dashArray: "",
        fillOpacity: 1.0,
    });
}

function resetHighlight(e) {
    layer.layer.resetStyle(e.target);
}

function onEachFeature(feature, layer) {
    var URL = window.location.href; //get the url
    var arr = URL.split("/"); //split (/)
    var dimensi;
    var foto;
    if (
        feature.properties["file_dimensi"] == "" ||
        feature.properties["file_dimensi"] == "-" ||
        feature.properties["file_dimensi"] == "null"
    ) {
        dimensi = $("meta[name=app-url]").attr("content") + "upload/noimage.jpg";
    } else {
        dimensi =
            $("meta[name=app-url]").attr("content") +
            "upload/dimensi/" +
            feature.properties["file_dimensi"];
    }
    if (
        feature.properties["file_foto"] == "" ||
        feature.properties["file_foto"] == "-" ||
        feature.properties["file_foto"] == "null"
    ) {
        foto = $("meta[name=app-url]").attr("content") + "upload/noimage.jpg";
    } else {
        foto =
            $("meta[name=app-url]").attr("content") +
            "upload/foto/" +
            feature.properties["file_foto"];
    }

    if (feature.properties) {
        var content =
            "<h5>" +
            feature.properties["lokasi"] +
            "</h5>" +
            "<table class='table table-striped table-bordered table-condensed'>" +
            "<tr><th>Status Genangan</th><td>" +
            feature.properties["status_genangan"] +
            "</td></tr>" +
            "<tr><th>Curah Hujan Max Harian</th><td>" +
            feature.properties["r24"] +
            "(mm)" +
            "</td></tr>" +
            "<tr><th>Jalur Jalan</th><td>" +
            feature.properties["jalur_jalan"] +
            "</td></tr>" +
            "<tr><th>Tipe Drainase</th><td>" +
            feature.properties["tipe"] +
            "</td></tr>" +
            "<tr><th>Panjang Drainase</th><td>" +
            feature.properties["panjang"] +
            "</td></tr>" +
            "<tr><th>Kondisi Fisik</th><td>" +
            feature.properties["kondisi_fisik"] +
            "</td></tr>" +
            "<tr><th>Kondisi Sedimen</th><td>" +
            feature.properties["kondisi_sedimen"] +
            "</td></tr>" +
            "<tr><th>Penanganan</th><td>" +
            feature.properties["penanganan"] +
            "</td></tr>" +
            "<tr><th>Update</th><td>" +
            feature.properties["date"] +
            "</td></tr>" +
            "<tr><th colspan='2' class='text-center'>Foto Lokasi dan Gambar Dimensi</th></tr>" +
            "<tr><th><a href='" +
            foto +
            "' data-lightbox='#foto-image'><img id='foto-image' src='" +
            foto +
            "' alt='' class='img-responsive img-thumbnail' style='max-width: 100%;height: 100px;'></a></th><td><a href='" +
            dimensi +
            "' data-lightbox='#dimensi-image'><img id='dimensi-image' src='" +
            dimensi +
            "' alt='' class='img-responsive img-thumbnail' style='max-width: 100%;height: 100px;'></a></td></tr>";
        // button aksi for admin only
        if (feature.properties["admin"] && arr[4] == "admin") {
            content +=
                "<tr><th colspan='2' class=text-center>Aksi</th></tr>" +
                "<tr><th><button class=' btn-block table-action-btn btn-success' onclick='edit_drainase(" +
                feature.id +
                ")'><i class='mdi mdi-eye' title='Detail'></i> View</button></th><td><button class = ' btn-block table-action-btn btn-danger btn-hapus' onclick = 'delete_drainase(" +
                feature.id +
                ")'><i class='mdi mdi-close' title='Delete'></i> Delete</button></td></tr>";
        } +
        "<table>";
        layer.bindPopup(content, {
            maxHeight: 800,
        });
    }
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: onPopupOpen,
    });
}

function onPopupOpen() {
    var polyline = this;
    $(".btn-hapus").click(function(e) {
        $(".btn-del").click(function(e) {
            map.removeLayer(polyline);
        });
    });
}

map.on("overlayadd", function(e) {
    console.log(e);
});

var baseMaps = [{
        name: "OpenStreetMap",
        layer: osm,
    },
    {
        name: "GoogleSatellite",
        layer: satellite,
    },
];

var overLayers = [{
    group: "Drainase Kecamatan",
    layers: drainaseLayer,
}, ];

var panelLayers = new L.Control.PanelLayers(baseMaps, overLayers, {
    collapsibleGroups: true,
    // collapsed: true
});
map.addControl(panelLayers);

var legend = L.control({
    position: "bottomleft",
});

// legend
legend.onAdd = function(map) {
    var div = L.DomUtil.create("div", "legend");
    div.innerHTML += "<h6>Status Genangan</h6>";
    div.innerHTML +=
        '<span style="background-color: red;display: inline-block;height: 6px;margin-right: 5px;width: 18px;"></span><span>Melimpah</span><br>';
    div.innerHTML +=
        '<span style="background-color: blue;display: inline-block;height: 6px;margin-right: 5px;width: 18px;"></span><span>Tidak Melimpah</span><br>';
    return div;
};
legend.addTo(map);