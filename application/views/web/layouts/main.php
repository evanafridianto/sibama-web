<!DOCTYPE html>
<html lang="en">
<?php include 'head.php' ?>
<style>
.page-header {
    background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url(assets/web/img/breadcumb-sibama.jpg);
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <?php include 'navbar.php'; ?>
    <!-- Carousel Start -->
    <?= $content; ?>
    <?php include 'footer.php' ?>
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    <?php include 'javascript.php' ?>
</body>

</html>

<script>
function sambat() {
    swal({
        title: 'Perhatian!',
        text: "Untuk melakukan laporan atau pengaduan, anda akan dialihkan ke laman Sambat Online Pemerintah Kota Malang",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4fa7f3',
        cancelButtonColor: '#d57171',
        showCancelButton: true,
        confirmButtonText: 'Oke',
        cancelButtonText: 'Batal',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-default m-l-10',
        buttonsStyling: false
    }).then(function() {

        window.open('https://sambat.malangkota.go.id/', '_blank').focus();

    }, function(dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {

            if (dismiss === 'timer') {}
        }
    })

}
</script>