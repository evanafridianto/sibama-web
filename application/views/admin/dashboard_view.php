<div class="row">
    <a href="<?= site_url('admin/data-master/drainase') ?>">
        <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-two widget-two-custom" title="Total Drainase">
                <i class="mdi mdi-highway widget-two-icon"></i>
                <div class="wigdet-two-content">
                    <p class="m-0 text-uppercase font-bold font-secondary text-overflow">Total Drainase</p>
                    <h2 class="font-600">
                        <span data-plugin="counterup"><?= $count_drainase; ?></span>
                    </h2>
                </div>
            </div>
        </div><!-- end col -->
    </a>
    <a href="<?= site_url('admin/data-master/jalan') ?>">
        <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-two widget-two-custom" title="Total Jalan">
                <i class="mdi mdi-road widget-two-icon"></i>
                <div class="wigdet-two-content">
                    <p class="m-0 text-uppercase font-bold font-secondary text-overflow">Total Jalan</p>
                    <h2 class="font-600">
                        <span data-plugin="counterup"><?= $count_jalan; ?></span>
                    </h2>
                </div>
            </div>
        </div><!-- end col -->
    </a>
    <a href="<?= site_url('admin/data-master/kelurahan') ?>">
        <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-two widget-two-custom" title="Total Kelurahan">
                <i class="mdi mdi-domain widget-two-icon"></i>
                <div class="wigdet-two-content">
                    <p class="m-0 text-uppercase font-bold font-secondary text-overflow">Total Kelurahan</p>
                    <h2 class="font-600">
                        <span data-plugin="counterup"><?= $count_kelurahan; ?></span>
                    </h2>
                </div>
            </div>
        </div><!-- end col -->
    </a>
    <a href="<?= site_url('admin/data-master/kecamatan') ?>">
        <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-two widget-two-custom" title="Total Kecamatan">
                <i class="mdi mdi-home-variant widget-two-icon"></i>
                <div class="wigdet-two-content">
                    <p class="m-0 text-uppercase font-bold font-secondary text-overflow">Total Kecamatan</p>
                    <h2 class="font-600">
                        <span data-plugin="counterup"><?= $count_kecamatan; ?></span>
                    </h2>
                </div>
            </div>
        </div><!-- end col -->
    </a>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Jumlah Drainase per Kelurahan</b></h4>
            <div class="table-responsive">
                <table id="table-dashboard" class="table m-0 table-colored table-bordered table-custom">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nama Kelurahan</th>
                            <th class="text-center">Jumlah Drainae</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="header-title m-t-0">STATISTIK STATUS GENANGAN PADA SALURAN DRAINASE</h4>
            <canvas id="myChart" height="235"></canvas>
        </div>
    </div>
</div>

<script src=" https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/app/dashboard.js') ?>"></script>