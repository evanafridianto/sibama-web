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
            url: $("meta[name=app-url]").attr("content") + "admin/kecamatan/show_all",
            type: "GET",
        },
    });

    //set input/select event when change value, remove class error and remove text text-danger
    $("input").keyup(function(e) {
        e.preventDefault();
        $(this).next().empty();
    });
});
//reload datatable ajax
function reload_table() {
    table.ajax.reload(null, false);
}
// add
function add_kecamatan() {
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
function edit_kecamatan(id) {
    save_method = "update";
    $("#form")[0].reset(); // reset form on modals
    $(".form-text").empty(); // clear error string
    $("#btnSave").hide(); // button save hide
    $("#btnEdit").show(); //show button edit
    $(".form-control").prop("disabled", true); // disabled form
    //Ajax Load data from ajax
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/kecamatan/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id"]').val(data.id_kecamatan);
            $('[name="nama_kecamatan"]').val(data.nama_kecamatan);
            $('[name="file_geojson"]').val(data.file_geojson);
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
        url = $("meta[name=app-url]").attr("content") + "admin/kecamatan/add";
    } else {
        url = $("meta[name=app-url]").attr("content") + "admin/kecamatan/update";
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
function delete_kecamatan(id) {
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
                    "admin/kecamatan/delete/" +
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