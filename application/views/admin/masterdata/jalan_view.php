<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"> <?= $page_title; ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= site_url('beranda') ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <?= $page_title; ?>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <button class="btn btn-primary" data-toggle="modal" onclick="add_jalan();">
                        <span class="btn-label">
                            <i class="fas fa-plus"></i>
                        </span>
                        Tambah Data
                    </button>
                    <button class="btn btn-secondary" onclick="reload_table();">
                        <span class="btn-label">
                            <i class="fas fa-sync-alt"></i>
                        </span>
                        Reload
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Jalan</th>
                                    <th>Kelurahan</th>
                                    <th>Kecamatan</th>
                                    <th style="text-align: center">
                                        <i class="fas fa-user-cog"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Modal form data -->
<div id="modal_form" class="modal fade bd-example-modal-lg" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Form Data</h3>
            </div>
            <div class="modal-body">
                <form action="#" id="form">
                    <div class="row">
                        <input type="hidden" class="form-control" name="get_idkelurahan" id="get_idkelurahan">
                        <input type="hidden" class="form-control " name="id" />
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label>Nama Jalan</label>
                                <input type="text" class="form-control" name="nama_jalan" required
                                    placeholder="Masukkan Nama Jalan">
                                <small class="form-text text-danger"></small>
                            </div><!-- /grid column -->
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select name="id_kecamatan" id="id_kecamatan" class="form-control">
                                    <option value="">--Pilih Kecamatan--</option>
                                    <?php foreach($data_kecamatan as $row):?>
                                    <option value="<?= $row['id_kecamatan']; ?>">
                                        <?= $row['nama_kecamatan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-text text-danger"></small>
                            </div><!-- /grid column -->
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Kelurahan</label>
                                <select name="id_kelurahan" id="id_kelurahan" class="form-control">
                                    <option value="">--Pilih Kelurahan--</option>

                                </select>
                                <small class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div><!-- /.form-row -->
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" id="btnSave" onclick="save()">
                            <span class="btn-label"></span>
                            Simpan
                        </button>
                        <button class="btn btn-danger" data-dismiss="modal">
                            <span class="btn-label"></span>
                            Batal
                        </button>
                    </div>
                </form><!-- /form .needs-validation -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
//for save method string
var save_method;
var table;
$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
        "autoWidth": false,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": $('meta[name=app-url]').attr("content") + "admin/jalan/show_all",
            "type": "GET"
        },
    });

    //set input/select event when change value, remove class error and remove text text-danger 
    $("input").change(function() {
        $(this).next().empty();
    });

    $("select").change(function() {
        $(this).next().empty();
    });

});
// chained kecamatan => kelurahan
$('#id_kecamatan').change(function() {
    var id_kecamatan = $(this).val();
    var id_kelurahan = $('#get_idkelurahan').val();
    $.ajax({
        type: "POST",
        url: $('meta[name=app-url]').attr("content") + "admin/jalan/get_kelurahan",
        data: {
            id: id_kecamatan,
        },
        async: true,
        dataType: "JSON",
        success: function(data) {
            $('[name="id_kelurahan"]').empty();
            $('[name="id_kelurahan"]').append(
                '<option value="">--Pilih Kelurahan--</option>');
            $.each(data, function(key, value) {
                if (id_kelurahan == value.id_kelurahan) { //update selected
                    $('[name="id_kelurahan"]').append(
                        '<option value="' + value.id_kelurahan +
                        '" selected>' + value.nama_kelurahan +
                        '</option>'
                    ).trigger('change');
                } else {
                    $('[name="id_kelurahan"]').append( //create new
                        '<option value="' + value.id_kelurahan + '">' +
                        value.nama_kelurahan + '</option>');
                }
            });
        }
    });
    return false;
});
// add
function add_jalan() {
    save_method = 'add';
    $('#modal_form').modal('show'); // show bootstrap modal
    $('#form')[0].reset(); // reset form on modals
    $('.form-text').empty(); // clear error string
    $("#id_kelurahan").val("");
    $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
}
// edit
function edit_jalan(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-text').empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url: $('meta[name=app-url]').attr("content") + "admin/jalan/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="get_idkelurahan"]').val(data.id_kelurahan);
            $('[name="id"]').val(data.id_jalan);
            $('[name="nama_jalan"]').val(data.nama_jalan);
            $('[name="id_kelurahan"]').val(data.id_kelurahan).trigger('change');
            $('[name="id_kecamatan"]').val(data.id_kecamatan).trigger('change');
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title
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
}
//reload datatable ajax 
function reload_table() {
    table.ajax.reload(null, false);
}
// save
function save() {
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;

    if (save_method == 'add') {
        url = $('meta[name=app-url]').attr("content") + "admin/jalan/add";
    } else {
        url = $('meta[name=app-url]').attr("content") + "admin/jalan/update";
    }
    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal_form').modal('hide');
                Swal.fire({
                    timer: 1500,
                    timerProgressBar: true,
                    title: 'Sukses!',
                    html: 'Data berhasil disimpan!',
                    icon: 'success',
                    showConfirmButton: false,
                })
                //if success close modal and reload ajax table
                reload_table();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[
                        i]); //select span form-text class set text error string
                }
            }
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 
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
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 

        }
    });
}
// delete 
function delete_jalan(id) {
    Swal.fire({
        title: 'Anda yakin?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: $('meta[name=app-url]').attr("content") + "admin/jalan/delete/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    Swal.fire({
                        timer: 1500,
                        timerProgressBar: true,
                        title: 'Sukses!',
                        html: 'Data berhasil dihapus!',
                        icon: 'success',
                        showConfirmButton: false,
                    });
                    //if success reload ajax table
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        timer: 1500,
                        timerProgressBar: true,
                        title: 'Gagal!',
                        html: 'Data gagal dihapus!',
                        icon: 'error',
                        showConfirmButton: false,
                    })
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                timer: 500,
                timerProgressBar: true,
                title: 'Batal!',
                html: 'Data batal dihapus!',
                icon: 'error',
                showConfirmButton: false,
            })
        }

    })

}
</script>