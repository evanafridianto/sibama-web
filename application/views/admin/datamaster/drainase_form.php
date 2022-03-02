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
                                    class="btn btn-primary  waves-effect waves-light" data-parent="#accordion-test"
                                    href="#collapseOne" class="collapsed"><i class="fa fa-map-pin m-r-5"></i>
                                    Pilih Titik Koordinat
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group map-view">
                                <div id="collapseOne" class="panel-collapse collapse">
                                    <div class="panel-body img-thumbnail" id="mymap">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="id_drainase" />
                                <label>Nama Jalan</label>
                                <select class="form-control" name="id_jalan" required="">
                                    <option value="">--Pilih Jalan--</option>
                                    <?php foreach ($jalan as $jalan) { ?>
                                    <option value="<?= $jalan->id_jalan; ?>">
                                        <?= $jalan->nama_jalan, ',' . $jalan->nama_kelurahan . ',' . $jalan->nama_kecamatan; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Latitude Awal</label>
                                <input disabled="disabled" type="text" class="form-control" name="lat_awal" required=""
                                    placeholder="Masukkan Latitude Awal">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Latitude Akhir</label>
                                <input disabled="disabled" type="text" class="form-control" name="lat_akhir" required=""
                                    placeholder="Masukkan Latitude Akhir">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>STA</label>
                                <input disabled="disabled" type="text" class="form-control" name="sta" required=""
                                    placeholder="Masukkan STA">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Panjang </label>
                                <input disabled="disabled" type="text" class="form-control" name="panjang" required=""
                                    placeholder="Masukkan Panjang Drainase (m)">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Lebar </label>
                                <input disabled="disabled" type="text" class="form-control" name="lebar" required=""
                                    placeholder="Masukkan Lebar Drainase (m)">
                                <small class="text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label>Keliling Penampung</label>
                                <input disabled="disabled" type="text" class="form-control" name="keliling_penampung"
                                    required="" placeholder="Masukkan Keliling Penampung (m)">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Tipe </label>
                                <select disabled="disabled" class="form-control" name="tipe" required="">
                                    <option value="">--Pilih Tipe Drainase--</option>
                                    <option value="Terbuka">Terbuka</option>
                                    <option value="Tertutup">Tertutup</option>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Kondisi Fisik</label>
                                <select disabled="disabled" class="form-control" name="id_kondisi_fisik" required="">
                                    <option value="">--Pilih Kondisi Fisik--</option>
                                    <?php foreach ($kondisi_fisik as $fisik) { ?>
                                    <option value="<?= $fisik->id_kondisi_fisik; ?>">
                                        <?= $fisik->nama_kondisi_fisik; ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Penanganan</label>
                                <select disabled="disabled" class="form-control" name="id_penanganan" required="">
                                    <option value="">--Pilih Penanganan--</option>
                                    <?php foreach ($penanganan as $pen) { ?>
                                    <option value="<?= $pen->id_penanganan; ?>">
                                        <?= $pen->nama_penanganan; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Nama File Foto</label>
                                <input disabled="disabled" type="text" class="form-control" name="nama_file_foto"
                                    required="" placeholder="Masukkan Nama File Foto" />
                            </div>
                            <div class="form-group">
                                <label id="label-foto">Upload Foto</label>
                                <input disabled="disabled" type="file" class="form-control"
                                    onchange="fileSelect1(event)" name="file_foto" accept="image/*">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group" id="foto-preview">
                                <label>Foto</label>
                                <div>
                                    (Empty file)
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jalur Jalan</label>
                                <select disabled="disabled" class="form-control" name="jalur_jalan" required="">
                                    <option value="">--Pilih Jalur Jalan--</option>
                                    <option value="Kanan">Kanan</option>
                                    <option value="Kiri">Kiri</option>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Longitude Awal</label>
                                <input disabled="disabled" type="text" class="form-control" name="long_awal" required=""
                                    placeholder="Masukkan Longitude Awal">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Longitude Akhir</label>
                                <input disabled="disabled" type="text" class="form-control" name="long_akhir"
                                    required="" placeholder="Masukkan Longitude Akhir">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Slope</label>
                                <input disabled="disabled" type="text" class="form-control" name="slope" required=""
                                    placeholder="Masukkan Slope (m)">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Tinggi </label>
                                <input disabled="disabled" type="text" class="form-control" name="tinggi" required=""
                                    placeholder="Masukkan Tinggi Drainase (m)">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Luas Penampung</label>
                                <input disabled="disabled" type="text" class="form-control" name="luas_penampung"
                                    required="" placeholder="Masukkan Luas Penampung (m2)">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Catchment Area</label>
                                <input disabled="disabled" type="text" class="form-control" name="catchment_area"
                                    required="" placeholder="Masukkan Catchment Area (ha)">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Arah Air</label>
                                <select disabled="disabled" class="form-control" name="arah_air" required="">
                                    <option value="">--Pilih Arah Air--</option>
                                    <option value="Atas">Atas</option>
                                    <option value="Bawah">Bawah</option>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Kondisi Sedimen</label>
                                <select disabled="disabled" class="form-control" name="id_kondisi_sedimen" required="">
                                    <option value="">--Pilih Kondisi Sedimen--</option>
                                    <?php foreach ($kondisi_sedimen as $sed) { ?>
                                    <option value="<?= $sed->id_kondisi_sedimen; ?>">
                                        <?= $sed->nama_kondisi_sedimen; ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input disabled="disabled" name="date" type="text" class="form-control datepicker"
                                    placeholder=" yyyy-mm-dd" required="">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label>Nama File Dimensi</label>
                                <input disabled="disabled" type="text" class="form-control" name="nama_file_dimensi"
                                    required="" placeholder="Masukkan Nama File Dimensi">
                            </div>
                            <div class="form-group">
                                <label id="label-dimensi">Upload Dimensi</label>
                                <input disabled="disabled" type="file" class="form-control"
                                    onchange="fileSelect2(event)" name="file_dimensi" accept="image/*">
                                <small class="text-danger"></small>
                            </div>
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
<script src="<?= base_url('assets/app/drainase.js') ?>"></script>