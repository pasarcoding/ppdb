<?php
    session_start();
    error_reporting(0);
    include '../config/koneksi.php';
    include '../config/enkripsi_deskripsi.php';

    $session_csrf = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
    $csrf_token = isset($_POST['token']) ? $_POST['token'] : '';
    $act = isset($_GET['act']) ? decrypt($_GET['act']) : '';
    $idSiswa = isset($_SESSION['siswa']) ? decrypt($_SESSION['siswa']) : '';
    

    // jika token tidak valid
    if (empty($session_csrf) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        echo json_encode([
            'status' => false,
            'message' => 'Token tidak valid, silahkan refresh halaman ini.'
        ]);
        exit;
    }
    
    $dtSiswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM siswa WHERE idSiswa = '$idSiswa' LIMIT 1"));

    if ($act === 'read') {
        $result = mysqli_query($conn, "SELECT * FROM ppdb_prestasi WHERE idSiswa='$idSiswa'");
        $data = [];
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $row['no'] = $no++;
            $row['id'] = encrypt($row['id']);
            $row['nama'] = $row['nama'];
            $row['file'] = $row['file'];
            $data[] = $row;
        }
        echo json_encode(['data' => $data]);
        exit;
    } 

    if ($act === 'tambah' || $act === 'ubah') {
        $id = decrypt($_POST['id']) ?? '';
        $nama = mysqli_real_escape_string($conn, $_POST['nama_prestasi']);
        $filePath = '';

        if (empty($nama)){
            echo json_encode([
                'status' => false,
                'message' => 'Nama prestasi wajib diisi.',
            ]);
            exit();
        }

        if (!empty($_FILES['file_prestasi']['name'])) {
            $ext = strtolower(pathinfo($_FILES['file_prestasi']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['pdf'])) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Format file bukti prestasi hanya PDF.',
                ]);
                exit();
            }
            if ($_FILES['file_prestasi']['size'] > 2 * 1024 * 1024) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Ukuran file bukti prestasi 2 mb.',
                ]);
                exit;
            }

            $filePath = 'assets/images/uploads/'.$dtSiswa['no_pendaftaran'].'-'.$nama.'-'. time().'.'.$ext;
            move_uploaded_file($_FILES['file_prestasi']['tmp_name'], '../'.$filePath);
        }

        if ($act === 'tambah') {
            $query = "INSERT INTO ppdb_prestasi (idSiswa, nama, file) VALUES ('$idSiswa', '$nama', '$filePath')";
        } else {
            if ($filePath) {
                $query = "UPDATE ppdb_prestasi SET nama='$nama', file='$filePath' WHERE id='$id'";
            } else {
                $query = "UPDATE ppdb_prestasi SET nama='$nama' WHERE id='$id'";
            }
        }

        mysqli_query($conn, $query);
        
        echo json_encode([
            'status' => true,
            'message' => 'Data berhasil di'.($act == 'tambah' ? 'tambahkan' : 'perbarui').'.',
        ]);
        exit;
    } 
    
    if ($act === 'hapus') {
        $id = decrypt($_POST['id']);
        $get = mysqli_fetch_assoc(mysqli_query($conn, "SELECT file FROM ppdb_prestasi WHERE id='$id'"));
        if (empty($get['file'])){
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ]);
            exit;
        }

        if (!empty($get['file']) && file_exists('../'.$get['file'])) {
            unlink('../'.$get['file']);
        }
        mysqli_query($conn, "DELETE FROM ppdb_prestasi WHERE id='$id'");
        echo json_encode([
            'status' => true,
            'message' => 'Data berhasil dihapus.',
        ]);
        exit;
    } 

    if ($act === 'edit') {
        $id = decrypt($_POST['id']);
        $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ppdb_prestasi WHERE id='$id'"));
       
        if (empty($data['file'])){
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ]);
            exit;
        }

        $data['id'] = encrypt($data['id']);

        echo json_encode([
            'status' => true,
            'message' => 'Data ditemukan.',
            'data' => $data
        ]);
        exit();
    }
?>