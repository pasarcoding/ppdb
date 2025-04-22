<?php 
    function checkLogin($username, $password, $remember)
    {
        global $conn;

        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        
        $query = mysqli_query($conn, "SELECT * FROM siswa WHERE nik_siswa = '$username' LIMIT 1");
        $siswa = mysqli_fetch_assoc($query);

        if ($siswa && password_verify($password, $siswa['password_ppdb'])) {
            $_SESSION['siswa'] = encrypt($siswa['idSiswa']);

            if ($remember) {
                setcookie('ppdb-siswa', encrypt($siswa['idSiswa']), time() + (86400 * 30), "/");
            }

            return true;
        }

        return false;
    }

    function isLogin()
    {
        global $conn;
        
        $idSiswa = null;
        if (isset($_SESSION['siswa'])) {
            $idSiswa = decrypt($_SESSION['siswa']);
        } elseif (isset($_COOKIE['ppdb-siswa'])) {
            $idSiswa = decrypt($_COOKIE['ppdb-siswa']);
        }

        if (!empty($idSiswa)){
            $query = mysqli_query($conn, "SELECT * FROM siswa WHERE idSiswa = '$idSiswa' LIMIT 1");
            $siswa = mysqli_fetch_assoc($query);

            if ($siswa) {
                $_SESSION['siswa'] = encrypt($siswa['idSiswa']);
                return true;
            }
        }

        return false;
    }


    function isLogout()
    {
        session_unset();
        session_destroy();
        setcookie('ppdb-siswa', '', time() - 3600, "/");
        echo "<script>document.location='../login';</script>";
    }
?>