<style>

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="button-list m-b-5">
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="add_drainase();"><i
                        class="fa fa-plus m-r-5"></i> <span>Tambah
                        Data</span></button>
                <button type="button" class="btn btn-success waves-effect waves-light" onclick="import_excel();"><i
                        class=" fa fa-upload m-r-5"></i> <span>Import
                        XLSX</span></button>
                <a target="_blank" href="<?= site_url('admin/DrainaseController/export'); ?>"
                    class="btn btn-success waves-effect waves-light"><i class="fa  fa-download m-r-5"></i> Export
                    XLSX</a>
                <!-- <a href="<?= site_url(); ?>admin/drainase/export_pdf" class="btn btn-purple waves-effect waves-light"
                        target="_BLANK"><i class="fa fa-file-pdf-o  m-r-5"></i> Export PDF</a> -->
                <button type=" button" class="btn btn-inverse waves-effect waves-light" onclick="truncate_table();"><i
                        class="fa fa-scissors m-r-5"></i> <span>Truncate
                        Tabel</span></button>
                <button type=" button" class="btn btn-custom waves-effect waves-light" onclick="reload_table();"><i
                        class="fa  fa-refresh m-r-5"></i> <span>Refresh Tabel </span></button>

                <button style="display: none;" type=" button"
                    class="btn btn-danger waves-effect waves-light hapus-kabeh" onclick="delete_multi();"><i
                        class="fa fa-times m-r-5"></i> <span>Hapus</span></button>
            </div>

            <table id="table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <!-- <th class="text-center">Pilih Data</th> -->
                        <th><input type="checkbox" name="select_all" value="1" id="select-all">
                        </th>
                        <th>No.</th>
                        <th class="lokasi">Jalan/Lokasi</th>
                        <th>Latitude Awal</th>
                        <th>Longitude Awal</th>
                        <th>Latitude Akhir</th>
                        <th>Longitude Akhir</th>
                        <th>Jalur Jalan</th>
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
                            <a href="<?= base_url('upload/excel/Data_Drainase_Format.xlsx'); ?>"><i
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