<?php
    session_start();
    // error_reporting(1);
    include "../config/koneksi.php";
    include "../config/fungsi_login.php";
    include "../config/enkripsi_deskripsi.php";
    include "../config/fungsi_indotgl.php";
    include "../config/library.php";

    // CSRF TOKEN
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $view = isset($_GET['view']) ? $_GET['view'] : '';
    
    // jika belum login
    if (!isLogin()){
        echo "<script>document.location='../login';</script>";
        exit;
    }

    // jika logout
    if ($view == 'logout'){
        isLogout();
        exit;
    }
    
    $idSiswa = isset($_SESSION['siswa']) ? decrypt($_SESSION['siswa']) : '';
    $dtSiswa = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT 
            sws.*, 
            stts.statusPendafataran, stts.statusPemberkasan, stts.statusPembayaran, 
            brks.formulir, brks.suratPernyataan, brks.asliKTP, brks.asliAktaKelahiran, 
            brks.copyKTP, brks.copyKK, brks.copyAktaKelahiran, brks.copyDTKS,
            glmbng.biaya, glmbng.nmGelombang
        FROM siswa sws 
        LEFT JOIN ppdb_status stts 
            ON sws.idSiswa = stts.idSiswa AND sws.id_gelombang = stts.idGlombang 
        LEFT JOIN ppdb_pemberkasan brks 
            ON sws.idSiswa = brks.idSiswa AND sws.id_gelombang = brks.idGlombang 
        INNER JOIN ppdb_gelombang glmbng 
            ON sws.id_gelombang = glmbng.idGlombang
        WHERE sws.idSiswa = '$idSiswa' 
        LIMIT 1
    "));
    $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
    $ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran where aktif='Y'"));
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PPDB | SD Muhammadiyah 3 Bandung</title>

        <link rel="shortcut icon" href="<?= $idt['url'] ?>/gambar/logo/<?php echo $idt['logo_kanan']; ?>">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/style.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="assets/font-awesome-4.6.3/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skin folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
        <!--====== Swetalert CSS ======-->
        <link rel="stylesheet" href="../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <script src="../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
        <style>
            /* Atur font popup Swal */
            .swal2-popup {
                font-size: 1.2rem !important;
                width: 32em !important;
            }

            /* Judul Swal */
            .swal2-title {
                font-size: 1.8rem !important;
                font-weight: 600 !important;
            }

            /* Teks konten Swal */
            .swal2-html-container {
                font-size: 1.4rem !important;
            }

            /* Tombol Swal */
            .swal2-actions .swal2-confirm,
            .swal2-actions .swal2-cancel {
                font-size: 1rem !important;
                padding: 0.8rem 1.2rem !important;
            }

            .modal.modal-center .modal-dialog {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                margin: 0;
            }

            label.error {
                color: red;
                display: block;
                margin-top: 5px;
            }
        </style>
        
        <!-- jQuery 2.1.4 -->
        <script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Validasi -->
        <script src="../assets/plugins/validate/jquery.validate.min.js"></script>
        <!-- Flatpickr -->
        <link rel="stylesheet" href="../assets/plugins/flatpickr/flatpickr.min.css">
        <script src="../assets/plugins/flatpickr/flatpickr.js"></script>
        <script src="../assets/plugins/flatpickr/l10n/id.js"></script>
        <!-- Datatables -->
        <link rel="stylesheet" href="../assets/plugins/datatables/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="../assets/plugins/datatables/css/responsive.bootstrap4.min.css">
        <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
        <script src="../assets/plugins/datatables/js/dataTables.responsive.min.js"></script>
        <script src="../assets/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    </head>

    <body class="hold-transition skin-<?php echo $idt['tema']; ?> sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <?php include "partial/main-header.php" ?>
            </header>

            <aside class="main-sidebar">
                <?php include "partial/menu.php" ?>
            </aside>

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1><?php echo $judul ?></h1>
                </section>

                <section class="content">
                    <?php include 'partial/main.php'; ?>

                </section>
            </div><!-- /.content-wrapper -->

            <footer class="main-footer">
                <?php include "partial/footer.php"; ?>
            </footer>
        </div><!-- ./wrapper -->
        
        <!-- modal ubah password -->
        <div class="modal fade modal-center" id="modal-edit-password" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="form-edit-password" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>    
                            <h4 class="modal-title" id="modalLabel">Ubah Password</h4>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>

                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= strtoupper($dtSiswa['nmSiswa']) ?>" readonly autocomplete="username">
                            </div>

                            <div class="form-group">
                                <label for="password_lama">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_lama" name="password_lama" required autocomplete="new-password">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default toggle-password" type="button" data-target="#password_lama">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_baru">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_baru" name="password_baru" required autocomplete="new-password">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default toggle-password" type="button" data-target="#password_baru">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Perbarui</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- modal lihat pdf atau gambar -->
        <div class="modal fade modal-center" id="modal-pdf-images" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="title-pdf-images"></h4>
                    </div>
                    <div class="modal-body text-center">
                        <div id="content-pdf-images"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>                            
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery UI 1.11.4 -->
        <script src="assets/plugins/jQueryUI/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/dist/js/app.min.js"></script>
        
        <script>
            $(document).on('click', '.btn-edit-password', function(e) {
                e.preventDefault();
                $('#modal-edit-password').modal('show');
            });  

            $('#form-edit-password').submit(function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: 'data?act=' + encodeURIComponent('<?= encrypt('password') ?>'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false, 
                    dataType: 'json', 
                    success: function(resp) {
                        if (!resp.status){
                            Swal.fire({
                                title: "Gagal",
                                text: resp.message,
                                icon: "error"
                            });
                        }else{
                            Swal.fire({
                                title: "Sukses",
                                text: resp.message,
                                icon: "success"
                            });
                            $('#modal-edit-password').modal('hide');
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: "Gagal",
                            text: "Terjadi kesalahan, silahkan refresh halaman ini.",
                            icon: "error"
                        });
                    }
                })
            });

            $(document).on('click', '.toggle-password', function() {
                const targetInput = $($(this).data('target'));
                const icon = $(this).find('i');

                if (targetInput.attr('type') === 'password') {
                    targetInput.attr('type', 'text');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    targetInput.attr('type', 'password');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });

            $(document).on('click', '.btn-pdf-images', function(e) {
                e.preventDefault();
                var file = $(this).data('file');
                var ext = $(this).data('ext');
                var title = $(this).data('title');
                var content = '';

                if (ext == 'pdf'){
                    content = '<embed src="' + file + '" type="application/pdf" width="100%" height="500px">';
                }else if (['jpg', 'jpeg', 'png'].includes(ext)) {
                    content = '<img src="' + file + '" alt="Bukti Transfer" style="max-width:100%; height:auto;">';
                }
                $('#title-pdf-images').text(title);
                $('#content-pdf-images').html(content);
                $('#modal-pdf-images').modal('show');
            });

            function hanyaAngka(evt) {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                // Hanya izinkan angka (0-9)
                if (charCode < 48 || charCode > 57) {
                    evt.preventDefault();
                    return false;
                }
                return true;
            }

            flatpickr(".class-date-picker", {
                locale: 'id',
                enableTime: false,
                dateFormat: "Y-m-d"
            });
        </script>
 
        <?php 
            if (isset($_SESSION['notif'])){
                if ($_SESSION['notif'] == 'success-login'){
                    echo '<script>
                            Swal.fire({
                                title: "Sukses",
                                text: "Selamat datang '.strtoupper($dtSiswa['nmSiswa']).'",
                                icon: "success"
                            });
                        </script>';
                }
                unset($_SESSION['notif']);
            }
        ?>
    </body>

    </html>