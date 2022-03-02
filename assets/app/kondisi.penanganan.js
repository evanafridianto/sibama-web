//for save method string
var table1;
var table2;
var table3;
$(document).ready(function() {
    //datatable1s
    table1 = $("#table_kondisi_fisik").DataTable({
        processing: true,
        order: [],
        autoWidth: false,
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kondisipenanganandrainasecontroller/show_all/kondisi_fisik",
            type: "GET",
        },
    });
    table2 = $("#table_kondisi_sedimen").DataTable({
        processing: true,
        order: [],
        autoWidth: false,
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kondisipenanganandrainasecontroller/show_all/kondisi_sedimen",
            type: "GET",
        },
    });
    table3 = $("#table_penanganan").DataTable({
        processing: true,
        order: [],
        autoWidth: false,
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/kondisipenanganandrainasecontroller/show_all/penanganan",
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
    if (table == "kondisi_fisik") {
        table1.ajax.reload(null, false);
    } else if (table == "kondisi_sedimen") {
        table2.ajax.reload(null, false);
    } else if (table == "penanganan") {
        table3.ajax.reload(null, false);
    }
}

// add
function add_data(table) {
    $(".text-danger").empty(); // clear error string
    $(".modal-title").text("Tambah Data"); // Set Title to Bootstrap modal title
    $(".form-control").prop("disabled", false); // enable form
    $("#btnEdit").hide(); //hide button edit
    $("#btnSave").show(); // button save hide
    $("#modal_kategori").modal("show"); // show bootstrap modal
    $("#kategori_form")[0].reset(); // reset form on modals
    $('[name="id"]').val("");

    if (table == "kondisi_fisik") {
        $("#label_kategori").text("Nama Kondisi Fisik");
        $('[name="nama"]').attr("placeholder", "Masukkan Nama Kondisi Fisik");
        $('[name="btnSave"]').attr("onclick", "save('kondisi_fisik')");
    } else if (table == "kondisi_sedimen") {
        $("#label_kategori").text("Nama Kondisi Sedimen");
        $('[name="nama"]').attr("placeholder", "Masukkan Nama Kondisi Sedimen");
        $('[name="btnSave"]').attr("onclick", "save('kondisi_sedimen')");
    } else {
        $("#label_kategori").text("Nama Penanganan");
        $('[name="nama"]').attr("placeholder", "Masukkan Nama Penanganan");
        $('[name="btnSave"]').attr("onclick", "save('penanganan')");
    }
}

// Allow Edit
function allowEdit() {
    $("form input").prop("disabled", false); // enable form
    $("#btnSave").show(); //show button save
    $("#btnEdit").hide(); //hide button edit
    $(".modal-title").text("Edit Data"); // Set title to Bootstrap modal title
}

// edit
function edit_data(table, id) {
    $("#kategori_form")[0].reset(); // reset form on modals
    $(".text-danger").empty(); // clear error string
    $("#btnSave").hide(); // button save hide
    $("#btnEdit").show(); //show button edit
    $("form input").prop("disabled", true);
    //Ajax Load data from ajax
    var url;
    if (table == "kondisi_fisik") {
        $("#label_kategori").text("Nama Kondisi Fisik");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/edit/kondisi_fisik/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('kondisi_fisik')");
    } else if (table == "kondisi_sedimen") {
        $("#label_kategori").text("Nama Kondisi Sedimen");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/edit/kondisi_sedimen/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('kondisi_sedimen')");
    } else {
        $("#label_kategori").text("Nama Penanganan");
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/edit/penanganan/" +
            id;
        $('[name="btnSave"]').attr("onclick", "save('penanganan')");
    }
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            if (table == "kondisi_fisik") {
                $('[name="id"]').val(data.id_kondisi_fisik);
                $('[name="nama"]').val(data.nama_kondisi_fisik);
            } else if (table == "kondisi_sedimen") {
                $('[name="id"]').val(data.id_kondisi_sedimen);
                $('[name="nama"]').val(data.nama_kondisi_sedimen);
            } else {
                $('[name="id"]').val(data.id_penanganan);
                $('[name="nama"]').val(data.nama_penanganan);
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
    if (table == "kondisi_fisik") {
        reload = "kondisi_fisik";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/save/kondisi_fisik";
    } else if (table == "kondisi_sedimen") {
        reload = "kondisi_sedimen";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/save/kondisi_sedimen";
    } else {
        reload = "penanganan";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/save/penanganan";
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
                $.each(data.error, function(key, value) {
                    $('[name="' + key + '"]')
                        .next()
                        .text(value);
                });
            }
            $("#btnSave").text("Simpan"); //change button text
            $("#btnSave").attr("disabled", false); //set button enable
        },
        error: function(response) {
            console.log(response);
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
function delete_data(table, id) {
    var url;
    var reload;
    if (table == "kondisi_fisik") {
        reload = "kondisi_fisik";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/delete/kondisi_fisik/" +
            id;
    } else if (table == "kondisi_sedimen") {
        reload = "kondisi_sedimen";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/delete/kondisi_sedimen/" +
            id;
    } else {
        reload = "penanganan";
        url =
            $("meta[name=app-url]").attr("content") +
            "admin/kondisipenanganandrainasecontroller/delete/penanganan/" +
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