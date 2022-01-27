//for save method string
var save_method;
var table;
$(document).ready(function() {
    //datatables
    table = $("#table").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") + "admin/kelurahan/show_all",
            type: "GET",
        },
    });

    //set input/select event when change value, remove class error and remove text text-danger
    $("input").keyup(function(e) {
        e.preventDefault();
        $(this).next().empty();
    });
    $("select").change(function(e) {
        e.preventDefault();
        $(this).next().empty();
    });
});
//reload datatable ajax
function reload_table() {
    table.ajax.reload(null, false);
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
        url: $("meta[name=app-url]").attr("content") + "admin/kelurahan/import",
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
// add
function add_kelurahan() {
    save_method = "add";
    $("#modal_form").modal("show"); // show bootstrap modal
    $("#form")[0].reset(); // reset form on modals
    $(".form-text").empty(); // clear error string
    $('[name="id"]').val("");
    $(".modal-title").text("Tambah Data"); // Set Title to Bootstrap modal title
    $(".form-control").prop("disabled", false); // enable form
    $("#btnEdit").hide(); //hide button edit
}

// Allow Edit
function allowEdit() {
    $(".form-control").prop("disabled", false); // enable form
    $("#btnSave").show(); //show button save
    $("#btnEdit").hide(); //hide button edit
    $(".modal-title").text("Edit Data"); // Set title to Bootstrap modal title
}

// edit
function edit_kelurahan(id) {
    save_method = "update";
    $("#form")[0].reset(); // reset form on modals
    $(".form-text").empty(); // clear error string
    $("#btnSave").hide(); // button save hide
    $("#btnEdit").show(); //show button edit
    $(".form-control").prop("disabled", true); // disabled form
    //Ajax Load data from ajax
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/kelurahan/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id"]').val(data.id_kelurahan);
            $('[name="nama_kelurahan"]').val(data.nama_kelurahan);
            $('[name="id_kecamatan"]').val(data.id_kecamatan);
            $("#modal_form").modal("show"); // show bootstrap modal when complete loaded
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
function save() {
    $("#btnSave").text("Menyimpan..."); //change button text
    $("#btnSave").attr("disabled", true); //set button disable
    var url;

    if (save_method == "add") {
        url = $("meta[name=app-url]").attr("content") + "admin/kelurahan/add";
    } else {
        url = $("meta[name=app-url]").attr("content") + "admin/kelurahan/update";
    }
    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: $("#form").serialize(),
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
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]')
                        .next()
                        .text(data.error_string[i]); //select span form-text class set text error string
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
function delete_kelurahan(id) {
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
                    "admin/kelurahan/delete/" +
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
                url: $("meta[name=app-url]").attr("content") + "admin/kelurahan/truncate",
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