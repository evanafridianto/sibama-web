<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="button-list m-b-5">
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="add_user();"><i
                        class="fa fa-plus m-r-5"></i> <span>Tambah
                        Data</span></button>
                <button type=" button" class="btn btn-custom waves-effect waves-light" onclick="reload_table();"><i
                        class="fa  fa-refresh m-r-5"></i> <span>Refresh Tabel</span></button>

                <button style="display: none;" type=" button"
                    class="btn btn-danger waves-effect waves-light hapus-kabeh" onclick="delete_all();"><i
                        class="fa fa-times m-r-5"></i> <span>Hapus</span></button>
            </div>
            <table id="table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Foto</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- profil modal  -->
<div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Form Data</h4>
            </div>
            <form action="#" id="form">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control " name="id" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama </label>
                                <input type="text" class="form-control" disabled="disabled" name="nama" required
                                    placeholder="Masukkan Nama ">
                                <span class=" form-text text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Username </label>
                                <input type="text" class="form-control" disabled="disabled" name="username" required
                                    placeholder="Masukkan Username ">
                                <span class=" form-text text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password </label>
                                <input type="password" class="form-control" disabled="disabled" name="password" required
                                    placeholder="Masukkan Password ">
                                <span class=" form-text text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Konfirmasi Password </label>
                                <input type="password" class="form-control" disabled="disabled" name="konfir_password"
                                    required placeholder="Masukkan Konfirmasi Password ">
                                <span class=" form-text text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Foto Profil</label>
                                <input type="file" class="form-control" disabled="disabled" name="photo"
                                    accept="image/*">
                                <span class=" form-text text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSave" onclick="save()"
                            class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <button type="button" id="btnEdit" class="btn btn-custom waves-effect waves-light"
                            onclick="allowEdit();">Edit
                            Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->

<script type="text/javascript">
//for save method string
var save_method;
var table;
$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/user/show_all",
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
function add_user() {
    save_method = 'add';
    $('#modal_form').modal('show'); // show bootstrap modal
    $('#form')[0].reset(); // reset form on modals
    $('.form-text').empty(); // clear error string
    $('[name="id"]').val("");
    $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
    $('.form-control').prop("disabled", false); // enable form 
    $('#btnEdit').hide(); //hide button edit 
    $('#btnSave').show(); //show button save 
}

// Allow Edit
function allowEdit() {
    $('.form-control').prop("disabled", false); // enable form 
    $('#btnSave').show(); //show button save 
    $('#btnEdit').hide(); //hide button edit 
    $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title
}

// // edit
// function edit_user(id) {
//     save_method = 'update';
//     $('#form')[0].reset(); // reset form on modals
//     $('.form-text').empty(); // clear error string
//     $('#btnSave').hide(); // button save hide
//     $('#btnEdit').show(); //show button edit 
//     $('.form-control').prop("disabled", true); // disabled form 
//     //Ajax Load data from ajax
//     $.ajax({
//         url: $('meta[name=app-url]').attr("content") + "admin/user/edit/" + id,
//         type: "GET",
//         dataType: "JSON",
//         success: function(data) {
//             $('[name="id"]').val(data.id_user);
//             $('[name="nama"]').val(data.nama);
//             $('[name="username"]').val(data.username);
//             $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
//             $('.modal-title').text('Detail Data'); // Set title to Bootstrap modal title
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             swal({
//                 title: "Gagal!",
//                 text: "Proses gagal!",
//                 type: "error",
//                 showConfirmButton: false,
//                 timer: 1500,
//             }).then(
//                 function() {},
//                 // handling the promise rejection
//                 function(dismiss) {
//                     if (dismiss === "timer") {}
//                 }
//             );
//         }
//     });
// }

// save
function save() {
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;

    if (save_method == 'add') {
        url = $('meta[name=app-url]').attr("content") + "admin/user/add";
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
                $('#modal_form').modal('hide');
                swal({
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan!',
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
                reload_table();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[
                        i]); //select span form-text class set text error string
                }
                console.log(data);
            }
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 
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
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 

        }
    });
}
// delete 
function delete_user(id) {
    swal({
        title: 'Anda yakin?',
        text: "Data akan dihapus permanen!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4fa7f3',
        cancelButtonColor: '#d57171',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        confirmButtonClass: 'btn btn-danger',
        cancelButtonClass: 'btn btn-default m-l-10',
        buttonsStyling: false
    }).then(function() {
        $.ajax({
            url: $('meta[name=app-url]').attr("content") + "admin/user/delete/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                swal({
                    title: 'Sukses!',
                    text: 'Data berhasil dihapus!',
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
                //if success reload ajax table
                reload_table();
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
    }, function(dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {

            if (dismiss === 'timer') {}
        }
    })
}
</script>