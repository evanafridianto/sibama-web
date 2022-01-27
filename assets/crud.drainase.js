// for save method string
var save_method;
// table global var
var table;
$(document).ready(function() {
    //datatables
    table = $("#table").DataTable({
        order: [], //Initial no order.
        processing: true,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") + "admin/drainase/show_all",
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

    // jalan option
    $('[name="id_jalan"]').append('<option value="">--Pilih Jalan--</option>');
    $.each(dataJalan, function(x, item) {
        $('[name="id_jalan"]').append(
            $("<option></option>", {
                value: item.id_jalan,
                text: item.nama_jalan +
                    ", " +
                    item.nama_kelurahan +
                    ", " +
                    item.nama_kecamatan,
            })
        );
    });

    // datepicker
    $(".datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd",
        language: "id",
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

    // select2
    $(".select2-container").select2({
        dropdownParent: $("#modal_form"),
    });

    // if modal hidden
    $("#modal_form").on("hidden.bs.modal", function() {
        $("#collapseOne").collapse("hide"); // collapse hide
        $(".edit-data").prop("disabled", true); //form disabled
    });

    // if map collapse hidden
    $(".map-view").on("hidden.bs.collapse", function() {
        $("#refreshBtn").html(
            '<i class="fa fa-map-pin m-r-5"></i>Pilih Titik Koordinat'
        ); // button view, text changes
    });

    // set input / select event when change value, remove text text - danger
    $("input[type=text]").change(function() {
        $(this).next().empty();
    });

    $("input[type=file]").change(function() {
        $(this).next().empty();
    });

    $("select.edit-data").change(function() {
        $(this).next().empty();
    });
    $("select.select2-container").change(function() {
        $(".id_jalan-err").empty();
    });
    // end
});

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
// add
function add_drainase() {
    if (window.matchMedia("(max-width: 767px)").matches) {
        $(".modal-dialog").removeAttr("style");
    }
    save_method = "add"; //save method = add
    $(".edit-data").prop("disabled", false); // enable form
    $(".select2-container").prop("disabled", false); // enable form
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
    $(".edit-data").prop("disabled", false); // enable form
    $(".select2-container").prop("disabled", false); // enable form
    $("#btnSave").show(); //show button save
    $("#btnEdit").hide(); //hide button edit
    $(".modal-title").text("Edit Data"); // Set title to Bootstrap modal title
}

// edit
function edit_drainase(id) {
    if (window.matchMedia("(max-width: 767px)").matches) {
        $(".modal-dialog").removeAttr("style");
    }
    save_method = "update"; //save method = update
    $("#btnSave").hide(); // button save hide
    $("#btnEdit").show(); // button edit show
    $(".edit-data").prop("disabled", true); // disabled form
    $(".select2-container").prop("disabled", true); // select jalan disabled
    $("#form")[0].reset(); // reset form on modals
    $(".text-danger").empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/drainase/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id"]').val(data.id);
            $('[name="id_jalan"]').val(data.id_jalan).trigger("change");
            $('[name="sta"]').val(data.sta);
            $('[name="lat_awal"]').val(data.lat_awal);
            $('[name="long_awal"]').val(data.long_awal);
            $('[name="lat_akhir"]').val(data.lat_akhir);
            $('[name="long_akhir"]').val(data.long_akhir);
            $('[name="panjang_saluran"]').val(data.panjang_saluran);
            $('[name="slope"]').val(data.slope);
            $('[name="catchment_area"]').val(data.catchment_area);
            $('[name="tinggi_saluran"]').val(data.tinggi_saluran);
            $('[name="lebar_saluran"]').val(data.lebar_saluran);
            $('[name="luas_penampung"]').val(data.luas_penampung);
            $('[name="keliling_penampung"]').val(data.keliling_penampung);
            $('[name="nama_file_dimensi"]').val(data.nama_file_dimensi);
            $('[name="nama_file_foto"]').val(data.nama_file_foto);
            $('[name="id_arah_aliran"]').val(data.id_arah_aliran);
            $('[name="id_kondisi_fisik"]').val(data.id_kondisi_fisik);
            $('[name="id_kondisi_sedimen"]').val(data.id_kondisi_sedimen);
            $('[name="id_tipe_saluran"]').val(data.id_tipe_saluran);
            $('[name="id_penanganan"]').val(data.id_penanganan);
            $('[name="id_lajur_drainase"]').val(data.id_lajur_drainase);
            $('[name="date"]').val(data.date);
            $("#modal_form").modal("show"); // show bootstrap modal when complete loaded
            $(".modal-title").text("Detail Data"); // Set title to Bootstrap modal title

            $("#foto-preview").show(); // show photo preview modal
            $("#dimensi-preview").show(); // show photo preview modal
            var dimensi =
                $("meta[name=app-url]").attr("content") +
                "upload/dimensi/" +
                data.file_dimensi;
            var foto =
                $("meta[name=app-url]").attr("content") +
                "upload/foto/" +
                data.file_foto;

            if (data.file_dimensi) {
                $("#label-dimensi").text("Change Dimensi"); // label dimensi upload
                $("#dimensi-preview div").html(
                    '<img class="img-responsive img-thumbnail" src="' +
                    dimensi +
                    '" style="height:100px"><br>'
                );
                $("#dimensi-preview div").append(
                    '<input type="checkbox" class="form-check-input edit-data" disabled="disabled" name="remove_dimensi" value="' +
                    data.file_dimensi +
                    '"/> Remove file when saving'
                ); // remove dimensi
            } else {
                $("#label-dimensi").text("Upload Dimensi"); // label dimensi upload
            }
            if (data.file_foto) {
                $("#label-foto").text("Change Foto"); // label foto upload
                $("#foto-preview div").html(
                    '<img class="img-responsive img-thumbnail" src="' +
                    foto +
                    '" style="height:100px"><br>'
                );
                $("#foto-preview div").append(
                    '<input type="checkbox" class="form-check-input edit-data" disabled="disabled" name="remove_foto" value="' +
                    data.file_foto +
                    '"/> Remove file when saving'
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

//reload datatable ajax
function reload_table() {
    table.ajax.reload(null, false);
    $("#pilih_semua").prop("style", "display:none", true);
    $("#pilih_data").show();
    $("#batal_pilih").hide();
    $("#delete_all").hide();
}

// import excel
function import_excel() {
    $("#form_import_excel")[0].reset();
    $("#importExcelModal").modal("show");
    $(".text-danger").empty();
    $(".modal-title").text("Import Excel");
}
// save csv
function save_excel() {
    $("#btn-import").text("Menyimpan..."); //change button text
    $("#btn-import").attr("disabled", true); //set button disable
    // var formData = new FormData($("#form_import")[0]);
    $.ajax({
        // url: $("meta[name=app-url]").attr("content") + "admin/drainase/import_csv",
        url: $("meta[name=app-url]").attr("content") + "admin/drainase/import",
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
                for (var i = 0; i < response.inputerror.length; i++) {
                    $('[name="' + response.inputerror[i] + '"]')
                        .next()
                        .text(response.error_string[i]); //select span text-danger class set text error string
                }
                swal.close();
            }
            $("#btn-import").text("Simpan"); //change button text
            $("#btn-import").attr("disabled", false); //set button enable
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
            $("#btn-import").text("Simpan"); //change button text
            $("#btn-import").attr("disabled", false); //set button enable
        },
    });
}

// save
function save() {
    $("#btnSave").text("Menyimpan..."); //change button text
    $("#btnSave").attr("disabled", true); //set button disable
    var url;

    if (save_method == "add") {
        url = $("meta[name=app-url]").attr("content") + "admin/drainase/add";
    } else {
        url = $("meta[name=app-url]").attr("content") + "admin/drainase/update";
    }
    var formData = new FormData($("#form")[0]);
    // ajax adding data to database
    $.ajax({
        url: url,
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
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
                //if success close modal and reload ajax table
                reload_table();
                // name="id_jalan"
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    if (data.inputerror[i] == "id_jalan") {
                        $(".id_jalan-err").text(data.error_string[i]);
                    } else {
                        $('[name="' + data.inputerror[i] + '"]')
                            .next()
                            .text(data.error_string[i]); //select span text-danger class set text error string
                    }
                }
            }
            $("#btnSave").text("Simpan"); //change button text
            $("#btnSave").attr("disabled", false); //set button enable
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
            $.ajax({
                url: $("meta[name=app-url]").attr("content") +
                    "admin/drainase/delete/" +
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
                url: $("meta[name=app-url]").attr("content") + "admin/drainase/truncate",
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
// delete all
function delete_all() {
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
                        "admin/drainase/delete_all",
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
    if ($("[name='id']").val() != "") {
        // form edit
        mymap.invalidateSize();
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
        mymap.invalidateSize();
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