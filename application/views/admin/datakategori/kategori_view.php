<div class="row">
    <div class="col-lg-6">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Tipe Saluran</h4>
            <div class="button-list">
                <div class="form-group">
                    <button type="button" class="btn btn-primary waves-effect waves-light"
                        onclick="add_kategori('tipe_saluran');"><i class="fa fa-plus m-r-5"></i> <span>Tambah
                            Data</span></button>
                    <button type=" button" class="btn btn-custom waves-effect waves-light"
                        onclick="reload_table('tipe_saluran');"><i class="fa  fa-refresh m-r-5"></i> <span>Refresh
                            Tabel</span></button>
                </div>
            </div>
            <table id="table_tipe_saluran" class="table table-striped table-bordered dt-responsive nowrap"
                cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tipe Saluran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Arah Aliran</h4>
            <div class="button-list">
                <div class="form-group">
                    <button type="button" class="btn btn-primary waves-effect waves-light"
                        onclick="add_kategori('arah_aliran');"><i class="fa fa-plus m-r-5"></i> <span>Tambah
                            Data</span></button>
                    <button type=" button" class="btn btn-custom waves-effect waves-light"
                        onclick="reload_table('arah_aliran');"><i class="fa  fa-refresh m-r-5"></i> <span>Refresh
                            Tabel</span></button>
                </div>
            </div>
            <table id="table_arah_aliran" class="table table-striped table-bordered dt-responsive nowrap"
                cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Arah Aliran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Kondisi Fisik</h4>
            <div class="button-list">
                <div class="form-group">
                    <button type="button" class="btn btn-primary waves-effect waves-light"
                        onclick="add_kategori('kondisi_fisik');"><i class="fa fa-plus m-r-5"></i> <span>Tambah
                            Data</span></button>
                    <button type=" button" class="btn btn-custom waves-effect waves-light"
                        onclick="reload_table('kondisi_fisik');"><i class="fa  fa-refresh m-r-5"></i> <span>Refresh
                            Tabel</span></button>
                </div>
            </div>
            <table id="table_kondisi_fisik" class="table table-striped table-bordered dt-responsive nowrap"
                cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kondisi Fisik</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Penanganan</h4>
            <div class="button-list">
                <div class="form-group">
                    <button type="button" class="btn btn-primary waves-effect waves-light"
                        onclick="add_kategori('penanganan');"><i class="fa fa-plus m-r-5"></i> <span>Tambah
                            Data</span></button>
                    <button type=" button" class="btn btn-custom waves-effect waves-light"
                        onclick="reload_table('penanganan');"><i class="fa  fa-refresh m-r-5"></i> <span>Refresh
                            Tabel</span></button>
                </div>
            </div>
            <table id="table_penanganan" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Penanganan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Kondisi Sedimen</h4>
            <div class="button-list">
                <div class="form-group">
                    <button type="button" class="btn btn-primary waves-effect waves-light"
                        onclick="add_kategori('kondisi_sedimen');"><i class="fa fa-plus m-r-5"></i> <span>Tambah
                            Data</span></button>
                    <button type=" button" class="btn btn-custom waves-effect waves-light"
                        onclick="reload_table('kondisi_sedimen');"><i class="fa  fa-refresh m-r-5"></i> <span>Refresh
                            Tabel</span></button>
                </div>
            </div>
            <table id="table_kondisi_sedimen" class="table table-striped table-bordered dt-responsive nowrap"
                cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kondisi Sedimen</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Lajur Drainase</h4>
            <div class="button-list">
                <div class="form-group">
                    <button type="button" class="btn btn-primary waves-effect waves-light"
                        onclick="add_kategori('lajur_drainase');"><i class="fa fa-plus m-r-5"></i> <span>Tambah
                            Data</span></button>
                    <button type=" button" class="btn btn-custom waves-effect waves-light"
                        onclick="reload_table('lajur_drainase');"><i class="fa  fa-refresh m-r-5"></i> <span>Refresh
                            Tabel</span></button>
                </div>
            </div>
            <table id="table_lajur_drainase" class="table table-striped table-bordered dt-responsive nowrap"
                cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
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

<!-- tipe_saluran modal  -->
<div id="modal_kategori" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Form Data</h4>
            </div>
            <form action="#" id="kategori_form">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control " name="id_kategori" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="label_kategori">Label Kategori</label>
                                <input type="text" class="form-control" disabled="disabled" name="nama_kategori"
                                    required placeholder="Masukkan Kategori">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSave" name="btnSave" onclick="save()"
                            class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <button type="button" id="btnEdit" class="btn btn-custom waves-effect waves-light" n
                            onclick="allowEdit();">Edit
                            Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
<script src="<?= site_url('assets/crud.kategori.js') ?>"></script>