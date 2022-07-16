// table global var
var table;
$(function() {
    //datatables
    table = $("#table").DataTable({
        order: [], //Initial no order.
        processing: true,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/DrainaseController/show_all",
            type: "GET",
        },
        columnDefs: [{
            targets: 0,
            searchable: false,
            orderable: false,
            className: "dt-body-center",
        }, ],
        deferRender: true,
    });

    // datepicker
    $(".datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd",
        language: "id",
    });

    // select2
    $(".select2").select2({
        dropdownParent: $("#modal_form"),
    });

    // delete all check box
    $("#select-all").on("click", function() {
        // Check/uncheck all checkboxes in the table
        var rows = table
            .rows({
                search: "applied",
            })
            .nodes();
        $(".select1", rows).prop("checked", this.checked);

        // check delete all logic
        if ($(this).is(":checked", true)) {
            $(".hapus-kabeh").removeAttr("style"); // button delete all show
        } else {
            $(".hapus-kabeh").prop("style", "display:none", true); // button delete all hide
        }
    });

    // Handle click on checkbox to set state of "Select all" control
    $("#table tbody").on("change", ".select1", function() {
        // If checkbox is not checked
        if (!this.checked) {
            var el = $("#select-all").get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if (el && el.checked && "indeterminate" in el) {
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
        // check delete one logic
        if ($(".select1:checked").length > 0) {
            $(".hapus-kabeh").removeAttr("style"); // button delete all show
        } else {
            $(".hapus-kabeh").prop(
                "style",
                "display:none", // button delete all hide
                true
            );
        }
    });

    // if modal hidden
    $("#modal_form").on("hidden.bs.modal", function() {
        $("#collapseOne").collapse("hide");
    });

    // if map collapse hidden
    $(".map-view").on("hidden.bs.collapse", function() {
        $("#refreshBtn").html(
            '<i class="fa fa-map-pin m-r-5"></i>Pilih Titik Koordinat'
        ); // button view, text changes
    });

    // set input / select event when change value, remove text text - danger
    $('#form :input[type="text"], select').bind(
        "keyup change input",
        function() {
            $(this).next().empty();
        }
    );
    // end
});
//reload datatable ajax
function reload_table() {
    table.ajax.reload(null, false);
    $("#pilih_semua").prop("style", "display:none", true);
    $("#pilih_data").show();
    $("#batal_pilih").hide();
    $("#delete_all").hide();
}

// Get a file name when input file foto
function fileSelect1(e) {
    var fileName = e.target.files[0].name;
    $('[name="nama_file_foto"]').val(fileName);
    $('[name="nama_file_foto "]').next().empty();
}

// Get a file name when input file dimensi
function fileSelect2(e) {
    var fileName = e.target.files[0].name;
    $('[name="nama_file_dimensi"]').val(fileName);
    $('[name="nama_file_dimensi"]').val(fileName);
}

