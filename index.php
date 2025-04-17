<?php include "header.php"; ?>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

    <!--====== PRELOADER PART START ======-->
    <!-- 
    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!--====== PRELOADER PART ENDS ======-->

    <!--====== NAVBAR TWO PART START ======-->

    <section class="navbar-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">

                        <a class="navbar-brand" href="./">
                            <img src="<?= $idt['url'] ?>/gambar/logo/<?php echo $idt['logo_kanan']; ?>" class="h-8" alt="Logo">
                            <span class="judul" style="font-weight: bold;">SD Muh 3 Bandung</span>

                        </a>

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTwo" aria-controls="navbarTwo" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarTwo">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item active"><a class="page-scroll" href="./">home</a></li>
                                <li class="nav-item"><a class="page-scroll" href="#syarat-ketentuan">Syarat & Ketentuan</a></li>
                                <li class="nav-item"><a class="page-scroll" href="#jadwal-pendaftaran">Jadwal Pendaftaran</a></li>
                                <li class="nav-item"><a class="page-scroll" href="#pricing">Brosur & Panduan</a></li>
                                <li class="nav-item"><a class="page-scroll" href="daftar_titipan">Daftar Titipan</a></li>
                            </ul>
                        </div>

                        <div class="navbar-btn d-none d-sm-inline-block">
                            <ul>
                                <li><a class="solid" href="#">Login</a></li>
                            </ul>
                        </div>
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== NAVBAR TWO PART ENDS ======-->

    <!--====== SLIDER PART START ======-->

    <section id="home" class="slider_area">
        <div id="carouselThree" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="slider-content">
                                    <h1 class="title">SD Muh 3 Bandung</h1>
                                    <p class="text">PENERIMAAN PESERTA DIDIK BARU</p>
                                    <ul class="slider-btn rounded-buttons">
                                        <li><a class="main-btn rounded-one" href="#">DAFTAR</a></li>
                                        <li><a class="main-btn rounded-two" href="#">PENDAFTAR</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                    <div class="slider-image-box d-none d-lg-flex align-items-end">
                        <div class="slider-image">
                            <img src="assets/images/slider/1.png" alt="Hero">
                        </div> <!-- slider-imgae -->
                    </div> <!-- slider-imgae box -->
                </div> <!-- carousel-item -->

                <div class="carousel-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="slider-content">
                                    <h1 class="title">Crafted for Business</h1>
                                    <p class="text">We blend insights and strategy to create digital products for forward-thinking organisations.</p>
                                    <ul class="slider-btn rounded-buttons">
                                        <li><a class="main-btn rounded-one" href="#">GET STARTED</a></li>
                                        <li><a class="main-btn rounded-two" href="#">DOWNLOAD</a></li>
                                    </ul>
                                </div> <!-- slider-content -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                    <div class="slider-image-box d-none d-lg-flex align-items-end">
                        <div class="slider-image">
                            <img src="assets/images/slider/2.png" alt="Hero">
                        </div> <!-- slider-imgae -->
                    </div> <!-- slider-imgae box -->
                </div> <!-- carousel-item -->

                <div class="carousel-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="slider-content">
                                    <h1 class="title">Based on Bootstrap 4</h1>
                                    <p class="text">We blend insights and strategy to create digital products for forward-thinking organisations.</p>
                                    <ul class="slider-btn rounded-buttons">
                                        <li><a class="main-btn rounded-one" href="#">GET STARTED</a></li>
                                        <li><a class="main-btn rounded-two" href="#">DOWNLOAD</a></li>
                                    </ul>
                                </div> <!-- slider-content -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                    <div class="slider-image-box d-none d-lg-flex align-items-end">
                        <div class="slider-image">
                            <img src="assets/images/slider/3.png" alt="Hero">
                        </div> <!-- slider-imgae -->
                    </div> <!-- slider-imgae box -->
                </div> <!-- carousel-item -->

            </div>
            <a class="carousel-control-prev" href="#carouselThree" role="button" data-slide="prev">
                <i class="lni lni-arrow-left"></i>
            </a>
            <a class="carousel-control-next" href="#carouselThree" role="button" data-slide="next">
                <i class="lni lni-arrow-right"></i>
            </a>
        </div>
    </section>

    <!--====== SLIDER PART ENDS ======-->

    <section id="syarat-ketentuan" class="syarat-ketentuan-section">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-5">
                <div class="space-y-6">
                    <h4 class="text-2xl font-semibold text-white mb-3">Syarat & Ketentuan Umum</h4>
                    <ul class="list-decimal pl-6 text-white">
                        <li>Apabila pembiayaan PPDB tidak terselesaikan pada akhir bulan Juni 2025, maka pembiayaan tersebut menjadi Rp. 10.000.000,- dan batas waktu penyelesaian dapat dicicil selama 3 bulan sampai dengan akhir bulan September 2025.</li>
                        <li>Bagi peserta didik baru yang mempunyai saudara sekandung (Kakak) yang bersekolah di SD Muhammadiyah 3, maka akan mendapatkan keringanan pada Biaya Pendaftaran.</li>
                        <li>Bagi peserta peserta didik yang berasal dari TK Aisyiah milik Persyerikatan Muhammadiyah, maka akan mendapatkan keringanan 25% dari biaya Dana Sumbangan Pembangunan (DSP).</li>
                        <li>Bagi peserta didik baru yang merupakan anak guru, staf dan karyawan SD Muhammadiyah 3 serta telah mengabdi minimal 2 tahun masa kerja, maka mendapatkan keringanan 75% dari Biaya Dana Sumbangan Pembangunan (DSP) dan Sumbangan Pembinaan Pendidikan (SPP).</li>
                        <li>Bagi peserta didik baru yang merupakan anak dari Anggota Pleno, Majelis, dan Tokoh di Lingkungan Cibeunying Kidul, maka akan mendapatkan keringanan 50% dari Dana Swadaya Pembangunan (DSP) dengan melampirkan Kartu Anggota Muhammadiyah dan Surat Rekomendasi dari Pimpinan Cabang Muhammadiyah Cibeunying Kidul.</li>
                        <li>Bagi peserta didik baru yang merupakan anak dari Anggota Pleno, Majelis, dan Tokoh di luar Lingkungan Cibeunying Kidul, maka akan mendapatkan keringanan 25% dari Dana Swadaya Pembangunan (DSP) dengan melampirkan Kartu Anggota Muhammadiyah dan Surat Rekomendasi dari Pimpinan Cabang Muhammadiyah setempat.</li>
                        <li>Bagi peserta didik baru yang merupakan anak dari Anggota Pleno, Majelis, dan Tokoh di luar Lingkungan Cibeunying Kidul, dan mengikuti jalur Afirmasi, maka harus melampirkan Data Terpadu Kesejahteraan Sosial (DTKS).</li>
                        <li>Bagi peserta didik baru yang berlokasi satu RW dengan SD Muhammadiyah 3 Bandung, maka akan mendapatkan keringan 10% dari Dana Swadaya Pembangunan (DSP).</li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h4 class="text-2xl font-semibold text-white mb-4">Syarat & Ketentuan Jalur SKTM</h4>
                    <ul class="list-decimal pl-6 text-white">
                        <li>Jumlah peserta didik SKTM berjumlah maksimal 5% pada tahun PPDB periode berjalan.</li>
                        <li>Bagi calon peserta didik baru yang mengajukan syarat SKTM, maka akan dilakukan kunjungan ke tempat tinggalnya oleh panitia PPDB, serta melampirkan surat keterangan tidak mampu dari RT RW setempat. Apabila memenuhi syarat untuk pengajuan SKTM, maka calon peserta didik tersebut akan mendapatkan keringan pembebasan biaya DSP dan SPP selama 1 tahun ke depan.</li>
                        <li>Kunjungan dan survey ke tempat tinggal siswa SKTM akan dilakukan secara berkala, 1 tahun sekali untuk masa pembaharuan.</li>
                        <li>Peserta didik SKTM berlaku untuk 2 orang di dalam 1 keluarga.</li>
                        <li>Apabila pengajuan SKTM pada periode pertengahan tahun Ajaran, maka untuk pembiayaan Dana Swadaya Pembangunan (DSP) dan biaya Sumbangan Pembinaan Pendidikan (SPP) tertagih sebelum pengajuan, maka tetap akan tertagihkan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!--====== FEATRES TWO PART ENDS ======-->

    <!--====== PORTFOLIO PART START ======-->
    <section id="jadwal-pendaftaran" class="py-5 bg-transparent">
        <div class="container">
            <!-- Title Section -->
            <div class="section-title text-center pb-25">
                <h3 class="title">Jadwal Pendaftaran</h3>
                <p class="lead text-muted">Berikut adalah jadwal pendaftaran peserta didik baru</p>
            </div>

            <div class="row custom-gap">
                <!-- Left Column: Gelombang Pendaftaran -->
                <div class="col-md-6 p-4">
                    <div class="space-y-4">
                        <h4 class=" font-weight-bold text-dark">Gelombang Pendaftaran</h4>
                        <p class="text-muted">SD Muhammadiyah 3 Telah Dibuka 4 Gelombang Pendaftaran</p>
                    </div>
                    <div class="light-rounded-buttons mt-30">
                        <a href="https://rebrand.ly/smash-gg" rel="nofollow" class="main-btn light-rounded-two">Lihat Selengkapnya</a>
                    </div>
                </div>

                <!-- Right Column: Kelengkapan Dokumen Pendaftaran -->
                <div class="col-md-6 p-4">
                    <div class="space-y-4">
                        <h4 class="h3 font-weight-bold text-dark">Kelengkapan Dokumen Pendaftaran</h4>
                        <ul class="list-unstyled text-muted">
                            <li><i class="bi bi-check-circle"></i> Formulir Pendaftaran</li>
                            <li><i class="bi bi-check-circle"></i> Fotocopy KTP Ortu/wali (1 lembar)</li>
                            <li><i class="bi bi-check-circle"></i> Fotocopy KK (1 lembar)</li>
                            <li><i class="bi bi-check-circle"></i> Fotocopy Akta Kelahiran (1 lembar)</li>
                            <li><i class="bi bi-check-circle"></i> Fotocopy Ijazah TK/RA (1 rangkap) *boleh menyusul</li>
                            <li><i class="bi bi-check-circle"></i> Surat Pernyataan (download dari menu brosur dan panduan)</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>



    <!--====== PORTFOLIO PART ENDS ======-->

    <!--====== PRINICNG START ======-->

    <section id="pricing" class="pricing-area ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-10">
                    <div class="section-title text-center  pb-25">
                        <h3 class="title text-white ">Brosur & Panduan Pendaftaran </h3>
                        <p class="text text-white">Berikut adalah Brosur dan Panduan penggunaan aplikasi dalam bentuk video dan file info terkait Penerimaan Peserta Didik Baru

                        </p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <!-- Full-width container with unified card -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card mt-30 shadow-lg">
                        <div class="card-header bg-white text-left">
                            <h5 class="card-title">LINK FILE BROSUR PENDAFTARAN & VIDEO PENDAFTARAN </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Left column with embedded video -->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="video-container">
                                        <div class="video-embed text-center">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/zQ77Mh2LubI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right column with text links -->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <ul>
                                        <li class="mb-3">
                                            <a href="https://example.com/feature1">
                                                <h4>Feature 1: Learn more</h4>
                                                <p>Deskripsi</p>
                                            </a>
                                        </li>

                                        <li class="mb-3">
                                            <a href="https://example.com/feature1">
                                                <h4>Feature 2: Learn more</h4>
                                                <p>Deskripsi</p>
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="https://example.com/feature1">
                                                <h4>Feature 3: Learn more</h4>
                                                <p>Deskripsi</p>
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="https://example.com/feature1">
                                                <h4>Feature 4: Learn more</h4>
                                                <p>Deskripsi</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div> <!-- container -->
    </section>

    <!--====== PRINICNG ENDS ======-->


    <!--====== CONTACT PART START ======-->

    <section id="contact" class="contact-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section-title text-center pb-30">
                        <h3 class="title">Alamat dan Kontak</h3>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-map mt-30">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3960.9005875719563!2d107.652839!3d-6.902491!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e793bc2e1bf7%3A0x8ff5a0f54a45754!2sSekolah%20Menengah%20Pertama%20Muhammadiyah%203%20Bandung!5e0!3m2!1sid!2sid!4v1742478180559!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div> <!-- row -->
                </div>
                <div class="col-lg-6">
                    <div class="col-lg-12 col-md-12">
                        <div class="single-contact-info contact-color-1 mt-30 d-flex ">
                            <div class="contact-info-icon mr-3">
                                <i class="lni lni-map-marker"></i>
                            </div>
                            <div class="contact-info-content media-body">
                                <p class="text"> <?= $idt['alamat'] ?></p>
                            </div>
                        </div> <!-- single contact info -->
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="single-contact-info contact-color-2 mt-30 d-flex ">
                            <div class="contact-info-icon mr-3">
                                <i class="lni lni-envelope"></i>
                            </div>
                            <div class="contact-info-content media-body">
                                <p class="text"> sdsmuhammadiyah3bdg@gmail.com</p>
                            </div>
                        </div> <!-- single contact info -->
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="single-contact-info contact-color-3 mt-30 d-flex ">
                            <div class="contact-info-icon mr-3">
                                <i class="lni lni-phone"></i>
                            </div>
                            <div class="contact-info-content media-body">
                                <p class="text">+<?= $idt['wa'] ?></p>
                            </div>
                        </div> <!-- single contact info -->
                    </div>
                </div>
            </div> <!-- row -->

        </div> <!-- container -->
    </section>

    <!--====== CONTACT PART ENDS ======-->
    <?php include "footer.php"; ?>

</body>

</html>