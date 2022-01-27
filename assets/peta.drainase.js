var map = L.map('map', {
    zoomControl: false
}).setView([-7.977014, 112.634056], 14);
var zoomHome = L.Control.zoomHome({
    position: 'topleft'
});

zoomHome.addTo(map);
var drainaseLayer = [];

var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 18
})
satellite = L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
    attribution: 'google',
    maxZoom: 18
})
map.addLayer(osm);

var kesimpulan;

function myStyle(feature) {
    // Q Drainase 
    let t = feature.properties['tinggi_saluran'];
    let b = feature.properties['lebar_saluran'];
    let s = feature.properties['slope'];
    let ag = feature.properties['luas_penampung'];
    let pg = feature.properties['keliling_penampung'];
    let v = parseFloat(ag) / Math.pow(pg, 2 / 3) * Math.pow(s, 1 / 2) /
        0.012;
    let q_drainase = parseFloat(v) * parseFloat(ag);

    //CIA
    let c = 0.6;
    let l = feature.properties['panjang_saluran'];
    let tc = Math.pow((0.872 * Math.pow(parseFloat(l), 2)) / (
            1000 *
            parseFloat(s)),
        0.385);
    let r24 = $('[name="r24"]').val()
    let i = (parseFloat(r24) / 24) * Math.pow(24 / parseFloat(tc), 2 / 3);
    let a = feature.properties['catchment_area'];
    let konvA = parseFloat(a);
    let cia = 0.278 * parseFloat(c) * parseFloat(i) * parseFloat(konvA);

    // Status Genangan Logic 
    if (cia > q_drainase) {
        kesimpulan = "<b>Melimpah</b>";
        return "#FF0000";
    } else {
        kesimpulan = "<b>Tidak Melimpah</b>";
        return "#4400FF";
    }
}

for (i = 0; i < dataKecamatan.length; i++) {
    var data = dataKecamatan[i];
    var layer = {
        name: data.nama_kecamatan,
        layer: new L.GeoJSON.AJAX([$('meta[name=app-url]').attr("content") + "datajson/data/drainase/line/" + data.id_kecamatan], {
            style: function(feature) {
                return {
                    "color": myStyle(feature),
                    "weight": 4,
                    "opacity": 0.8
                }
            },
            filter: function(feature, layer) {
                if (feature.properties) {
                    // If the property "underConstruction" exists and is true, return false (don't render features under construction)
                    return feature.properties
                        .underConstruction !==
                        undefined ?
                        !
                        feature.properties
                        .underConstruction : true;
                }
                return false;
            },
            onEachFeature: onEachFeature
        }).addTo(map)
    }
    drainaseLayer.push(layer);
}

function highlightFeature(e) {
    var layer = e.target;
    layer.setStyle({
        weight: 7,
        color: '#FBFF00',
        dashArray: '',
        fillOpacity: 1.0
    });
}

function resetHighlight(e) {
    layer.layer.resetStyle(e.target);
}

