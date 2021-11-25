<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="m-t-0 header-title">
                <button type="button" id="refresh" class="btn btn-primary waves-effect waves-light" data-toggle="modal"
                    onclick="add_drainase();"><i class="fa fa-plus m-r-5"></i> <span>Tambah
                        Data</span></button>
                <button type="button" class="btn btn-custom waves-effect waves-light" data-toggle="modal"
                    onclick="reload_table();"><i class="fa fa-refresh m-r-5"></i> <span>Refresh Tabel</span></button>
            </div>
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Jalan</th>
                        <th>Latitude Awal</th>
                        <th>Longitude Awal</th>
                        <th>Latitude Akhir</th>
                        <th>Longitude Akhir</th>
                        <th>Lajur Drainase</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>


                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Form Data  -->
<div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal_formLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal_formLabel">Form Data</h4>
            </div>
            <form action="#" id="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <a data-toggle="collapse" class="btn btn-primary waves-effect waves-light"
                                    data-parent="#accordion-test" href="#collapseOne" class="collapsed"><i
                                        class="fa fa-map-pin m-r-5"></i>
                                    Pilih Titik Koordinat
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" class="form-control " name="id" />
                                <label>Nama Jalan</label>
                                <select class="form-control select2-container" name="id_jalan" required="">
                                    <option value="">--Pilih Jalan--</option>
                                    <?php foreach ($jalan as $list) { ?>
                                    <option value="<?php echo $list->id_jalan; ?>"><?php echo $list->nama_jalan; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input name="date" type="text" class="form-control datepicker" placeholder=" yyyy-mm-dd"
                                    required="">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Latitude Awal</label>
                                <input type="text" class="form-control" name="lat_awal" required=""
                                    placeholder="Masukkan Latitude Awal">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Longitude Awal</label>
                                <input type="text" class="form-control" name="long_awal" required=""
                                    placeholder="Masukkan Longitude Awal">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Latitude Akhir</label>
                                <input type="text" class="form-control" name="lat_akhir" required=""
                                    placeholder="Masukkan Latitude Akhir">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Longitude Akhir</label>
                                <input type="text" class="form-control" name="long_akhir" required=""
                                    placeholder="Masukkan Longitude Akhir">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group" id="map-view">
                                <div id="collapseOne" class="panel-collapse collapse">
                                    <div class="panel-body" id="map">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>STA</label>
                                <input type="text" class="form-control" name="sta" required=""
                                    placeholder="Masukkan STA">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Slope</label>
                                <input type="text" class="form-control" name="slope" required=""
                                    placeholder="Masukkan Slope">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Panjang Saluran</label>
                                <input type="text" class="form-control" name="panjang_saluran" required=""
                                    placeholder="Masukkan Panjang Saluran (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lebar Saluran</label>
                                <input type="text" class="form-control" name="lebar_saluran" required=""
                                    placeholder="Masukkan Lebar Saluran (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tinggi Saluran</label>
                                <input type="text" class="form-control" name="tinggi_saluran" required=""
                                    placeholder="Masukkan Tinggi Saluran (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Luas Penampung</label>
                                <input type="text" class="form-control" name="luas_penampung" required=""
                                    placeholder="Masukkan Luas Penampung (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Keliling Penampung</label>
                                <input type="text" class="form-control" name="keliling_penampung" required=""
                                    placeholder="Masukkan Keliling Penampung (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Catchment Area</label>
                                <input type="text" class="form-control" name="catchment_area" required=""
                                    placeholder="Masukkan Catchment Area (ha)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Arah Aliran</label>
                                <select class="form-control" name="id_arah_aliran" required="">
                                    <option value="">--Pilih Arah Aliran--</option>
                                    <?php foreach ($arah_aliran as $alir) { ?>
                                    <option value="<?php echo $alir->id_arah_aliran; ?>">
                                        <?php echo $alir->arah_aliran; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Saluran</label>
                                <select class="form-control" name="id_tipe_saluran" required="">
                                    <option value="">--Pilih Tipe Saluran--</option>
                                    <?php foreach ($tipe_saluran as $sal) { ?>
                                    <option value="<?php echo $sal->id_tipe_saluran; ?>">
                                        <?php echo $sal->tipe_saluran; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kondisi Sedimen</label>
                                <select class="form-control" name="id_kondisi_sedimen" required="">
                                    <option value="">--Pilih Kondisi Sedimen--</option>
                                    <?php foreach ($kondisi_sedimen as $sed) { ?>
                                    <option value="<?php echo $sed->id_kondisi_sedimen; ?>">
                                        <?php echo $sed->kondisi_sedimen; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kondisi Fisik</label>
                                <select class="form-control" name="id_kondisi_fisik" required="">
                                    <option value="">--Pilih Kondisi Fisik--</option>
                                    <?php foreach ($kondisi_fisik as $fisik) { ?>
                                    <option value="<?php echo $fisik->id_kondisi_fisik; ?>">
                                        <?php echo $fisik->kondisi_fisik; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Penanganan</label>
                                <select class="form-control" name="id_penanganan" required="">
                                    <option value="">--Pilih Penanganan--</option>
                                    <?php foreach ($penanganan as $pen) { ?>
                                    <option value="<?php echo $pen->id_penanganan; ?>">
                                        <?php echo $pen->penanganan; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lajur Drainase</label>
                                <select class="form-control" name="id_lajur_drainase" required="">
                                    <option value="">--Pilih Lajur Drainase--</option>
                                    <?php foreach ($lajur_drainase as $lajur) { ?>
                                    <option value="<?php echo $lajur->id_lajur_drainase; ?>">
                                        <?php echo $lajur->lajur_drainase; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama File Foto</label>
                                <input type="text" class="form-control" name="nama_file_foto" required=""
                                    placeholder="Masukkan Nama File Foto">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama File Dimensi</label>
                                <input type="text" class="form-control" name="nama_file_dimensi" required=""
                                    placeholder="Masukkan Nama File Dimensi">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="label-foto">Upload Foto</label>
                                <input type="file" class="form-control" name="file_foto" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="label-dimensi">Upload Dimensi</label>
                                <input type="file" class="form-control" name="file_dimensi" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="foto-preview">
                                <label>Foto</label>
                                <div>
                                    (Empty file)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="dimensi-preview">
                                <label>Dimensi</label>
                                <div>
                                    (Empty file)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnSave" onclick="save()"
                        class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
            "url": $('meta[name=app-url]').attr("content") + "admin/drainase/show_all",
            "type": "GET"
        },
    });
    $('#modal_form').on('hidden.bs.modal', function() {
        location.reload();
    })

    // select2
    // $(document).ready(function() {
    //     $('.select2-containerr').select2({
    //         dropdownParent: $("#modal_form")
    //     });
    // });

    //datepicker
    $(function() {
        $(".datepicker").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            language: 'id'
        });
    });
    //set input/select event when change value, remove class error and remove text text-danger 
    $("input").change(function() {
        $(this).next().empty();
    });

    $("select").change(function() {
        $(this).next().empty();
    });
});

