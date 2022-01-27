<div class="row">
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
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Warning!</strong> Saluran drainase dalam kondisi rusak berat.
            </div>
            <div class="table-responsive">
                <table id="table-beranda" class="table table-striped table-bordered dt-responsive nowrap"
                    cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jalan/Lokasi</th>
                            <th>Latitude Awal</th>
                            <th>Longitude Awal</th>
                            <th>Latitude Akhir</th>
                            <th>Longitude Akhir</th>
                            <th>Kondisi Fisik</th>
                            <th>Lajur Drainase</th>
                            <th>Aksi</th>
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
    $('#table-beranda').DataTable({
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
        "autoWidth": false,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": $('meta[name=app-url]').attr("content") + "admin/dashboard/drainase_rusak",
            "type": "GET"
        },
    });
});
</script>