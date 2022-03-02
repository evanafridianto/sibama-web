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
            <table id="table_user" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
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

<!-- user modal  -->
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
                                <small class=" form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Username </label>
                                <input type="text" class="form-control" disabled="disabled" name="username" required
                                    placeholder="Masukkan Username ">
                                <small class=" form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password </label>
                                <input type="password" class="form-control" disabled="disabled" name="password" required
                                    placeholder="Masukkan Password ">
                                <small class=" form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Konfirmasi Password </label>
                                <input type="password" class="form-control" disabled="disabled" name="konfir_password"
                                    required placeholder="Masukkan Konfirmasi Password ">
                                <small class=" form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Foto Profil</label>
                                <input type="file" class="form-control" disabled="disabled" name="photo"
                                    accept="image/*">
                                <small class=" form-text text-danger"></small>
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
<script src="<?= base_url('assets/app/user.js') ?>"></script>