// import excel
function import_excel() {
    $("#form_import_excel")[0].reset();
    $("#importExcelModal").modal("show");
    $(".text-danger").empty();
    $(".modal-title").text("Import Excel");
}
// save excel
function save_excel() {
    $("#btn-import").text("Menyimpan..."); //change button text
    $("#btn-import").attr("disabled", true); //set button disable
    $.ajax({
        url: $("meta[name=app-url]").attr("content") +
            "admin/DrainaseController/import",
        type: "POST",
        data: new FormData($("#form_import_excel")[0]),
        cache: false,
        contentType: false,
        processData: false,
        dataType: "JSON",
        beforeSend: function() {
            swal({
                title: "Loading...",
                text: "Memproses data",
                showConfirmButton: false,
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading();
                },
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {}
            );
        },
        success: function(response) {
            if (response.status) {
                $("#importExcelModal").modal("hide");
                swal({
                    title: "Sukses!",
                    text: "Data berhasil disimpan!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
                //if success close modal and reload ajax table
                reload_table();
            } else if (response.status == null) {
                swal({
                    title: "Gagal!",
                    text: "Terdapat " + response.msg + " cell kosong!",
                    type: "error",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
                // swal.close();
            } else {
                $.each(response.error, function(key, value) {
                    $('[name="' + key + '"]')
                        .next()
                        .text(value);
                });
                swal.close();
            }
            $("#btn-import").text("Simpan"); //change button text
            $("#btn-import").attr("disabled", false); //set button enable
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
            $("#btn-import").text("Simpan"); //change button text
            $("#btn-import").attr("disabled", false); //set button enable
        },
    });
}
// add
function add_drainase() {
    if (window.matchMedia("(max-width: 767px)").matches) {
        $(".modal-dialog").removeAttr("style");
    }
    $('[name="id_drainase"]').val("");
    $("input, select,#refreshBtn").prop("disabled", false); // enable form
    $("#btnEdit").hide(); //hide button edit
    $("#modal_form").modal("show"); // show bootstrap modal
    $("#form")[0].reset(); // reset form on modals
    $(".text-danger").empty(); // clear error string
    $(".modal-title").text("Tambah Data"); // Set Title to Bootstrap modal title
    $("#btnSave").show(); // button save show
    $("#dimensi-preview").hide(); // hide dimensi preview modal
    $("#label-dimensi").text("Upload Dimensi"); // label foto upload
    $("#foto-preview").hide(); // hide foto preview modal
    $("#label-foto").text("Upload Foto"); // label foto upload
}

// Allow Edit
function allowEdit() {
    $("form input, select,#refreshBtn").prop("disabled", false); // enable form
    $("#btnSave").show(); //show button save
    $("#btnEdit").hide(); //hide button edit
    $(".modal-title").text("Edit Data"); // Set title to Bootstrap modal title
}

// edit
function edit_drainase(id) {
    if (window.matchMedia("(max-width: 767px)").matches) {
        $(".modal-dialog").removeAttr("style");
    }
    $("form[id='form'] input, select,#refreshBtn").prop("disabled", true);
    $("#btnSave").hide(); // button save hide
    $("#btnEdit").show(); // button edit show
    $("#form")[0].reset(); // reset form on modals
    $(".text-danger").empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url: $("meta[name=app-url]").attr("content") +
            "admin/DrainaseController/edit/" +
            id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_drainase"]').val(data.id_drainase);
            $('[name="id_jalan"]').val(data.id_jalan);
            $('[name="jalur_jalan"]').val(data.jalur_jalan);
            $('[name="lat_awal"]').val(data.lat_awal);
            $('[name="long_awal"]').val(data.long_awal);
            $('[name="lat_akhir"]').val(data.lat_akhir);
            $('[name="long_akhir"]').val(data.long_akhir);
            $('[name="sta"]').val(data.sta);
            $('[name="panjang"]').val(data.panjang);
            $('[name="tinggi"]').val(data.tinggi);
            $('[name="lebar"]').val(data.lebar);
            $('[name="slope"]').val(data.slope);
            $('[name="catchment_area"]').val(data.catchment_area);
            $('[name="luas_penampung"]').val(data.luas_penampung);
            $('[name="keliling_penampung"]').val(data.keliling_penampung);
            $('[name="tipe"]').val(data.tipe);
            $('[name="arah_air"]').val(data.arah_air);
            $('[name="id_kondisi_fisik"]').val(data.id_kondisi_fisik);
            $('[name="id_kondisi_sedimen"]').val(data.id_kondisi_sedimen);
            $('[name="id_penanganan"]').val(data.id_penanganan);
            $('[name="nama_file_dimensi"]').val(data.nama_file_dimensi);
            $('[name="nama_file_foto"]').val(data.nama_file_foto);
            $('[name="date"]').val(data.date);

            $("#modal_form").modal("show"); // show bootstrap modal when complete loaded
            $(".modal-title").text("Detail Data"); // Set title to Bootstrap modal title
            $("#foto-preview").show(); // show photo preview modal
            $("#dimensi-preview").show(); // show photo preview modal

            var dimensi;
            var foto;
            if (data.file_dimensi == "" || data.file_dimensi == "-") {
                dimensi =
                    $("meta[name=app-url]").attr("content") + "upload/noimage.jpg";
            } else {
                dimensi =
                    $("meta[name=app-url]").attr("content") +
                    "upload/dimensi/" +
                    data.file_dimensi;
            }
            if (data.file_foto == "" || data.file_foto == "-") {
                foto = $("meta[name=app-url]").attr("content") + "upload/noimage.jpg";
            } else {
                foto =
                    $("meta[name=app-url]").attr("content") +
                    "upload/foto/" +
                    data.file_foto;
            }
            if (data.file_dimensi) {
                $("#label-dimensi").text("Ganti Dimensi"); // label dimensi upload
                $("#dimensi-preview div").html(
                    '<img class="img-responsive img-thumbnail" src="' +
                    dimensi +
                    '" style="height:100px"><br>'
                );
                $("#dimensi-preview div").append(
                    '<input type="hidden" class="form-control" name="remove_dimensi" value="' +
                    data.file_dimensi +
                    '"/>'
                ); // remove dimensi
            } else {
                $("#label-dimensi").text("Upload Dimensi"); // label dimensi upload
            }
            if (data.file_foto) {
                $("#label-foto").text("Ganti Foto"); // label foto upload
                $("#foto-preview div").html(
                    '<img class="img-responsive img-thumbnail" src="' +
                    foto +
                    '" style="height:100px"><br>'
                );
                $("#foto-preview div").append(
                    '<input type="hidden" class="form-control"  name="remove_foto" value="' +
                    data.file_foto +
                    '"/>'
                ); // remove foto
            } else {
                $("#label-foto").text("Upload Foto"); // label foto upload
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
        },
    });
}

// save
function save() {
    $("#btnSave").text("Menyimpan..."); //change button text
    $("#btnSave").attr("disabled", true); //set button disable

    var formData = new FormData($("#form")[0]);
    // ajax adding data to database
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/DrainaseController/save",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $("#modal_form").modal("hide");
                swal({
                    title: "Sukses!",
                    text: "Data berhasil disimpan!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(
                    function() {},
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
                reload_table();
            } else {
                $.each(data.error, function(key, value) {
                    $('[name="' + key + '"]')
                        .next()
                        .text(value);
                });
            }
            $("#btnSave").text("Simpan"); //change button text
            $("#btnSave").attr("disabled", false); //set button enable
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
            $("#btnSave").text("Simpan"); //change button text
            $("#btnSave").attr("disabled", false); //set button enable
        },
    });
}

