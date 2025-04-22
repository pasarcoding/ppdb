<?php 
    session_start();
    error_reporting(0);
    include '../config/koneksi.php';
    include '../config/enkripsi_deskripsi.php';

    $session_csrf = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
    $csrf_token = isset($_POST['token']) ? $_POST['token'] : '';
    $act = isset($_GET['act']) ? decrypt($_GET['act']) : '';
    $id = isset($_POST['id']) ? decrypt($_POST['id']) : '';

    // jika token tidak valid
    if (empty($session_csrf) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        echo json_encode([
            'status' => false,
            'message' => 'Token tidak valid, silahkan refresh halaman ini.'
        ]);
        exit;
    }

    if ($act == 'kabupaten'){
       
        $data = '<option value="">- PILIH KOTA/KABUPATEN -</option>';
        $query = mysqli_query($conn, "SELECT * FROM rb_kabupaten WHERE provinsi_id='$id' ORDER BY id ASC");
        while ($row = mysqli_fetch_assoc($query)) {
            $type = $row['type'] == 'Kota' ? 'Kota' : 'Kab';
            $data .= '<option value="' . encrypt($row['id']) . '">' . strtoupper($type.' '.$row['name']) . '</option>';
        }

        echo json_encode([
            'status' => true,
            'message' => 'Load kota/kabupaten success.',
            'data' => $data
        ]);
        exit;
    }

    if ($act == 'kecamatan'){
       
        $data = '<option value="">- PILIH KECAMATAN -</option>';
        $query = mysqli_query($conn, "SELECT * FROM rb_kecamatan WHERE kabupaten_id='$id' ORDER BY id ASC");
        while ($row = mysqli_fetch_assoc($query)) {
            $data .= '<option value="' . encrypt($row['id']) . '">' . strtoupper($row['name']) . '</option>';
        }

        echo json_encode([
            'status' => true,
            'message' => 'Load kecamatan success.',
            'data' => $data
        ]);
        exit;
    }

    if ($act == 'kelurahan'){
       
        $data = '<option value="">- PILIH KELURAHAN -</option>';
        $query = mysqli_query($conn, "SELECT * FROM rb_kelurahan WHERE kecamatan_id='$id' ORDER BY id ASC");
        while ($row = mysqli_fetch_assoc($query)) {
            $data .= '<option value="' . encrypt($row['id']) . '">' . strtoupper($row['name']) . '</option>';
        }

        echo json_encode([
            'status' => true,
            'message' => 'Load kelurahan success.',
            'data' => $data
        ]);
        exit;
    }
?>