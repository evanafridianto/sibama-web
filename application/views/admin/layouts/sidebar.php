<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metisMenu nav" id="side-menu">
                <li class="menu-title">Home</li>
                <li>
                    <a href="<?= site_url('admin/dashboard') ?>" aria-expanded="true"><i class="fi-air-play"></i><span
                            class="badge badge-success pull-right"></span> <span>
                            Dashboard </span></a>
                </li>
                <li class="menu-title">Applications</li>
                <li>
                    <a href="<?= site_url('admin/peta') ?>" aria-expanded="true"><i class="fi-map"></i><span
                            class="badge badge-success pull-right"></span> <span> Peta Drainase
                        </span></a>
                </li>
                <li>
                    <a href="<?= site_url('/') ?>" target="_BLANK" aria-expanded="true"><i class="fi-open"></i><span
                            class="badge badge-success pull-right"></span> <span>Lihat Web
                        </span></a>
                </li>
                <li class="menu-title">Databases</li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true"><i class="fi-server"></i> <span>Data
                            Master</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="<?= site_url('admin/data-master/drainase') ?>">Data Drainase</a></li>
                        <li><a href="<?= site_url('admin/data-master/jalan') ?>">Data Jalan</a></li>
                        <li><a href="<?= site_url('admin/data-master/kelurahan') ?>">Data Kelurahan</a></li>
                        <li><a href="<?= site_url('admin/data-master/kecamatan') ?>">Data Kecamatan</a></li>
                        <li> <a href="<?= site_url('admin/data-kategori') ?>">Data Kategori</a></li>
                        <li><a href="<?= site_url('admin/data-master/user') ?>">Data User</a></li>
                    </ul>
                </li>
                <li class="menu-title">Account Settings</li>
                <li>
                    <a href="javascript: void(0);" onclick="profil_user(<?= $this->session->id_user ?>)"
                        aria-expanded="true"><i class="fi-head"></i><span class="badge badge-success pull-right"></span>
                        <span> Profil
                        </span></a>
                </li>
                <li>
                    <a href="javascript: void(0);" onclick="ganti_pass(<?= $this->session->id_user ?>)"
                        aria-expanded="true"><i class="fi-unlock"></i><span
                            class="badge badge-success pull-right"></span> <span> Ganti
                            Password </span></a>
                </li>
                <li>
                    <a href="javascript: void(0);" onclick="logout()" aria-expanded="true"><i class="fi-power"></i><span
                            class="badge badge-success pull-right"></span> <span> Logout </span></a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>