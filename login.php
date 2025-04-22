<?php include 'header.php' ?>

<link rel="stylesheet" href="assets/css/style-login.css">

<?php 
    // jika sudah login
    if (isLogin()){
        echo "<script>document.location='./siswa';</script>";
        exit;
    }
    
    // cek login
    if (isset($_POST['login'])){
        $nik = $_POST['nik'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? true : false;
        $session_csrf = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
        $csrf_token = isset($_POST['token']) ? $_POST['token'] : '';
        
        if (empty($session_csrf) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            $_SESSION['notif'] = 'error-token';
            echo "<script>document.location='./login';</script>";
            exit;
        }
        
        $isLogin = checkLogin($nik, $password, $remember);
        if ($isLogin){
            $_SESSION['notif'] = 'success-login';
            echo "<script>document.location='./siswa/';</script>";
        }else{
            $_SESSION['notif'] = 'error-login';
            echo "<script>document.location='./login';</script>";
        }
        exit;
    }
?>

<body>
    <div class="container">
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center w-100 py-5">

            <!-- Gambar -->
            <div class="text-center mb-4 mb-lg-0 pr-lg-5">
                <img src="assets/images/login.png" alt="Gambar" class="img-fluid">
            </div>

            <!-- Form Login -->
            <div class="login-box">
                <h4 class="text-center login-title">Login Akun PPDB</h4>
                <form method="POST">
                    <input type="hidden" name="token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group position-relative">
                        <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK Siswa" autofocus autocomplete="new-username" aria-label="NIK Siswa" required>
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="form-group position-relative">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password" autocomplete="new-password" aria-label="Password" required>
                        <i class="fas fa-eye-slash" id="toggle-password" onclick="togglePassword()"></i>
                    </div>

                    <div class="form-group d-flex justify-content-between align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                            <label class="custom-control-label" for="remember">Ingat Saya</label>
                        </div>
                        <a href="#" class="small text-muted" data-toggle="modal" data-target="#modal-lupa-password">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" name="login">Log In</button>
                    <a href="./" class="btn btn-outline-primary btn-block mt-2">Kembali ke Halaman Utama</a>
                </form>
            </div>
        </div>
    </div>

    <!--====== Modal Reset Pasword ======-->
    <div class="modal fade" id="modal-lupa-password" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="Masukkan NIK Siswa">
                    <span class="text-muted fw-italic small mt-1">Kami akan mengirimkan link reset password akun anda, silahkan segera cek WA Ayah atau WA Ibu</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Kirim Notifikasis Reset Password</button>
                </div>
            </div>
        </div>
    </div>

    <!--====== Jquery js ======-->
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>

    <!--====== Bootstrap js ======-->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main-login.js" defer></script>
    
    <?php 
        if (isset($_SESSION['notif'])){
            if ($_SESSION['notif'] == 'error-login'){
                echo '<script>
                        Swal.fire({
                            title: "Gagal",
                            text: "Nik atau password anda salah.",
                            icon: "error"
                        });
                     </script>';
            }elseif ($_SESSION['notif'] == 'error-token'){
                echo '<script>
                        Swal.fire({
                            title: "Gagal",
                            text: "Token tidak valid, silahkan refresh halaman ini.",
                            icon: "error"
                        });
                     </script>';
            }
            unset($_SESSION['notif']);
        }
    ?>
</body>

</html>
