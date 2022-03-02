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
                            class="badge badge-success pull-right"></span> <span>Lihat Situs
                        </span></a>
                </li>
                <li class="menu-title">Databases</li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true"><i class="fi-server"></i> <span>Data
                            Master</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="<?= site_url('admin/data-master/drainase') ?>">Drainase</a></li>
                        <li> <a href="<?= site_url('admin/data-master/kondisi-penanganan') ?>">Kondisi & Penanganan
                                Drainase</a>
                        </li>
                        <li><a href="<?= site_url('admin/data-master/jalan') ?>">Jalan </a></li>
                        <li><a href="<?= site_url('admin/data-master/kelurahan') ?>">Kelurahan</a></li>
                        <li><a href="<?= site_url('admin/data-master/kecamatan') ?>">Kecamatan</a></li>
                        <li><a href="<?= site_url('admin/data-master/user') ?>">User</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?= site_url('admin/r24') ?>" aria-expanded="true"><i class="fi-drop"></i><span
                            class="badge badge-success pull-right"></span> <span>
                            Curah Hujan/R24 </span></a>
                </li>
                <li class="menu-title">Accounts</li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="true"><i class="fi-cog"></i> <span>Pengaturan
                            Akun</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level nav" aria-expanded="true">
                        <li><a href="javascript: void(0);"
                                onclick="profil_user(<?= $this->session->id_user ?>)">Profil</a></li>
                        <li><a href="javascript: void(0);" onclick="ganti_pass(<?= $this->session->id_user ?>)"> Ganti
                                Password</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" onclick="logout()" aria-expanded="true"><i class="fi-power"></i><span
                            class="badge badge-success pull-right"></span> <span> Log Out </span></a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>