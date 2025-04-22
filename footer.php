<!--====== FOOTER PART START ======-->

<section class="footer-area footer-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="footer-logo text-center">
                    <a class="mt-30" href="index"><img src="<?= $idt['url'] ?>/gambar/logo/<?php echo $idt['logo_kanan']; ?>" class="h-12" alt="Logo"></a>
                </div> <!-- footer logo -->
                <ul class="social text-center mt-60">
                    <li><a href="https://facebook.com/uideckHQ"><i class="lni lni-facebook-filled"></i></a></li>
                    <li><a href="https://twitter.com/uideckHQ"><i class="lni lni-twitter-original"></i></a></li>
                    <li><a href="https://instagram.com/uideckHQ"><i class="lni lni-instagram-original"></i></a></li>
                    <li><a href="#"><i class="lni lni-linkedin-original"></i></a></li>
                </ul> <!-- social -->

                <div class="copyright text-center mt-35">
                    <p class="text">© Copyright Panitia. PPDB 2025 | SDM3 </p>
                </div> <!--  copyright -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== FOOTER PART ENDS ======-->

<!--====== BACK TOP TOP PART START ======-->

<a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>

<!--====== BACK TOP TOP PART ENDS ======-->

<!--====== PART START ======-->

<!--
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-">
                    
                </div>
            </div>
        </div>
    </section>
-->

<!--====== PART ENDS ======-->

<script>
    // Inisialisasi Flatpickr untuk elemen input dengan ID 'tglLahirSiswa'
    flatpickr("#tglLahirSiswa", {
        dateFormat: "Y-m-d", // Format tanggal (tahun-bulan-hari)
        minDate: "today", // Membatasi agar tanggal yang dipilih tidak bisa di masa depan
    });
</script>


<!--====== Jquery js ======-->
<script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>

<!--====== Bootstrap js ======-->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


<!--====== Isotope js ======-->
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>

<!--====== Scrolling Nav js ======-->
<script src="assets/js/jquery.easing.min.js"></script>
<script src="assets/js/scrolling-nav.js"></script>

<!--====== Main js ======-->
<script src="assets/js/main.js"></script>

<script>
    flatpickr(".class-date-picker", {
        locale: 'id',
        enableTime: false,
        dateFormat: "Y-m-d"
    });
</script>

<?php 
    if (isset($_SESSION['notif'])){
        if ($_SESSION['notif'] == 'error-token'){
            echo '<script>
                    Swal.fire({
                        title: "Gagal",
                        text: "Token tidak valid, silahkan refresh halaman ini.",
                        icon: "error"
                    });
                    </script>';
        }elseif ($_SESSION['notif'] == 'error-gelombang'){
            echo '<script>
                    Swal.fire({
                        title: "Gagal",
                        text: "Gelombang pendaftaran telah ditutup.",
                        icon: "error"
                    });
                    </script>';
        }elseif ($_SESSION['notif'] == 'error-kuota'){
            echo '<script>
                    Swal.fire({
                        title: "Gagal",
                        text: "Kuota pendaftaran telah penuh.",
                        icon: "error"
                    });
                    </script>';
        }elseif ($_SESSION['notif'] == 'success-daftar'){
            echo '<script>
                    Swal.fire({
                        title: "Sukses",
                        text: "Pendaftaran berhasil, silahkan cek whatsapp ayah atau ibu untuk login akun PPDB anda.",
                        icon: "success"
                    });
                    </script>';
        }
        unset($_SESSION['notif']);
    }
?>