var table;
$(function() {
    //datatables
    table = $("#table").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/r24controller/show_all",
            type: "GET",
        },
    });

    //set input/select event when change value, remove class error and remove text text-danger
    $("input").keyup(function() {
        $(this).next().empty();
    });

    $("select").change(function() {
        $(this).next().empty();
    });

    // datepicker
    $(".datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy",
        language: "id",
    });
});

// add
function add_r24() {
    $("#modal_form").modal("show"); // show bootstrap modal
    $("#form")[0].reset(); // reset form on modals
    $(".form-text").empty(); // clear error string
    $("#id_kelurahan").val("");
    $('[name="id_r24"]').val("");
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
function edit_r24(id) {
    $("#form")[0].reset(); // reset form on modals
    $(".form-text").empty(); // clear error string
    $("#btnSave").hide(); // button save hide
    $("#btnEdit").show(); //show button edit
    $(".form-control").prop("disabled", true); // disabled form
    //Ajax Load data from ajax
    $.ajax({
        url: $("meta[name=app-url]").attr("content") +
            "admin/r24controller/edit/" +
            id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_r24"]').val(data.id_r24);
            $('[name="id_kecamatan"]').val(data.id_kecamatan);
            $('[name="r24"]').val(data.r24);
            $('[name="tahun"]').val(data.tahun);

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
//reload datatable ajax
function reload_table() {
    table.ajax.reload(null, false);
}
// save
function save() {
    $("#btnSave").text("Menyimpan..."); //change button text
    $("#btnSave").attr("disabled", true); //set button disable
    // ajax adding data to database
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/r24controller/save",
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
function delete_r24(id) {
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
                    "admin/r24controller/delete/" +
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