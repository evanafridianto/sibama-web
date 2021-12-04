<link rel="stylesheet" href="<?=base_url()?>assets/leafletdraw/libs/leaflet.css" />
<script src="<?=base_url()?>assets/leafletdraw/libs/leaflet-src.js"></script>
<script src="<?=base_url()?>assets/leafletdraw/leaflet.ajax.js"></script>
<!-- Sweet Alert -->
<link href="<?=base_url()?>assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
<script src="<?=base_url()?>assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
<script src="<?=base_url()?>assets/plugins/autoNumeric/autoNumeric.js" type="text/javascript"></script>

</script>
</script>
<style>
html,
body {
    height: 100%;
    margin: 0;
}

#map {
    width: 100%;
    height: 600px;
}
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-color panel-default">
            <div class="panel-heading">
                <form action="#" id="form_r24">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" name="id_r24">
                                    <input type="text" placeholder="R24 (mm/jam)" name="r24" data-v-max="9999999.99"
                                        data-v-min="250.00" class="form-control autonumber">
                                    <small class="form-text text-danger"></small>
                                    <span class="input-group-btn">
                                        <button type="button" id="save_r24"
                                            class="btn btn-primary waves-effect waves-light">Setting
                                            R24 (mm)</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-body">
                <div id="map">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<script>
$(document).ready(function() {
    // Input Decimal and Number Only
    $("input[name='r24']").keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event
                .which > 57)) {
            event.preventDefault();
        }
    });
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
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                timer: 1500,
                timerProgressBar: true,
                title: 'Gagal!',
                html: 'Proses gagal!',
                icon: 'error',
                showConfirmButton: false,
            });
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
                if (data.status) {
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
                $('#save_r24').text('Setting R24'); //change button text
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
                $('#save_r24').text('Setting R24'); //change button text
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
                let tc = Math.pow((0.872 * Math.pow(parseFloat(l), 2)) / (1000 * parseFloat(s)),
                    0.385);
                let r24 = $('[name="r24"]').val()
                let i = (parseFloat(r24) / 24) * Math.pow(24 / parseFloat(tc), 2 / 3);
                let a = value.catchment_area;
                let konvA = parseFloat(a);
                var total1 = 0.278 * parseFloat(c) * parseFloat(i) * parseFloat(konvA);
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
                                [value.long_awal, value.lat_awal],
                                [value.long_akhir, value.lat_akhir]
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

            // setInterval(async () => {
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
                }).addTo(<?php echo $row->layer?>);
            // }, 1500);

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

var map = new L.Map('map', {
    center: new L.LatLng(-7.977014, 112.634056),
    zoom: 15,
    layers: [osm, <?php foreach($kecamatan as $row){?> <?= $row->layer?>, <?php }?>]
});
var baseMaps = {
    "Open Street Map": osm,
    "Google Satellite Map": satellite
};

var overlays = {
    <?php foreach($kecamatan as $row){?> '<?= $row->nama_kecamatan?>': <?= $row->layer?>,
    <?php }?>
};
L.control.layers(baseMaps, overlays, {
    collapsed: false
}).addTo(map);
</script>