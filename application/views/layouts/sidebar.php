<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metisMenu nav" id="side-menu">
                <li class="menu-title">Application</li>
                <li>
                    <a href="<?=site_url()?>admin/beranda" aria-expanded="true"><i class="fi-air-play"></i><span
                            class="badge badge-success pull-right"></span> <span> Dashboard </span></a>
                </li>
                <li>
                    <a href="<?=site_url()?>admin/peta" aria-expanded="true"><i class="fi-map"></i><span
                            class="badge badge-success pull-right" id="peta-drainase"></span> <span> Peta Drainase
                        </span></a>
                </li>
                <li class="menu-title">Databases</li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true"><i class="fi-server"></i> <span>Data
                            Master</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="<?=site_url('admin/drainase')?>">Data Drainase</a></li>
                        <li><a href="admin-sweet-alert.html">Data Jalan</a></li>
                        <li><a href="admin-tiles.html">Data Kelurahan</a></li>
                        <li><a href="admin-nestable.html">Data Kecamatan</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true"><i class="fi-menu"></i> <span>Data
                            Kategori</span>
                        <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="admin-grid.html">Tipe Saluran</a></li>
                        <li><a href="admin-sweet-alert.html">Arah Aliran</a></li>
                        <li><a href="admin-tiles.html">Kondisi Fisik</a></li>
                        <li><a href="admin-nestable.html">Kondisi Sedimen</a></li>
                        <li><a href="admin-nestable.html"> Penanganan</a></li>
                        <li><a href="admin-nestable.html"> Lajur Drainase</a></li>
                    </ul>
                </li>
                <li class="menu-title">User Management</li>
                <li>
                    <a href="<?=site_url()?>admin/user" aria-expanded="true"><i class="fi-head"></i><span
                            class="badge badge-success pull-right"></span> <span> Data User </span></a>
                </li>
                <li>
                    <a href="<?=site_url()?>admin/logout" aria-expanded="true"><i class="fi-power"></i><span
                            class="badge badge-success pull-right"></span> <span> Logout </span></a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>