// delete
function delete_drainase(id) {
    swal({
        title: "Anda yakin?",
        text: "Data akan dihapus permanen!",
        type: "warning",
        showCancelButton: true,
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
        confirmButtonClass: "btn-del btn btn-danger",
        cancelButtonClass: "btn btn-default m-l-10",
        buttonsStyling: false,
    }).then(
        function() {
            $.ajax({
                url: $("meta[name=app-url]").attr("content") +
                    "admin/DrainaseController/delete/" +
                    id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    swal({
                        title: "Sukses!",
                        text: "Data berhasil dihapus!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === "timer") {}
                        }
                    );
                    //if success reload ajax table
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Gagal!",
                        text: "Proses gagal!",
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === "timer") {}
                        }
                    );
                },
            });
        },
        function(dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === "cancel") {
                if (dismiss === "timer") {}
            }
        }
    );
}

// trucate tabel
function truncate_table(params) {
    swal({
        title: "Anda yakin?",
        text: "Tabel akan dikosongkan!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4fa7f3",
        cancelButtonColor: "#d57171",
        showCancelButton: true,
        confirmButtonText: "Truncate",
        cancelButtonText: "Batal",
        confirmButtonClass: "btn btn-danger",
        cancelButtonClass: "btn btn-default m-l-10",
        buttonsStyling: false,
    }).then(
        function() {
            $.ajax({
                url: $("meta[name=app-url]").attr("content") +
                    "admin/DrainaseController/truncate",
                method: "POST",
                beforeSend: function() {
                    swal({
                        title: "Loading...",
                        text: "Memproses data",
                        showConfirmButton: false,
                        onOpen: () => {
                            swal.showLoading();
                        },
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {}
                    );
                },
                success: function() {
                    swal({
                        title: "Sukses!",
                        text: "Tabel berhasil dikosongkan!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === "timer") {}
                        }
                    );
                    //if success reload ajax table
                    reload_table();
                },
            });
        },
        function(dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === "cancel") {
                if (dismiss === "timer") {}
            }
        }
    );
}
// delete multiple
function delete_multi() {
    var checkbox = $(".select1:checked");
    swal({
        title: "Anda yakin?",
        text: "<b>" +
            $(".select1:checked").length +
            "</b>" +
            " Data akan dihapus permanen!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4fa7f3",
        cancelButtonColor: "#d57171",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
        confirmButtonClass: "btn btn-danger",
        cancelButtonClass: "btn btn-default m-l-10",
        buttonsStyling: false,
    }).then(
        function() {
            if (checkbox.length > 0) {
                var checkbox_value = [];
                checkbox.each(function() {
                    checkbox_value.push($(this).val());
                });
                $.ajax({
                    url: $("meta[name=app-url]").attr("content") +
                        "admin/DrainaseController/delete_multi",
                    method: "POST",
                    data: {
                        checkbox_value: checkbox_value,
                    },
                    beforeSend: function() {
                        swal({
                            title: "Loading...",
                            text: "Memproses data",
                            showConfirmButton: false,
                            onOpen: () => {
                                swal.showLoading();
                            },
                        }).then(
                            function() {},
                            // handling the promise rejection
                            function(dismiss) {}
                        );
                    },
                    success: function() {
                        swal({
                            title: "Sukses!",
                            text: "Data berhasil dihapus!",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(
                            function() {},
                            // handling the promise rejection
                            function(dismiss) {
                                if (dismiss === "timer") {}
                            }
                        );
                        //if success reload ajax table
                        $("#select-all").prop("checked", false);
                        reload_table();
                        $(".hapus-kabeh").hide();
                    },
                });
            } else {
                swal({
                    title: "Warning!",
                    text: "Tidak ada data yang dipilih!",
                    type: "info",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
            }
        },
        function(dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === "cancel") {
                if (dismiss === "timer") {}
            }
        }
    );
}

// leaflet draw
var mymap;
// map draw view
var osmUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    osmAttrib =
    '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    osm = L.tileLayer(osmUrl, {
        maxZoom: 19,
        attribution: osmAttrib,
    }),
    mymap = new L.Map("mymap", {
        zoomControl: false,
        center: new L.LatLng(-7.977014, 112.634056),
        zoom: 15,
    }),
    drawnItems = new L.featureGroup().addTo(mymap);

var zoomHome = L.Control.zoomHome({
    position: "topleft",
});

zoomHome.addTo(mymap);
L.control
    .layers({
        "Open Street Map": osm.addTo(mymap),
        "Google Satellite Map": L.tileLayer(
            "http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
                attribution: "google",
            }
        ),
    }, {
        drawlayer: drawnItems,
    }, {
        position: "topright",
        // collapsed: false
    })
    .addTo(mymap);

