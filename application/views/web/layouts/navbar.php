<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="<?= site_url('/') ?>" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><img src="<?= base_url('assets/web/img/logo-sibama.png') ?>" class="me-2"
                style="width:35px;height:40px">SIBAMA</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="<?= site_url('/') ?>"
                class="nav-item nav-link <?= $page_title == 'Peta Drainase' ? "active" : "" ?>">Peta
                Drainase</a>
            <a href="<?= site_url('/about') ?>" class="nav-item nav-link
                <?= $page_title == 'About' ? "active" : "" ?>">About</a>
            <a href="<?= site_url('/feedback') ?>"
                class="nav-item nav-link <?= $page_title == 'Feedback' ? "active" : "" ?>">Feedback</a>
            <a onclick="sambat()" href="#" class="nav-item nav-link">Laporan dan Pengaduan</a>
        </div>
        <a href="<?= site_url('admin/login') ?>" target="_BLANK"
            class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
    </div>
</nav>
<!-- Navbar End -->