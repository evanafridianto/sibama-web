//for save method string
var save_method;
var table1;
var table2;
var table3;
var table4;
var table5;
var table6;
$(document).ready(function() {
    //datatable1s
    table1 = $("#table_tipe_saluran").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kategori/show_all/tipe_saluran",
            type: "GET",
        },
    });
    table2 = $("#table_arah_aliran").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kategori/show_all/arah_aliran",
            type: "GET",
        },
    });
    // //set input/select event when change value, remove class error and remove text text-danger
    table3 = $("#table_kondisi_fisik").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kategori/show_all/kondisi_fisik",
            type: "GET",
        },
    });
    table4 = $("#table_kondisi_sedimen").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kategori/show_all/kondisi_sedimen",
            type: "GET",
        },
    });
    table5 = $("#table_penanganan").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kategori/show_all/penanganan",
            type: "GET",
        },
    });
    table6 = $("#table_lajur_drainase").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kategori/show_all/lajur_drainase",
            type: "GET",
        },
    });
    // //set input/select event when change value, remove class error and remove text text-danger
    $("input").keyup(function(e) {
        $(this).next().empty();
    });
});

//reload datatable ajax
function reload_table(table) {
    if (table == "tipe_saluran") {
        table1.ajax.reload(null, false);
    } else if (table == "arah_aliran") {
        table2.ajax.reload(null, false);
    } else if (table == "kondisi_fisik") {
        table3.ajax.reload(null, false);
    } else if (table == "kondisi_sedimen") {
        table4.ajax.reload(null, false);
    } else if (table == "penanganan") {
        table5.ajax.reload(null, false);
    } else if ((table = "lajur_drainase")) {
        table6.ajax.reload(null, false);
    }
}

// add
function add_kategori(table) {
    save_method = "add";
    $(".text-danger").empty(); // clear error string
    $(".modal-title").text("Tambah Data"); // Set Title to Bootstrap modal title
    $(".form-control").prop("disabled", false); // enable form
    $("#btnEdit").hide(); //hide button edit
    $("#btnSave").show(); // button save hide

    $("#modal_kategori").modal("show"); // show bootstrap modal
    $("#kategori_form")[0].reset(); // reset form on modals
    $('[name="id_kategori"]').val("");

    if (table == "tipe_saluran") {
        $("#label_kategori").text("Tipe Saluran");
        $('[name="nama_kategori"]').attr("placeholder", "Masukkan Tipe Saluran");
        $('[name="btnSave"]').attr("onclick", "save('tipe_saluran')");
    } else if (table == "arah_aliran") {
        $("#label_kategori").text("Arah Aliran");
        $('[name="nama_kategori"]').attr("placeholder", "Masukkan Arah Aliran");
        $('[name="btnSave"]').attr("onclick", "save('arah_aliran')");
    } else if (table == "kondisi_fisik") {
        $("#label_kategori").text("Kondisi Fisik");
        $('[name="nama_kategori"]').attr("placeholder", "Masukkan Kondisi Fisik");
        $('[name="btnSave"]').attr("onclick", "save('kondisi_fisik')");
    } else if (table == "penanganan") {
        $("#label_kategori").text("Penanganan");
        $('[name="nama_kategori"]').attr("placeholder", "Masukkan Penanganan");
        $('[name="btnSave"]').attr("onclick", "save('penanganan')");
    } else if (table == "kondisi_sedimen") {
        $("#label_kategori").text("Kondisi Sedimen");
        $('[name="nama_kategori"]').attr("placeholder", "Masukkan Kondisi Sedimen");
        $('[name="btnSave"]').attr("onclick", "save('kondisi_sedimen')");
    } else {
        $("#label_kategori").text("Lajur Drainase");
        $('[name="nama_kategori"]').attr("placeholder", "Masukkan Lajur Drainase");
        $('[name="btnSave"]').attr("onclick", "save('lajur_drainase')");
    }
}

// Allow Edit
function allowEdit() {
    $(".form-control").prop("disabled", false); // enable form
    $("#btnSave").show(); //show button save
    $("#btnEdit").hide(); //hide button edit
    $(".modal-title").text("Edit Data"); // Set title to Bootstrap modal title
}

