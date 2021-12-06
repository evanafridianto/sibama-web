<link rel="stylesheet" href="<?=base_url()?>assets/leafletdraw/libs/leaflet.css" />
<script src="<?=base_url()?>assets/leafletdraw/libs/leaflet-src.js"></script>
<script src="<?=base_url()?>assets/leafletdraw/leaflet.ajax.js"></script>
<!-- Sweet Alert -->
<link href="<?=base_url()?>assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
<script src="<?=base_url()?>assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

<script src="<?=base_url()?>assets/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet-panel-layers-master/src/leaflet-panel-layers.css" />
<!-- Leaflet Search Control  -->
<script src="<?=base_url()?>assets/leaflet-search-master/src/leaflet-search.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet-search-master/src/leaflet-search.css" />


<style>
html,
body {
    height: 100%;
    margin: 0;
}

#map {
    width: 100%;
    height: 620px;
}

/*Legend specific*/
.legend {
    padding: 8px;
    background: white;
    background: rgba(255, 255, 255, 0.8);
    /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
    border-radius: 5px;
    line-height: 24px;
    color: #555;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-color panel-default">
            <div class="panel-heading">
                <button type="button" title="Setting R24" class="btn btn-icon waves-effect waves-light btn-default"
                    data-toggle="modal" data-target="#setting-r24"><i class="fa fa-cloud"></i>
                    Curah Hujan max harian :
                    <strong id="r24-info">Tidak Diketahui</strong></button>
            </div>
            <div class="panel-body">
                <div id="map">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
<div id="setting-r24" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Setting R24</h4>
            </div>
            <div class="modal-body">
                <form action="#" id="form_r24">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="id_r24">
                                <input type="text" placeholder="R24 (mm/jam)" name="r24" class="form-control">
                                <small class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" id="save_r24" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->


<script>
$(document).ready(function() {
    // Setting R24 
    $('#form_r24')[0].reset();
    //Ajax Load data from ajax
    $.ajax({
        url: $('meta[name=app-url]').attr("content") + "admin/peta/edit_r24/" + 1,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_r24"]').val(data.id_r24);
            $('[name="r24"]').val(data.r24);

            $("#r24-info").html(data.r24 + " mm/jam");
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
    // Save R24
    $('#save_r24').click(function() {
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
                $("#r24-info").html($('[name="r24"]').val() + " mm/jam");
                if (data.status) {
                    $('#setting-r24').modal('hide');
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
                                i]); //select span text-danger class set text error string
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
    });
})

var map;
<?php foreach($kecamatan as $row){ ?>
var <?=$row->layer;?> = new L.layerGroup();
$.ajax({
    url: $('meta[name=app-url]').attr("content") + "admin/peta/titik_drainase",
    type: "GET",
    dataType: "json",
    beforeSend: function() {
        swal({
            title: 'Loading...',
            text: 'Memproses data',
            timer: 1200,
            showConfirmButton: false,
            onOpen: () => {
                swal.showLoading()
            }
        }).then(
            function() {},
            // handling the promise rejection
            function(dismiss) {}
        )
    },
    success: function(response) {
        $.each(response, function(key, value) {
            if (value.id_kecamatan == <?= $row->id_kecamatan;?>) {
                //Q Drainase
                let t = value.tinggi_saluran;
                let b = value.lebar_saluran;
                let s = value.slope;
                let ag = value.luas_penampung;
                let pg = value.keliling_penampung;
                let v = parseFloat(ag) / Math.pow(pg, 2 / 3) * Math.pow(s, 1 / 2) / 0.012;
                let total = parseFloat(v) * parseFloat(ag);

                var q_drainase = total.toFixed(10);

                //CIA
                let c = 0.6;
                let l = value.panjang_saluran;
                let tc = Math.pow((0.872 * Math.pow(parseFloat(l), 2)) / (
                        1000 *
                        parseFloat(s)),
                    0.385);
                let r24 = $('[name="r24"]').val()
                let i = (parseFloat(r24) / 24) * Math.pow(24 / parseFloat(tc), 2 / 3);
                let a = value.catchment_area;
                let konvA = parseFloat(a);
                let total1 = 0.278 * parseFloat(c) * parseFloat(i) * parseFloat(konvA);
                //TOTAL1 (Q Limpasan), Total (Q Drainase)
                var cia = total1.toFixed(2)

                var kesimpulan;
                var myStyle;
                // Status Genangan Logic 
                if (total1 > total) {
                    kesimpulan = "Melimpah";
                    myStyle = {
                        "color": "#FF0000",
                        "weight": 4,
                        "opacity": 0.8
                    };
                } else {
                    kesimpulan = "Tidak Melimpah";
                    myStyle = {
                        "color": "#2F00FF",
                        "weight": 4,
                        "opacity": 0.8
                    };
                }
                var titik_koordinat<?= $row->id_kecamatan;?> = {
                    "type": "FeatureCollection",
                    "features": [{
                        "type": "Feature",
                        "geometry": {
                            "type": "LineString",
                            "coordinates": [
                                [value.long_awal, value
                                    .lat_awal
                                ],
                                [value.long_akhir, value
                                    .lat_akhir
                                ]
                            ]
                        },
                        "properties": {
                            "popupContent": '<table class="table table-condensed m-0">\
                                <tr>\
                                <th scope="row">Kelurahan</th>\
                                <td>' + ": " + value.nama_kelurahan + '</td>\
                                </tr>\
                                <tr>\
                                <th scope="row">Kecamatan</th>\
                                <td>' + ": " + value.nama_kecamatan + '</td>\
                                </tr>\
                                <tr>\
                                <th scope="row">Lajur </th>\
                                <td>' + ": " + value.lajur_drainase + '</td>\
                                </tr>\
                                <tr>\
                                <th scope="row">Status Genangan </th>\
                                <td>' + ":" + kesimpulan + '</td>\
                                </tr>\
                                <tr>\
                                <td>\
                                <div class="button-list">\
                                <button type="button" class="btn btn-primary waves-effect waves-light btn-xs" onclick="detail_drainase' +
                                '(' + value.id + ')' +
                                '">Detail</button><button type="button" class="btn btn-success waves-effect waves-light btn-xs" onclick="edit_drainase' +
                                '(' + value.id + ')' +
                                '">Edit</button><button type="button" class="btn btn-danger waves-effect waves-light btn-xs" onclick="delete_drainase' +
                                '(' + value.id + ')' + '">Hapus</button>\
                                </div>\
                                </td>\
                                </tr>\
                                <tr>\
                                </table>',
                            "underConstruction": false
                        },
                        "id": value.id

                    }]
                };

            }


            var titik_koordinatLayer = L.geoJSON(
                titik_koordinat<?= $row->id_kecamatan;?>, {
                    style: myStyle,
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
                }).addTo(<?= $row->layer?>);

            function onEachFeature(feature, layer) {
                var popupContent = '<h5>' + value.nama_jalan + '</h5>';
                if (feature.properties && feature.properties.popupContent) {
                    popupContent += feature.properties.popupContent;
                }
                layer.bindPopup(popupContent, {
                    maxHeight: "auto"
                });
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,

                });
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
                titik_koordinatLayer.resetStyle(e.target);
            }
        });
    },
    error: function(response) {
        swal({
            title: 'Gagal!',
            text: 'Proses gagal!',
            type: 'error',
            showConfirmButton: false,
            timer: 1200
        }).then(
            function() {},
            // handling the promise rejection
            function(dismiss) {
                if (dismiss === 'timer') {}
            }
        )
    }
});
<?php } ?>

var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18
    }),
    satellite = L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
        attribution: 'google',
        maxZoom: 18
    })

var map = L.map('map', {
    center: [-7.977014, 112.634056],
    zoom: 15
});
map.addLayer(osm);

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
    layers: [<?php foreach($kecamatan as $row){?> {
            active: true,
            name: '<?= $row->nama_kecamatan?>',
            layer: <?= $row->layer?>,
        },
        <?php }?>
    ]
}];

var panelLayers = new L.Control.PanelLayers(baseMaps, overLayers, {
    collapsibleGroups: true,
    // collapsed: true
});
map.addControl(panelLayers);


var legend = L.control({
    position: 'bottomright'
});
legend.onAdd = function(map) {
    var div = L.DomUtil.create('div', 'info legend');
    div.innerHTML += "<h5>Status Genangan</h5>";
    div.innerHTML +=
        '<span style="background-color: red;display: inline-block;height: 6px;margin-right: 5px;width: 18px;"></span><span>Melimpah</span><br>';
    div.innerHTML +=
        '<span style="background-color: blue;display: inline-block;height: 6px;margin-right: 5px;width: 18px;"></span><span>Tidak Melimpah</span><br>';
    return div;
};
legend.addTo(map);
</script>