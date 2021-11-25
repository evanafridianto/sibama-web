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

                    <button class="btn btn-primary" data-toggle="modal" onclick="add_person();">
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
                    <div id="alert-div">

                    </div>
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Date of Birth</th>
                                    <th>Photo</th>
                                    <th style="width:150px;">Action</th>
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
                        <input type="hidden" class="form-control " name="id" />
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstName" required
                                    placeholder="First Name">
                                <small class="form-text text-danger"></small>
                            </div><!-- /grid column -->
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="">--Select Gender--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <small class="form-text text-danger"></small>
                            </div><!-- /grid column -->
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input name="dob" type="text" class="form-control datepicker" placeholder="yyyy-mm-dd"
                                    required="">
                                <small class="form-text text-danger"></small>
                            </div>
                            <div class="form-group" id="photo-preview">
                                <label>Photo</label>
                                <div class="col-md-6 mb-3">
                                    (No photo)
                                    <small class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastName" required
                                    placeholder="First Name">
                                <small class="form-text text-danger"></small>
                            </div><!-- /grid column -->
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address" rows="4"></textarea>
                                <small class="form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label id="label-photo">Upload Photo</label>
                                <input type="file" class="form-control" name="photo" accept="image/*">
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
                            Tutup
                        </button>
                    </div>
                </form><!-- /form .needs-validation -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
        "autoWidth": false,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('person/ajax_list')?>",
            "type": "POST"
        },
    });
    //datepicker
    $('.datepicker').flatpickr({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: 'id',
        allowInput: true
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function() {
        $(this).next().empty();
    });
    $("textarea").change(function() {
        $(this).next().empty();
    });
    $("select").change(function() {
        $(this).next().empty();
    });

});

function add_person() {
    save_method = 'add';
    $('#modal_form').modal('show'); // show bootstrap modal
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.form-text').empty(); // clear error string
    $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title

    $('#photo-preview').hide(); // hide photo preview modal

    $('#label-photo').text('Upload Photo'); // label photo upload
}

function edit_person(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.form-text').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url: "<?php echo site_url('person/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id"]').val(data.id);
            $('[name="firstName"]').val(data.firstName);
            $('[name="lastName"]').val(data.lastName);
            $('[name="gender"]').val(data.gender);
            $('[name="address"]').val(data.address);
            $('[name="dob"]').val(data.dob);
            // $('[name="dob"]').flatpickr(data.dob);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if (data.photo) {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="' + base_url + 'upload/' + data.photo +
                    '" style=" width: 150px;"><br>'); // show photo
                $('#photo-preview div').append(
                    '<input type="checkbox" class="form-check-input" name="remove_photo" value="' +
                    data.photo + '"/> Remove photo when saving'); // remove photo
            } else {
                $('#label-photo').text('Upload Photo'); // label photo upload
                $('#photo-preview div').text('(No photo)');
            }


        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax 
}

function save() {
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;

    if (save_method == 'add') {
        url = "<?php echo site_url('person/ajax_add')?>";
    } else {
        url = "<?php echo site_url('person/ajax_update')?>";
    }
    // ajax adding data to database
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                Swal.fire({
                    timer: 1500,
                    timerProgressBar: true,
                    title: 'Sukses!',
                    html: 'Data berhasil disimpan!',
                    icon: 'success',
                    showConfirmButton: false,
                })
                reload_table();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    // $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass(
                    //     'has-error'
                    // ); //select parent twice to select div form-group class and add has-error class
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[
                        i]); //select span form-text class set text error string
                }
            }
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 


        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 

        }
    });

}

function delete_person(id) {
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
                url: "<?php echo site_url('person/ajax_delete')?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    Swal.fire({
                        timer: 1500,
                        timerProgressBar: true,
                        title: 'Sukses!',
                        html: 'Data berhasil dihapus!',
                        icon: 'success',
                        showConfirmButton: false,
                    });
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
    // ajax delete data to database

}
</script>