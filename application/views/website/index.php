<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title . " | " . SITE_NAME ?></title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/admin/images/sibama.ico">
    <meta name="app-url" content="<?= base_url('/') ?>">
    <!-- JQuery  -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap  -->
    <link href="<?= base_url() ?>assets/web/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Lightbox -->
    <link href="<?= base_url() ?>assets/admin/plugins/lightbox/css/lightbox.min.css" rel="stylesheet" />
    <!-- Custom  -->
    <link href="<?= base_url() ?>assets/web/css/custom.css" rel="stylesheet" />
    <!-- Leaflet  -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/leaflet/leaflet.css" />
    <!-- leaflet zoom home -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/leaflet/leaflet-zoom-home/leaflet.zoomhome.css" />
    <!-- Leaflet Panel Layers  -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/leaflet/leaflet-panel-layers/src/leaflet-panel-layers.css" />
    <!-- Leaflet Search Control  -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/leaflet/leaflet-search/leaflet-search.css" />
</head>

<body>
    <nav class="navbar navbar-default nav-fixed-top" id="app-nav-bar">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a href="<?= site_url('/') ?>"><img class="navbar-brand"
                        src="<?= base_url() ?>assets/admin/images/sibama-logo-dark.png" alt="" height="30"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"><i
                                class="fa fa-download white"></i>&nbsp;&nbsp;Download <span class="caret">
                            </span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url('json/data/drainase/download') ?>">drainase.geojson</a>
                            </li>
                            <li><a href="<?= site_url('json/data/jalan/download') ?>">jalan.json</a>
                            </li>
                            <li><a href="<?= site_url('json/data/kelurahan/download') ?>">kelurahan.json</a>
                            <li><a href="<?= site_url('json/data/kecamatan/download') ?>">kecamatan.json</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript: void(0);" data-toggle="modal" data-target="#basicModal"><i
                                class="fa fa-question-circle white"></i>&nbsp;&nbsp;About</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= site_url('login') ?>" target="_BLANK"><i class="fa fa-user"></i>
                            &nbsp;&nbsp;Log In</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tentang SIBAMA</h4>
                </div>
                <div class="modal-body">
                    Sistem Informasi Banyu Kota Malang (SIBAMA) adalah Aplikasi GIS berbasis website sebagai sarana
                    informasi bagi warga Kota Malang tentang letak,
                    kondisi, dan status genangan saluran drainase di wilayah Kota
                    Malang.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="map"></div>
    <!-- Bootstrap  -->
    <script src="<?= base_url() ?>assets/web/js/bootstrap.min.js"></script>
    <!-- Light Box  -->
    <script src="<?= base_url() ?>assets/admin/plugins/lightbox/js/lightbox.min.js" type="text/javascript"></script>
    <!-- leaflet -->
    <script src="<?= base_url() ?>assets/leaflet/leaflet.js"></script>
    <script src="<?= base_url() ?>assets/leaflet/leaflet.ajax.js"></script>
    <!-- leaflet zoom home -->
    <script src="<?= base_url() ?>assets/leaflet/leaflet-zoom-home/leaflet.zoomhome.min.js"></script>
    <!-- Leaflet Panel Layers -->
    <script src="<?= base_url() ?>assets/leaflet/leaflet-panel-layers/src/leaflet-panel-layers.js"></script>
    <script src="<?= base_url() ?>assets/leaflet/leaflet-search/leaflet-search.js"></script>
    <!-- Data Json  -->
    <script src="<?= site_url('jsoncontroller/data/kecamatan/list') ?>"></script>
    <!-- App Js  -->
    <script src="<?= base_url('assets/app/peta.drainase.js') ?>"></script>
</body>

</html>