function onEachFeature(feature, layer) {
    var URL = window.location.href; //get the url
    var arr = URL.split('/'); //split (/)

    var kosong = $('meta[name=app-url]').attr("content") + 'upload/foto/noimage.jpg';
    var dimensi = $('meta[name=app-url]').attr("content") + 'upload/dimensi/' + feature.properties['file_dimensi'];
    var foto = $('meta[name=app-url]').attr("content") + 'upload/foto/' + feature.properties['file_foto'];
    var html = '';
    if (feature.properties) {
        html += '<h5>' + feature.properties['lokasi'] + '</h5>';
        html += '<table>';
        html += '<tr>';
        html += '<td>Status Genangan</td>';
        html += '<td>' + ': ' + kesimpulan + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Tipe Drainase</td>';
        html += '<td>' + ': ' + feature.properties['tipe_saluran'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Panjang Drainase</td>';
        html += '<td>' + ': ' + feature.properties['panjang_saluran'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Arah Aliran</td>';
        html += '<td>' + ': ' + feature.properties['arah_aliran'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Kondisi Fisik</td>';
        html += '<td>' + ': ' + feature.properties['kondisi_fisik'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Kondisi Sedimen</td>';
        html += '<td>' + ': ' + feature.properties['kondisi_sedimen'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Penanganan</td>';
        html += '<td>' + ': ' + feature.properties['penanganan'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Diupdate pada</td>';
        html += '<td>' + ': ' + feature.properties['date'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>Foto Lokasi dan Gambar Dimensi :</td>';
        html += '<tr>';
        html += '<td><img src="' + foto + '" alt="" class="img-responsive img-thumbnail" style="max-width: 100%;height: 100px;"></td>';
        html += '<td><img src="' + dimensi + '" alt=""  class="img-responsive img-thumbnail" style="max-width: 100%;height: 100px;"></td>';
        html += '<tr>';
        html += '<tr>';

        // button aksi for admin only 
        if (feature.properties['admin']) {
            if (arr[4] == 'admin') {
                html += '<td>Aksi</td>';
                html += '<td>' + feature.properties['button'] + '</td>';
                html += '</tr>';
            }
        }
        html += '</table>';
        layer.bindPopup(html, {
            maxHeight: 800,
        });
    }
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        // popupopen: onPopupOpen
    });
    layer.on("click", onPopupOpen);
}

function onPopupOpen() {
    var polyline = this;
    $(".btn-del").click(function() {
        map.removeLayer(polyline);
    });
}

var baseMaps = [{
        name: "OpenStreetMap",
        layer: osm
    },
    {
        name: "GoogleSatellite",
        layer: satellite
    }
];

var overLayers = [{
    group: "Layer Kecamatan",
    layers: drainaseLayer
}];

var panelLayers = new L.Control.PanelLayers(baseMaps, overLayers, {
    collapsibleGroups: true,
    // collapsed: true
});
map.addControl(panelLayers);


var info = L.control({
    position: 'topleft'
});

var legend = L.control({
    position: 'bottomleft'
});

legend.onAdd = function(map) {
    var div = L.DomUtil.create("div", "legend");
    div.innerHTML += "<h6>Status Genangan</h6>";
    div.innerHTML +=
        '<span style="background-color: red;display: inline-block;height: 6px;margin-right: 5px;width: 18px;"></span><span>Melimpah</span><br>';
    div.innerHTML +=
        '<span style="background-color: blue;display: inline-block;height: 6px;margin-right: 5px;width: 18px;"></span><span>Tidak Melimpah</span><br>';
    div.innerHTML += "<h6>Curah Hujan Max Harian</h6>";
    div.innerHTML +=
        "<span><i class='fa fa-cloud'></i> <span class='r24-info'> Tidak Diketahui</span><span/>";
    return div;
}
legend.addTo(map);

// setting r24
function setting_r24() {
    $('#settingr24_modal').modal('show'); // show bootstrap modal
}
$(document).ready(function() {
    // $('#form_r24')[0].reset();
    //Ajax Load data from ajax
    $.ajax({
        url: $('meta[name=app-url]').attr("content") + "web/detail_r24/" + 1,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_r24"]').val(data.id_r24);
            $('[name="r24"]').val(data.r24);

            $('.r24-info').html(data.r24 + " mm/jam");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: 'Gagal!',
                text: 'Proses gagal!',
                type: 'error',
                showConfirmButton: false,
                timer: 1500
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === 'timer') {}
                }
            )
        }
    });
});

// Save R24
function save_r24() {
    $('#save_r24').text('Menyimpan...'); //change button text
    $('#save_r24').attr('disabled', true); //set button disable 
    var formData = new FormData($('#form_r24')[0]);
    // ajax adding data to database
    $.ajax({
        url: $('meta[name=app-url]').attr("content") + "admin/peta/update_r24",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            $('.r24-info').html($('[name="r24"]').val() + " mm/jam");
            if (data.status) {
                $('#settingr24_modal').modal('hide'); // hide bootstrap modal
                swal({
                        title: 'Sukses!',
                        text: 'R24 berhasil disimpan!',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === 'timer') {}
                        }
                    )
                    //if success close modal and reload ajax table
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').next().text(data
                        .error_string[
                            i]
                    ); //select span text-danger class set text error string
                }
            }
            $('#save_r24').text('Simpan'); //change button text
            $('#save_r24').attr('disabled', false); //set button enable 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: 'Gagal!',
                text: 'Proses gagal!',
                type: 'error',
                showConfirmButton: false,
                timer: 1500
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === 'timer') {}
                }
            )
            $('#save_r24').text('Simpan'); //change button text
            $('#save_r24').attr('disabled', false); //set button enable 
        }
    });
}