// edit
function edit_kategori(table, id) {
    save_method = "update";
    $("#kategori_form")[0].reset(); // reset form on modals
    $(".text-danger").empty(); // clear error string
    $("#btnSave").hide(); // button save hide
    $("#btnEdit").show(); //show button edit
    $(".form-control").prop("disabled", true); // disabled form
    //Ajax Load data from ajax
    var url;
    if (table == "tipe_saluran") {
        $("#label_kategori").text("Tipe Saluran");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/edit/tipe_saluran/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('tipe_saluran')");
    } else if (table == "arah_aliran") {
        $("#label_kategori").text("Arah Aliran");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/edit/arah_aliran/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('arah_aliran')");
    } else if (table == "kondisi_fisik") {
        $("#label_kategori").text("Kondisi Fisik");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/edit/kondisi_fisik/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('kondisi_fisik')");
    } else if (table == "penanganan") {
        $("#label_kategori").text("Penanganan");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/edit/penanganan/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('penanganan')");
    } else if (table == "kondisi_sedimen") {
        $("#label_kategori").text("Kondisi Sedimen");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/edit/kondisi_sedimen/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('kondisi_sedimen')");
    } else {
        $("#label_kategori").text("Lajur Drainase");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/edit/lajur_drainase/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('lajur_drainase')");
    }
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            if (table == "tipe_saluran") {
                $('[name="id_kategori"]').val(data.id_tipe_saluran);
                $('[name="nama_kategori"]').val(data.tipe_saluran);
            } else if (table == "arah_aliran") {
                $('[name="id_kategori"]').val(data.id_arah_aliran);
                $('[name="nama_kategori"]').val(data.arah_aliran);
            } else if (table == "kondisi_fisik") {
                $('[name="id_kategori"]').val(data.id_kondisi_fisik);
                $('[name="nama_kategori"]').val(data.kondisi_fisik);
            } else if (table == "penanganan") {
                $('[name="id_kategori"]').val(data.id_penanganan);
                $('[name="nama_kategori"]').val(data.penanganan);
            } else if (table == "kondisi_sedimen") {
                $('[name="id_kategori"]').val(data.id_kondisi_sedimen);
                $('[name="nama_kategori"]').val(data.kondisi_sedimen);
            } else {
                $('[name="id_kategori"]').val(data.id_lajur_drainase);
                $('[name="nama_kategori"]').val(data.lajur_drainase);
            }

            $("#modal_kategori").modal("show"); // show bootstrap modal when complete loaded
            $(".modal-title").text("Detail Data"); // Set title to Bootstrap modal title
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
function save(table) {
    $("#btnSave").text("Menyimpan..."); //change button text
    $("#btnSave").attr("disabled", true); //set button disable
    var url;
    var reload;
    if (table == "tipe_saluran") {
        reload = "tipe_saluran";
        if (save_method == "add") {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/add/tipe_saluran";
        } else {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/update/tipe_saluran";
        }
    } else if (table == "arah_aliran") {
        reload = "arah_aliran";
        if (save_method == "add") {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/add/arah_aliran";
        } else {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/update/arah_aliran";
        }
    } else if (table == "kondisi_fisik") {
        reload = "kondisi_fisik";
        if (save_method == "add") {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/add/kondisi_fisik";
        } else {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/update/kondisi_fisik";
        }
    } else if (table == "penanganan") {
        reload = "penanganan";
        if (save_method == "add") {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/add/penanganan";
        } else {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/update/penanganan";
        }
    } else if (table == "kondisi_sedimen") {
        reload = "kondisi_sedimen";
        if (save_method == "add") {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/add/kondisi_sedimen";
        } else {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/update/kondisi_sedimen";
        }
    } else {
        reload = "lajur_drainase";
        if (save_method == "add") {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/add/lajur_drainase";
        } else {
            url =
                $("meta[name=app-url]").attr("content") +
                "admin/kategori/update/lajur_drainase";
        }
    }
    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: $("#kategori_form").serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $("#modal_kategori").modal("hide");
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
                reload_table(reload);
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]')
                        .next()
                        .text(data.error_string[i]); //select span text-danger class set text error string
                }
            }
            $("#btnSave").text("Simpan"); //change button text
            $("#btnSave").attr("disabled", false); //set button enable
        },
        error: function(response) {
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
function delete_kategori(table, id) {
    var url;
    var reload;
    if (table == "tipe_saluran") {
        reload = "tipe_saluran";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/delete/tipe_saluran/" +
            id;
    } else if (table == "arah_aliran") {
        reload = "arah_aliran";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/delete/arah_aliran/" +
            id;
    } else if (table == "kondisi_fisik") {
        reload = "kondisi_fisik";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/delete/kondisi_fisik/" +
            id;
    } else if (table == "penanganan") {
        reload = "penanganan";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/delete/penanganan/" +
            id;
    } else if (table == "kondisi_sedimen") {
        reload = "kondisi_sedimen";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/delete/kondisi_sedimen/" +
            id;
    } else {
        reload = "lajur_drainase";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kategori/delete/lajur_drainase/" +
            id;
    }
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
                url: url,
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
                    reload_table(reload);
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