// add
function add_drainase() {
    save_method = 'add';
    $('#modal_form').modal('show'); // show bootstrap modal
    $('#form')[0].reset(); // reset form on modals
    $('.text-danger').empty(); // clear error string
    $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title

    $('#dimensi-preview').hide(); // hide dimensi preview modal
    $('#label-dimensi').text('Upload Dimensi'); // label foto upload

    $('#foto-preview').hide(); // hide foto preview modal
    $('#label-foto').text('Upload Foto'); // label foto upload
}
// edit
function edit_drainase(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.text-danger').empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url: $('meta[name=app-url]').attr("content") + "admin/drainase/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id"]').val(data.id);
            $('[name="id_jalan"]').val(data.id_jalan);
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
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title

            $('#foto-preview').show(); // show photo preview modal
            $('#dimensi-preview').show(); // show photo preview modal

            var dimensi = $('meta[name=app-url]').attr("content") + 'upload/dimensi/' + data.file_dimensi;
            var foto = $('meta[name=app-url]').attr("content") + 'upload/foto/' + data.file_foto;

            if (data.file_dimensi) {
                $.get(dimensi)
                    .done(function() {
                        $('#label-dimensi').text('Change Dimensi'); // label dimensi upload
                        $('#dimensi-preview div').html('<img src="' + dimensi +
                            '"style=" height: 100px;"><br>');
                        $('#dimensi-preview div').append(
                            '<input type="checkbox" class="form-check-input" name="remove_dimensi" value="' +
                            data.file_dimensi + '"/> Remove photo when saving'
                        ); // remove dimensi
                    }).fail(function() {
                        $('#dimensi-preview div').text('(Empty file)');
                        $('#label-dimensi').text('Upload Dimensi'); // label dimensi upload

                    })
            } else {
                $('#dimensi-preview div').text('(Empty file)');
                $('#label-dimensi').text('Upload Dimensi'); // label dimensi upload

            }
            if (data.file_foto) {
                $.get(foto)
                    .done(function() {
                        $('#label-foto').text('Change Foto'); // label foto upload
                        $('#foto-preview div').html('<img src="' + foto +
                            '"style=" height: 100px;"><br>');
                        $('#foto-preview div').append(
                            '<input type="checkbox" class="form-check-input" name="remove_foto" value="' +
                            data.file_foto + '"/> Remove photo when saving'); // remove foto
                    }).fail(function() {
                        $('#foto-preview div').text('(Empty file)');
                        $('#label-foto').text('Upload Foto'); // label foto upload
                    })
            } else {
                $('#foto-preview div').text('(Empty file)');
                $('#label-foto').text('Upload Foto'); // label foto upload
            }
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
        url = $('meta[name=app-url]').attr("content") + "admin/drainase/add";
    } else {
        url = $('meta[name=app-url]').attr("content") + "admin/drainase/update";
    }
    var formData = new FormData($('#form')[0]);
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
                        i]); //select span text-danger class set text error string
                }
            }
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 
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
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 

        }
    });
}
// delete 
function delete_drainase(id) {
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
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger m-l-10',
        buttonsStyling: false
    }).then(function() {
        $.ajax({
            url: $('meta[name=app-url]').attr("content") + "admin/drainase/delete/" + id,
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
            swal({
                title: 'Batal!',
                text: 'Data batal dihapus!',
                type: 'error',
                showConfirmButton: false,
                timer: 500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === 'timer') {}
                }
            )
        }
    })
}

