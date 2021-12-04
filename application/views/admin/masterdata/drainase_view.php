<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="m-t-0 header-title">
                <button type="button" id="refresh" class="btn btn-primary waves-effect waves-light" data-toggle="modal"
                    onclick="add_drainase();"><i class="fa fa-plus m-r-5"></i> <span>Tambah
                        Data</span></button>
                <button type="button" class="btn btn-custom waves-effect waves-light" data-toggle="modal"
                    onclick="reload_table();"><i class="fa fa-refresh m-r-5"></i> <span>Refresh Tabel</span></button>
            </div>
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Jalan</th>
                        <th>Latitude Awal</th>
                        <th>Longitude Awal</th>
                        <th>Latitude Akhir</th>
                        <th>Longitude Akhir</th>
                        <th>Lajur Drainase</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>