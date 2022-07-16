<style>
/* map css */
#map {
    height: 650px;
    width: 100vw;
    width: 100%;
    display: block;
    z-index: 3;
}

/*Legend specific*/
.legend {
    padding: 8px;
    background: white;
    background: rgba(255, 255, 255, 0.8);
    /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
    border-radius: 5px;
    line-height: 24px;
    color: #555;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-color panel-default">
            <div class="panel-heading">

            </div>

            <div class="panel-body">
                <div id="map">
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Leaflet Panel Layers -->
<script src="<?= base_url() ?>assets/leaflet/leaflet-panel-layers/src/leaflet-panel-layers.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/leaflet/leaflet-panel-layers/src/leaflet-panel-layers.css" />
<!-- Leaflet Search Control  -->
<script src="<?= base_url() ?>assets/leaflet/leaflet-search/leaflet-search.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/leaflet/leaflet-search/leaflet-search.css" />
<!-- Data Json  -->
<script src="<?= site_url('JsonController/data/kecamatan/list') ?>"></script>
<script src="<?= base_url('assets/app/peta.drainase.js') ?>"></script>