function detail_drainase(id) {
    $('.modal-title').text('Detail Data'); // Set Title to Bootstrap modal title

    // $('#form')[0].reset(); // reset form on modals
    // $('#form').empty(); // clear error string
    let url = $('meta[name=app-url]').attr("content") + "admin/drainase/detail/" + id + "";
    $.ajax({
        url: url,
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(response) {
            let drainase = response;
            $("#id_jalan-info").html(drainase.nama_jalan);
            $("#sta-info").html(drainase.sta);
            $("#lat_awal-info").html(drainase.lat_awal);
            $("#long_awal-info").html(drainase.long_awal);
            $("#lat_akhir-info").html(drainase.lat_akhir);
            $("#long_akhir-info").html(drainase.long_akhir);
            $("#panjang_saluran-info").html(drainase.panjang_saluran);
            $("#slope-info").html(drainase.slope);
            $("#catchment_area-info").html(drainase.catchment_area);
            $("#tinggi_saluran-info").html(drainase.tinggi_saluran);
            $("#lebar_saluran-info").html(drainase.lebar_saluran);
            $("#luas_penampung-info").html(drainase.luas_penampung);
            $("#keliling_penampung-info").html(drainase.keliling_penampung);
            $("#id_arah_aliran-info").html(drainase.arah_aliran);
            $("#id_tipe_saluran-info").html(drainase.tipe_saluran);
            $("#id_kondisi_fisik-info").html(drainase.kondisi_fisik);
            $("#id_kondisi_sedimen-info").html(drainase.kondisi_sedimen);
            $("#id_penanganan-info").html(drainase.penanganan);
            $("#id_lajur_drainase-info").html(drainase.lajur_drainase);
            $("#nama_file_dimensi-info").html(drainase.nama_file_dimensi);
            $("#nama_file_foto-info").html(drainase.nama_file_foto);
            $("#date-info").html(drainase.date);
            $("#view-modal").modal('show');

            var dimensi = $('meta[name=app-url]').attr("content") + 'upload/dimensi/' + drainase
                .file_dimensi;
            var foto = $('meta[name=app-url]').attr("content") + 'upload/foto/' + drainase.file_foto;
            if (drainase.file_dimensi) {
                $.get(dimensi)
                    .done(function() {
                        $('#dimensi-info').html('<img src="' + dimensi +
                            '"style=" height: 100px;">');
                    }).fail(function() {
                        $('#dimensi-info').text('(Empty file)');
                    })
            } else {
                $('#dimensi-info').text('(Empty file)');
            }
            if (drainase.file_foto) {
                $.get(foto)
                    .done(function() {
                        $('#foto-info').html('<img src="' + foto +
                            '"style=" height: 100px;">');
                    }).fail(function() {
                        $('#foto-info').text('(Empty file)');
                    })
            } else {
                $('#foto-info').text('(Empty file)');
            }
        },
        error: function(response) {}
    });
}
</script>
<!--  Modal view data -->
<div id="view-modal" class="modal fade bd-example-modal-lg" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <form>
                    <table class="table table-striped mt-3">
                        <tbody>
                            <tr>
                                <td><b>Nama Jalan</b></td>
                                <td><b>:</b></td>
                                <td id="id_jalan-info"></td>
                            </tr>
                            <tr>
                                <td><b>STA</b></td>
                                <td><b>:</b></td>
                                <td id="sta-info"></td>
                            </tr>
                            <tr>
                                <td><b>Latitude Awal</b></td>
                                <td><b>:</b></td>
                                <td id="lat_awal-info"></td>
                            </tr>
                            <tr>
                                <td><b>Longitude Awal</b></td>
                                <td><b>:</b></td>
                                <td id="long_awal-info"></td>
                            </tr>
                            <tr>
                                <td><b>Latitude Akhir</b></td>
                                <td><b>:</b></td>
                                <td id="lat_akhir-info"></td>
                            </tr>
                            <tr>
                                <td><b>Longitude Akhir</b></td>
                                <td><b>:</b></td>
                                <td id="long_akhir-info"></td>
                            </tr>
                            <tr>
                                <td><b>Slope</b></td>
                                <td><b>:</b></td>
                                <td id="slope-info"></td>
                            </tr>
                            <tr>
                                <td><b>Catchment Area</b></td>
                                <td><b>:</b></td>
                                <td id="catchment_area-info"></td>
                            </tr>
                            <tr>
                                <td><b>Panjang Saluran</b></td>
                                <td><b>:</b></td>
                                <td id="panjang_saluran-info"></td>
                            </tr>
                            <tr>
                                <td><b>Tinggi Saluran</b></td>
                                <td><b>:</b></td>
                                <td id="tinggi_saluran-info"></td>
                            </tr>
                            <tr>
                                <td><b>Lebar Saluran</b></td>
                                <td><b>:</b></td>
                                <td id="lebar_saluran-info"></td>
                            </tr>
                            <tr>
                                <td><b>Luas Penampung</b></td>
                                <td><b>:</b></td>
                                <td id="luas_penampung-info"></td>
                            </tr>
                            <tr>
                                <td><b>Keliling Penampung</b></td>
                                <td><b>:</b></td>
                                <td id="keliling_penampung-info"></td>
                            </tr>
                            <tr>
                                <td><b>Arah Aliran</b></td>
                                <td><b>:</b></td>
                                <td id="id_arah_aliran-info"></td>
                            </tr>
                            <tr>
                                <td><b>Tipe Saluran</b></td>
                                <td><b>:</b></td>
                                <td id="id_tipe_saluran-info"></td>
                            </tr>
                            <tr>
                                <td><b>Kondisi Fisik</b></td>
                                <td><b>:</b></td>
                                <td id="id_kondisi_fisik-info"></td>
                            </tr>
                            <tr>
                                <td><b>Kondisi Sedimen</b></td>
                                <td><b>:</b></td>
                                <td id="id_kondisi_sedimen-info"></td>
                            </tr>
                            <tr>
                                <td><b>Penanganan</b></td>
                                <td><b>:</b></td>
                                <td id="id_penanganan-info"></td>
                            </tr>
                            <tr>
                                <td><b>Lajur Drainase</b></td>
                                <td><b>:</b></td>
                                <td id="id_lajur_drainase-info"></td>
                            </tr>
                            <tr>
                                <td><b>Nama File Dimensi</b></td>
                                <td><b>:</b></td>
                                <td id="nama_file_dimensi-info"></td>
                            </tr>
                            <tr>
                                <td><b>Nama File Foto</b></td>
                                <td><b>:</b></td>
                                <td id="nama_file_foto-info"></td>
                            </tr>
                            <tr>
                                <td><b>Tanggal</b></td>
                                <td><b>:</b></td>
                                <td id="date-info"></td>
                            </tr>
                            <tr>
                                <td><b>File Dimensi</b></td>
                                <td><b>:</b></td>
                                <td id="dimensi-info">(Empty file)</td>
                            </tr>
                            <tr>
                                <td><b>File Foto</b></td>
                                <td><b>:</b></td>
                                <td id="foto-info">(Empty file)</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </form><!-- /form .needs-validation -->
            </div>
        </div>
    </div>
</div>