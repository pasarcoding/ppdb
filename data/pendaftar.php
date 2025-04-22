<?php 
    session_start();
    error_reporting(0);
    include '../config/koneksi.php';
    include '../config/enkripsi_deskripsi.php';

    $session_csrf = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
    $csrf_token = isset($_POST['token']) ? $_POST['token'] : '';
    $act = isset($_GET['act']) ? decrypt($_GET['act']) : '';

    $ta_aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE aktif='Y' LIMIT 1"));

    // jika token tidak valid
    if (empty($session_csrf) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        echo json_encode([
            'status' => false,
            'message' => 'Token tidak valid, silahkan refresh halaman ini.'
        ]);
        exit;
    }

    if ($act == 'data') {
        $request = $_REQUEST;
        $columns = [
            0 => 'siswa.idSiswa',
            1 => 'siswa.no_pendaftaran',
            2 => 'siswa.nmSiswa',
            3 => 'siswa.asal_sekolah',
            4 => 'ppdb_status.statusPendafataran'
        ];

        // Total data tanpa filter
        $sql = "SELECT siswa.*, ppdb_status.statusPendafataran 
                FROM siswa 
                INNER JOIN ppdb_status ON siswa.idSiswa=ppdb_status.idSiswa AND siswa.id_gelombang=ppdb_status.idGlombang 
                WHERE siswa.nisSiswa IS NULL AND siswa.untukAjaran='$ta_aktif[idTahunAjaran]'";
        $query = mysqli_query($conn, $sql);
        $totalData = mysqli_num_rows($query);
        $totalFiltered = $totalData;

        // Search
        $search = $request['search']['value'];
        $where = "";
        if (!empty($search)) {
            $where .= " AND (siswa.no_pendaftaran LIKE '%$search%' 
                        OR siswa.nmSiswa LIKE '%$search%' 
                        OR siswa.asal_sekolah LIKE '%$search%' 
                        OR ppdb_status.statusPendafataran LIKE '%$search%')";
        }

        // Hitung filtered
        $sqlFiltered = $sql.$where;
        $queryFiltered = mysqli_query($conn, $sqlFiltered);
        $totalFiltered = mysqli_num_rows($queryFiltered);

        // Order & Limit
        $orderColumn = $columns[$request['order'][0]['column']];
        $orderDir = $request['order'][0]['dir'];
        $start = $request['start'];
        $length = $request['length'];

        $sqlFinal = "$sqlFiltered ORDER BY $orderColumn $orderDir LIMIT $start, $length";
        $queryFinal = mysqli_query($conn, $sqlFinal);

        $data = [];
        $no = $start + 1;
        while ($row = mysqli_fetch_assoc($queryFinal)) {

            switch ($row['statusPendafataran']){
                case 'TIDAK DITERIMA':
                    $status = '<span class="badge badge-danger">TIDAK DITERIMA</span>';
                    break;
                case 'DITERIMA':
                    $status = '<span class="badge badge-success">DITERIMA</span>';
                    break;
                case 'CADANGAN':
                    $status = '<span class="badge badge-secondary">CADANGAN</span>';
                    break;
                default:
                    $status = '<span class="badge badge-primary">PROSES VERIFIKASI</span>';
                    break;
            }
 
            $data[] = [
                'no' => $no++,
                'no_pendaftaran' => $row['no_pendaftaran'],
                'nama_lengkap' => $row['nmSiswa'],
                'asal_sekolah' => $row['asal_sekolah'],
                'status_pendaftaran' => $status
            ];
        }

        $response = [
            "draw" => intval($request['draw']),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ];

        echo json_encode($response);
        exit;
    }
?>