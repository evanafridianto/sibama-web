<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $page_title . " | " . 'Sistem Informasi Banyu Malang' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="app-url" content="<?php echo base_url('/') ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/admin/images/sibama.ico">
    <script src="<?= base_url() ?>assets/admin/js/jquery.min.js"></script>
    <!-- App css -->
    <link href="<?= base_url() ?>assets/admin/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/admin/css/core.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/admin/css/components.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/admin/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/admin/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/admin/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/admin/css/responsive.css" rel="stylesheet" type="text/css" />

    <script src="<?= base_url() ?>assets/admin/js/modernizr.min.js"></script>
    <!-- Sweet Alert -->
    <link href="<?= base_url() ?>assets/admin/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet"
        type="text/css">
</head>

<body class="bg-accpunt-pages">
    <!-- HOME -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="wrapper-page">
                        <div class="account-pages">
                            <div class="account-box">
                                <div class="account-logo-box">
                                    <h2 class="text-uppercase text-center">
                                        <a href="<?= site_url('/') ?>" class="text-success">
                                            <span><img src="<?= base_url() ?>assets/admin/images/sibama-logo-dark.png"
                                                    alt="" height="30"></span>
                                        </a>
                                    </h2>
                                    <h5 class="text-uppercase font-bold m-b-5 m-t-50">Login</h5>
                                    <p class="m-b-0">Login to your Admin account</p>
                                </div>
                                <div class="account-content">
                                    <form class="form-horizontal" id="form_login">
                                        <div class="form-group m-b-20">
                                            <div class="col-xs-12">
                                                <label for="emailaddress">Username</label>
                                                <input class="form-control" name="username"
                                                    placeholder="Masukkan Username">
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-20">
                                            <div class="col-xs-12">
                                                <label for="password">Password</label>
                                                <input class="form-control" type="password" name="password"
                                                    placeholder="Masukkan password">
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button type="button"
                                                    class="btn btn-md btn-block btn-primary waves-effect waves-light"
                                                    onclick="login()"><i class="fa  fa-sign-in m-r-5"></i>
                                                    <span>Login</span></button>
                                            </div>
                                        </div>

                                        <!-- </form> -->
                                        <!-- <?= password_hash('admin', PASSWORD_DEFAULT)  ?> -->
                                </div>
                            </div>
                        </div>
                        <!-- end card-box-->
                    </div>
                    <!-- end wrapper -->
                </div>
            </div>
        </div>
    </section>
    <!-- END HOME -->

    <script>
    var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="<?= base_url() ?>assets/admin/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/js/waves.js"></script>
    <script src="<?= base_url() ?>assets/admin/js/jquery.slimscroll.js"></script>
    <script src="<?= base_url() ?>assets/admin/plugins/bootstrap-select/js/bootstrap-select.min.js"
        type="text/javascript">
    </script>
    <!-- Sweet-Alert  -->
    <script src="<?= base_url() ?>assets/admin/plugins/sweet-alert2/sweetalert2.min.js">
    </script>
    <!-- App js -->
    <script src="<?= base_url() ?>assets/admin/js/jquery.core.js"></script>
    <script src="<?= base_url() ?>assets/admin/js/jquery.app.js"></script>
    <script>
    //  login
    function login() {
        $('#btnLogin').text('Memproses...'); //change button text
        $('#btnLogin').attr('disabled', true); //set button disable 
        // ajax adding data to database
        $.ajax({
            url: $('meta[name=app-url]').attr("content") + "admin/auth/check",
            type: "POST",
            data: $("#form_login").serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    swal({
                        title: 'Sukses!',
                        text: 'Login berhasil!',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1000
                    }).then(
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === 'timer') {}
                        },
                        function() {
                            window.location.href = "<?= site_url('admin/dashboard') ?>";
                        }
                    );
                } else if (data.inputerror) {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[
                            i]); //select span text-danger class set text error string
                    }
                } else {
                    swal({
                        title: 'Gagal!',
                        text: data.msg,
                        type: 'error',
                        showConfirmButton: false,
                        timer: 1000
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === 'timer') {}
                        }
                    )
                }
                $('#btnLogin').text('Login'); //change button text
                $('#btnLogin').attr('disabled', false); //set button enable 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#btnLogin').text('Login'); //change button text
                $('#btnLogin').attr('disabled', false);
                swal({
                    title: 'Gagal!',
                    text: 'Proses gagal!',
                    type: 'error',
                    showConfirmButton: false,
                    timer: 1000
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === 'timer') {}
                    }
                )
            }
        });
    }
    $(document).ready(function() {
        $("input").keyup(function() {
            $(this).next().empty();
        });
    });
    </script>
</body>

</html>