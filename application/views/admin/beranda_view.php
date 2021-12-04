<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-box-two widget-two-custom" title="Jumlah Drainase">
            <i class="mdi mdi-highway widget-two-icon"></i>
            <div class="wigdet-two-content">
                <p class="m-0 text-uppercase font-bold font-secondary text-overflow">Jumlah Drainase</p>
                <h2 class="font-600">
                    <span data-plugin="counterup"><?= $count_drainase; ?></span>
                </h2>
            </div>
        </div>
    </div><!-- end col -->
    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-box-two widget-two-custom" title="Jumlah Jalan">
            <i class="mdi mdi-road widget-two-icon"></i>
            <div class="wigdet-two-content">
                <p class="m-0 text-uppercase font-bold font-secondary text-overflow">Jumlah Jalan</p>
                <h2 class="font-600">
                    <span data-plugin="counterup"><?= $count_jalan; ?></span>
                </h2>
            </div>
        </div>
    </div><!-- end col -->
    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-box-two widget-two-custom" title="Jumlah Kelurahan">
            <i class="mdi mdi-domain widget-two-icon"></i>
            <div class="wigdet-two-content">
                <p class="m-0 text-uppercase font-bold font-secondary text-overflow">Jumlah Kelurahan</p>
                <h2 class="font-600">
                    <span data-plugin="counterup"><?= $count_kelurahan; ?></span>
                </h2>
            </div>
        </div>
    </div><!-- end col -->
    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-box-two widget-two-custom" title="Jumlah Kecamatan">
            <i class="mdi mdi-home-variant widget-two-icon"></i>
            <div class="wigdet-two-content">
                <p class="m-0 text-uppercase font-bold font-secondary text-overflow">Jumlah Kecamatan</p>
                <h2 class="font-600">
                    <span data-plugin="counterup"><?= $count_kecamatan; ?></span>
                </h2>
            </div>
        </div>
    </div><!-- end col -->
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title text-danger"><b>Drainase Dalam Kondisi Rusak Berat</b></h4>
            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Jalan</th>
                            <th>Latitude Awal</th>
                            <th>Longitude Awal</th>
                            <th>Latitude Akhir</th>
                            <th>Longitude Akhir</th>
                            <th>Kondisi Fisik</th>
                            <th>Lajur Drainase</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
        "autoWidth": false,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": $('meta[name=app-url]').attr("content") + "admin/beranda/drainase_rusak",
            "type": "GET"
        },
    });
});
</script>