<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="button-list m-b-5">
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="add_r24();"><i
                        class="fa fa-plus m-r-5"></i> <span>Tambah
                        Data</span></button>
                <button type=" button" class="btn btn-custom waves-effect waves-light" onclick="reload_table();"><i
                        class="fa  fa-refresh m-r-5"></i> <span>Refresh Tabel</span></button>
            </div>
            <table id="table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Kecamatan</th>
                        <th>Curah Hujan/R24 Max Harian (mm)</th>
                        <th>Tahun</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


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
                    <input type="hidden" class="form-control " name="id_r24" />
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
                        <label>Curah Hujan</label>
                        <input type="text" class="form-control" disabled="disabled" name="r24" required
                            placeholder="Masukkan Curah Hujan (mm)">
                        <small class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="text" class="form-control datepicker" disabled="disabled" name="tahun" required
                            placeholder="Masukkan Tahun (yyyy)">
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
<script src="<?= base_url('assets/app/r24.js') ?>"></script>