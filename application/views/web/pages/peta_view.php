<!-- leaflet -->
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet.css" />
<script src="<?=base_url()?>assets/leaflet/leaflet.js"></script>
<script src="<?=base_url()?>assets/leaflet/leaflet.ajax.js"></script>
<!-- leaflet zoom home -->
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet-zoom-home/leaflet.zoomhome.css" />
<script src="<?=base_url()?>assets/leaflet/leaflet-zoom-home/leaflet.zoomhome.min.js"></script>
<!-- Leaflet Panel Layers -->
<script src="<?=base_url()?>assets/leaflet/leaflet-panel-layers/src/leaflet-panel-layers.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/leaflet/leaflet-panel-layers/src/leaflet-panel-layers.css" />
<!-- Lightbox css -->
<link href="<?=base_url()?>assets/admin/plugins/lightbox/css/lightbox.min.css" rel="stylesheet" />
<script src="<?=site_url('datajson/data/kecamatan')?>"></script>
<style>
html,
body {
    height: 100%;
    margin: 0;
}

#map {
    width: 100%;
    height: 800px;
}

.info {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
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

<!-- Carousel End -->
<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <input type="hidden" name="r24">
    <div id="map"></div>
</div>
<!-- Carousel End -->
<script src="<?=site_url('assets/peta.drainase.js')?>"></script>