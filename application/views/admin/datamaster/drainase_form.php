<!-- leaflet draw -->
<link rel="stylesheet" href="<?= base_url() ?>assets/leaflet/leaflet-draw/leaflet.draw.css" />
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/Leaflet.draw.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/Control.Draw.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/Leaflet.Draw.Event.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/edit/handler/Edit.Poly.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/edit/handler/Edit.SimpleShape.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/handler/Draw.Feature.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/handler/Draw.Polyline.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/handler/Draw.Polygon.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/handler/Draw.SimpleShape.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/handler/Draw.Rectangle.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/handler/Draw.Circle.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/handler/Draw.Marker.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/handler/Draw.CircleMarker.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/ext/TouchEvents.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/ext/LatLngUtil.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/ext/GeometryUtil.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/ext/LineUtil.Intersect.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/ext/Polyline.Intersect.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/ext/Polygon.Intersect.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/Tooltip.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/Toolbar.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/draw/DrawToolbar.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/edit/EditToolbar.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/edit/handler/EditToolbar.Edit.js"></script>
<script src="<?= base_url() ?>assets/leaflet/leaflet-draw/edit/handler/EditToolbar.Delete.js"></script>

<style>
#mymap {
    width: 100%;
    height: 400px;
}
</style>
<!--ModalImport Csv-->
<div id="importModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Import CSV</h4>
            </div>
            <div class="modal-body">
                <form action="#" id="form_import">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" name="import_csv" required class="form-control" accept=".csv">
                                <span class="form-text text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" onclick="save_csv()" id="btn-import"
                    class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

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
                <div class="modal-body ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button disabled="disabled" id="refreshBtn" data-toggle="collapse"
                                    class="btn btn-primary edit-data waves-effect waves-light"
                                    data-parent="#accordion-test" href="#collapseOne" class="collapsed"><i
                                        class="fa fa-map-pin m-r-5"></i>
                                    Pilih Titik Koordinat
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" style="display: none;" name="id" />
                                <label>Nama Jalan</label>
                                <select disabled="disabled" class="form-control select2-container" name="id_jalan"
                                    required="">
                                    <!-- <option value="">--Pilih Jalan--</option> -->

                                </select>
                                <span class="text-danger id_jalan-err"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input disabled="disabled" name="date" type="text"
                                    class="form-control edit-data datepicker" placeholder=" yyyy-mm-dd" required="">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Latitude Awal</label>
                                <input disabled="disabled" type="text" class="form-control edit-data" name="lat_awal"
                                    required="" placeholder="Masukkan Latitude Awal">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Longitude Awal</label>
                                <input disabled="disabled" type="text" class="form-control edit-data" name="long_awal"
                                    required="" placeholder="Masukkan Longitude Awal">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Latitude Akhir</label>
                                <input disabled="disabled" type="text" class="form-control edit-data" name="lat_akhir"
                                    required="" placeholder="Masukkan Latitude Akhir">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Longitude Akhir</label>
                                <input disabled="disabled" type="text" class="form-control edit-data" name="long_akhir"
                                    required="" placeholder="Masukkan Longitude Akhir">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group map-view">
                                <div id="collapseOne" class="panel-collapse collapse">
                                    <div class="panel-body" id="mymap">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>STA</label>
                                <input disabled="disabled" type="text" class="form-control edit-data" name="sta"
                                    required="" placeholder="Masukkan STA">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Slope</label>
                                <input disabled="disabled" type="text" class="form-control edit-data" name="slope"
                                    required="" placeholder="Masukkan Slope (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Panjang Saluran</label>
                                <input disabled="disabled" type="text" class="form-control edit-data"
                                    name="panjang_saluran" required="" placeholder="Masukkan Panjang Saluran (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lebar Saluran</label>
                                <input disabled="disabled" type="text" class="form-control edit-data"
                                    name="lebar_saluran" required="" placeholder="Masukkan Lebar Saluran (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tinggi Saluran</label>
                                <input disabled="disabled" type="text" class="form-control edit-data"
                                    name="tinggi_saluran" required="" placeholder="Masukkan Tinggi Saluran (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Luas Penampung</label>
                                <input disabled="disabled" type="text" class="form-control edit-data"
                                    name="luas_penampung" required="" placeholder="Masukkan Luas Penampung (m2)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Keliling Penampung</label>
                                <input disabled="disabled" type="text" class="form-control edit-data"
                                    name="keliling_penampung" required="" placeholder="Masukkan Keliling Penampung (m)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Catchment Area</label>
                                <input disabled="disabled" type="text" class="form-control edit-data"
                                    name="catchment_area" required="" placeholder="Masukkan Catchment Area (ha)">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Arah Aliran</label>
                                <select disabled="disabled" class="form-control edit-data" name="id_arah_aliran"
                                    required="">
                                    <option value="">--Pilih Arah Aliran--</option>
                                    <?php foreach ($arah_aliran as $alir) { ?>
                                    <option value="<?= $alir->id_arah_aliran; ?>">
                                        <?= $alir->arah_aliran; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Saluran</label>
                                <select disabled="disabled" class="form-control edit-data" name="id_tipe_saluran"
                                    required="">
                                    <option value="">--Pilih Tipe Saluran--</option>
                                    <?php foreach ($tipe_saluran as $sal) { ?>
                                    <option value="<?= $sal->id_tipe_saluran; ?>">
                                        <?= $sal->tipe_saluran; ?>
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
                                <select disabled="disabled" class="form-control edit-data" name="id_kondisi_sedimen"
                                    required="">
                                    <option value="">--Pilih Kondisi Sedimen--</option>
                                    <?php foreach ($kondisi_sedimen as $sed) { ?>
                                    <option value="<?= $sed->id_kondisi_sedimen; ?>">
                                        <?= $sed->kondisi_sedimen; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kondisi Fisik</label>
                                <select disabled="disabled" class="form-control edit-data" name="id_kondisi_fisik"
                                    required="">
                                    <option value="">--Pilih Kondisi Fisik--</option>
                                    <?php foreach ($kondisi_fisik as $fisik) { ?>
                                    <option value="<?= $fisik->id_kondisi_fisik; ?>">
                                        <?= $fisik->kondisi_fisik; ?></option>
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
                                <select disabled="disabled" class="form-control edit-data" name="id_penanganan"
                                    required="">
                                    <option value="">--Pilih Penanganan--</option>
                                    <?php foreach ($penanganan as $pen) { ?>
                                    <option value="<?= $pen->id_penanganan; ?>">
                                        <?= $pen->penanganan; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lajur Drainase</label>
                                <select disabled="disabled" class="form-control edit-data" name="id_lajur_drainase"
                                    required="">
                                    <option value="">--Pilih Lajur Drainase--</option>
                                    <?php foreach ($lajur_drainase as $lajur) { ?>
                                    <option value="<?= $lajur->id_lajur_drainase; ?>">
                                        <?= $lajur->lajur_drainase; ?></option>
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
                                <input disabled="disabled" type="text" class="form-control edit-data"
                                    name="nama_file_foto" required="" placeholder="Masukkan Nama File Foto">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama File Dimensi</label>
                                <input disabled="disabled" type="text" class="form-control edit-data"
                                    name="nama_file_dimensi" required="" placeholder="Masukkan Nama File Dimensi">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="label-foto">Upload Foto</label>
                                <input disabled="disabled" type="file" class="form-control edit-data"
                                    onchange="fileSelect1(event)" name="file_foto" accept="image/*">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="label-dimensi">Upload Dimensi</label>
                                <input disabled="disabled" type="file" class="form-control edit-data"
                                    onchange="fileSelect2(event)" name="file_dimensi" accept="image/*">
                                <span class="text-danger"></span>
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
                    <button type="button" id="btnEdit" class="btn btn-custom waves-effect waves-light"
                        onclick="allowEdit();">Edit
                        Data</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?= site_url('datajson/data/jalan') ?>"></script>
<script src="<?= site_url('assets/crud.drainase.js') ?>"></script>