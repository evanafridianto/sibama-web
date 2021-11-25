<!DOCTYPE html>
<html>

<?php include 'head.php'?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        <div class="topbar">

            <!-- LOGO -->
            <div class="topbar-left">
                <!--<a href="index.html" class="logo"><span>Code<span>Fox</span></span><i class="mdi mdi-layers"></i></a>-->
                <!-- Image logo -->
                <a href="<?=site_url()?>admin/beranda" class="logo">
                    <span>
                        <img src="<?=base_url()?>assets/images/sibama-logo.png" alt="" height="25">
                    </span>
                    <i>
                        <img src="<?=base_url()?>assets/images/sibama-logo-sm.png" alt="" height="28">
                    </i>
                </a>
            </div>

            <!-- Button mobile view to collapse sidebar menu -->
            <?php include 'header.php' ?>
        </div>
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include 'sidebar.php'?>
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
                                        <a href="<?=site_url()?>admin/beranda">Beranda</a>
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
            <?php include 'footer.php'?>
        </div>
    </div>
    <?php include 'javascript.php'?>
</body>

</html>