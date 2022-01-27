<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-color panel-default">
            <div class="panel-heading">
                <button type="button" title="Setting R24" class="btn btn-icon waves-effect waves-light btn-default"
                    onclick="setting_r24()"><i class="fa fa-pencil"></i>
                    Curah Hujan :
                    <strong class="r24-info">Tidak Diketahui</strong></button>
            </div>
            <div class="panel-body">
                <div id="map">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end row -->
<div id="settingr24_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Setting R24 (max harian)</h4>
            </div>
            <div class="modal-body">
                <form action="#" id="form_r24">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="id_r24">
                                <input type="text" placeholder="R24 (mm/jam)" name="r24" class="form-control">
                                <small class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                <button type="button" onclick="save_r24()" id="save_r24"
                    class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- Leaflet Panel Layers -->
<script src="<?=base_url()?>assets/leaflet/leaflet-panel-layers/src/leaflet-panel-layers.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet-panel-layers/src/leaflet-panel-layers.css" />
<!-- Leaflet Search Control  -->
<script src="<?=base_url()?>assets/leaflet/leaflet-search/leaflet-search.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet-search/leaflet-search.css" />
<script src="<?=site_url('datajson/data/kecamatan')?>"></script>
<script src="<?=site_url('assets/peta.drainase.js')?>"></script>