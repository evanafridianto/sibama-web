<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="button-list m-b-5">
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="add_jalan();"><i
                        class="fa fa-plus m-r-5"></i> <span>Tambah
                        Data</span></button>
                <button type="button" class="btn btn-success waves-effect waves-light" onclick="import_excel();"><i
                        class=" fa fa-upload m-r-5"></i> <span>Import
                        XLSX</span></button>
                <a href="<?= site_url('admin/jalan/export'); ?>" class="btn btn-success waves-effect waves-light"><i
                        class="fa  fa-download m-r-5"></i> Export XLSX</a>
                <button type=" button" class="btn btn-inverse waves-effect waves-light" onclick="truncate_table();"><i
                        class="fa fa-scissors m-r-5"></i> <span>Truncate
                        Tabel</span></button>
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
                        <th>Nama Jalan</th>
                        <th>Kelurahan</th>
                        <th>Kecamatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--ModalImport excel-->
<div id="importExcelModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Import Excel</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="<?= base_url('upload/excel/Data_Jalan_Format.xlsx'); ?>"><i
                                    class="fa fa-download m-r-5"></i>
                                Download Format</a>
                        </div>
                    </div>
                </div>
                <form action="#" id="form_import_excel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" name="import_excel" required class="form-control" accept=".xlsx">
                                <small class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" onclick="save_excel()" id="btn-import"
                    class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- form modal  -->
<div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Form Data</h4>
            </div>
            <div class="modal-body">
                <form action="#" id="form">
                    <input type="hidden" class="form-control" name="get_idkelurahan" id="get_idkelurahan">
                    <input type="hidden" class="form-control " name="id_jalan" />
                    <div class="form-group">
                        <label>Nama Jalan</label>
                        <input type="text" class="form-control" disabled="disabled" name="nama_jalan" required
                            placeholder="Masukkan Nama Jalan">
                        <small class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select name="id_kecamatan" id="id_kecamatan" class="form-control" disabled="disabled">
                            <option value="">--Pilih Kecamatan--</option>
                            <?php foreach ($kecamatan as $row) : ?>
                            <option value="<?= $row->id_kecamatan ?>">
                                <?= $row->nama_kecamatan ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan</label>
                        <select name="id_kelurahan" id="id_kelurahan" class="form-control" disabled="disabled">
                            <option value="">--Pilih Kelurahan--</option>

                        </select>
                        <small class="form-text text-danger"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSave" onclick="save()"
                            class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <button type="button" id="btnEdit" class="btn btn-custom waves-effect waves-light"
                            onclick="allowEdit();">Edit
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div><!-- /.modal -->
<script src="<?= base_url('assets/app/jalan.js') ?>"></script>