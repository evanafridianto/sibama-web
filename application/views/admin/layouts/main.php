<!DOCTYPE html>
<html>

<?php include 'head.php' ?>
<style>
/* map css */
#map {
    height: 660px;
    width: 100vw;
    width: 100%;
    display: block;
    z-index: 3;
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

<body>

    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <div class="topbar">
            <!-- LOGO -->
            <div class="topbar-left">
                <!--<a href="index.html" class="logo"><span>Code<span>Fox</span></span><i class="mdi mdi-layers"></i></a>-->
                <!-- Image logo -->
                <a href="<?= site_url('admin/dashboard') ?>" class="logo">
                    <span>
                        <img src="<?= base_url() ?>assets/admin/images/sibama-logo.png" alt="" height="25">
                    </span>
                    <i>
                        <img src="<?= base_url() ?>assets/admin/images/sibama-logo-sm.png" alt="" height="28">
                    </i>
                </a>
            </div>

            <!-- Button mobile view to collapse sidebar menu -->
            <?php include 'navbar.php' ?>
        </div>
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include 'sidebar.php' ?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title"><?= $page_title; ?></h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
                                    </li>
                                    <li class="active">
                                        <?= $page_title; ?>
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <?= $content; ?>
                </div> <!-- container -->
            </div> <!-- content -->

            <?php include 'footer.php' ?>

        </div>
    </div>
    <?php include 'javascript.php' ?>

    <script src="<?= site_url('assets/main.js') ?>"></script>
    <!-- end row -->
    <div id="profil_user_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="title_modalUser">Profil</h4>
                </div>
                <form action="#" id="form_profil_user">
                    <div class="modal-body">
                        <!-- meta -->
                        <div class="row">
                            <div class="form-group account-btn text-center m-t-10">
                                <div class="col-xs-12">
                                    <div class="thumb-xl member-thumb m-b-10 center-block">
                                        <div id="foto-user">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_user" class="form-control edit-profil">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control edit-profil">
                                    <span class="form-text text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control edit-profil">
                                    <span class="form-text text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label id="label-photo">Upload Foto</label>
                                    <input type="file" name="photo" class="form-control edit-profil" accept="image/*">
                                    <span class="form-text text-danger"></span>
                                    <div class="form-group" id="photo-preview">
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>

                        <button type="button" id="Btn-saveProfil" onclick="save_profil()"
                            class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <button type="button" onclick="allowEditProfil()" id="Btn-editProfil"
                            class="btn btn-custom waves-effect waves-light">Edit Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->

    <!-- ganti pass modal  -->
    <div id="ganti_pass_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Ganti Password</h4>
                </div>
                <form action="#" id="form_ganti_pass">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Password Lama </label>
                                    <input type="hidden" class="form-control edit-data"
                                        value="<?= $this->session->id_user ?>" name="id_user" />
                                    <input type="text" placeholder="Masukkan Password Lama" name="password"
                                        class="form-control">
                                    <span class="form-text text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="text" placeholder="Masukkan Password Baru" name="password_baru"
                                        class="form-control">
                                    <span class="form-text text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Konfirmasi Password Baru</label>
                                    <input type="text" placeholder="Konfirmasi Password Baru" name="konfir_password"
                                        class="form-control">
                                    <span class="form-text text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect"
                                data-dismiss="modal">Batal</button>
                            <button type="button" onclick="save_pass()" id="Btn-savePass"
                                class="btn btn-primary waves-effect waves-light">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->

</body>

</html>