var polyline = [];
// draw control event
var drawControl = new L.Control.Draw({
    draw: {
        rectangle: false,
        circle: false,
        polygon: false,
        circlemarker: false,
        marker: false,
    },
    edit: {
        featureGroup: drawnItems,
        remove: true,
    },
});
mymap.addControl(drawControl);

$(".map-view").on("shown.bs.collapse", function() {
    $("#refreshBtn").html('<i class="fa fa-map-pin m-r-5"></i>Tutup Peta');
    mymap.invalidateSize();
    if ($("[name='id_drainase']").val() != "") {
        // form edit
        var latawal = $('[name="lat_awal"]').val();
        var longawal = $('[name="long_awal"]').val();
        var latakhir = $('[name="lat_akhir"]').val();
        var longakhir = $('[name="long_akhir"]').val();

        var pointAwal = new L.LatLng(latawal, longawal);
        var pointAkhir = new L.LatLng(latakhir, longakhir);
        var pointList = [pointAwal, pointAkhir];
        polyline = new L.Polyline(pointList, {
            color: "red",
            weight: 5,
            opacity: 0.5,
        }).addTo(drawnItems);
        mymap.fitBounds(polyline.getBounds());
    } else {
        //form add
        drawnItems.eachLayer(function(e) {
            drawnItems.removeLayer(e);
        });
    }
});

// draw created event
mymap.on("draw:created", function(e) {
    $('[name="lat_awal"]').next().empty();
    $('[name="long_awal"]').next().empty();
    $('[name="lat_akhir"]').next().empty();
    $('[name="long_akhir"]').next().empty();

    e.layer.options.color = "blue";
    e.layer.options.weight = 5;
    var type = e.layerType,
        layer = e.layer;
    var latLng = layer.getLatLngs();

    $('[name="lat_awal"]').val(latLng[0].lat);
    $('[name="long_awal"]').val(latLng[0].lng);
    $('[name="lat_akhir"]').val(latLng[1].lat);
    $('[name="long_akhir"]').val(latLng[1].lng);

    drawnItems.eachLayer(function(e) {
        drawnItems.removeLayer(e);
    });
    drawnItems.addLayer(layer);
});
// draw edited event
mymap.on("draw:edited", function(e) {
    var latLng = e.layers.getLayers()[0].getLatLngs();
    $('[name="lat_awal"]').val(latLng[0].lat);
    $('[name="long_awal"]').val(latLng[0].lng);
    $('[name="lat_akhir"]').val(latLng[1].lat);
    $('[name="long_akhir"]').val(latLng[1].lng);
});

// draw deleted event
mymap.on("draw:deleted", function(e) {
    var latLng = e.layers.getLayers()[0].getLatLngs();
    $('[name="lat_awal"]').val("");
    $('[name="long_awal"]').val("");
    $('[name="lat_akhir"]').val("");
    $('[name="long_akhir"]').val("");
});
// draw drawvertex event
mymap.on("draw:drawvertex", function(e) {
    const layerLength = Object.keys(e.layers._layers);
    if (layerLength.length > 1) {
        const secondVertex = e.layers._layers[layerLength[1]]._icon;
        requestAnimationFrame(() => secondVertex.click());
    }
});