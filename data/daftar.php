<?php 
    session_start();
    error_reporting(0);
    include '../config/koneksi.php';
    include '../config/enkripsi_deskripsi.php';
    include '../config/fungsi_indotgl.php';
    include '../config/library.php';
    include '../config/fungsi_wa.php';

    $session_csrf = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
    $csrf_token = isset($_POST['token']) ? $_POST['token'] : '';
    $act = isset($_GET['act']) ? decrypt($_GET['act']) : '';
    $dateNow = date('Y-m-d');

    $ta_aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE aktif='Y' LIMIT 1"));

    // jika token tidak valid
    if (empty($session_csrf) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        echo json_encode([
            'status' => false,
            'message' => 'Token tidak valid, silahkan refresh halaman ini.'
        ]);
        exit;
    }

    if ($act == 'jadwal'){
        $dtGelombangAktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ppdb_gelombang WHERE mulai <= '$dateNow' AND selesai >= '$dateNow' AND idTahunAjaran='$ta_aktif[idTahunAjaran]' LIMIT 1"));
        if (!$dtGelombangAktif){
            echo json_encode([
                'status' => false,
                'message' => 'Gelombang pendaftaran telah ditutup.',
            ]);
            exit;
        }
        
        $countSiswaGelombang = mysqli_num_rows(mysqli_query($conn, "SELECT idSiswa FROM siswa WHERE id_gelombang='$dtGelombangAktif[idGlombang]'"));
        if ($countSiswaGelombang == $dtGelombangAktif['kuota']){
            echo json_encode([
                'status' => false,
                'message' => 'Kuota pendaftaran telah penuh.',
            ]);
            exit;
        }

        echo json_encode([
            'status' => true,
            'message' => 'Jadwal pendaftaran tersedia.',
            'link' => './daftar'
        ]);
        exit;
    }

    if ($act == 'simpan-pendaftaran'){
        
        $fieldWajib = [
            'tanggal_pendaftaran', 'jalur_pendaftaran', 'tahun_ajaran_atau_gelombang', 'biaya', 'asal_sekolah', 'nama_asal_sekolah',
            'nama_siswa', 'nik_siswa', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama_siswa', 'jumlah_saudara', 'urutan_anak', 'kewarganegaraan', 'tempat_tinggal', 'moda_transportasi', 'hobi', 'no_kartu_keluarga',
            'nama_ayah', 'no_hp_ayah', 'nama_ibu',
            'provinsi', 'kota_atau_kabupaten', 'kecamatan', 'kelurahan', 'rt', 'rw', 'alamat',
            'tinggi_badan', 'berat_badan', 'jarak_tempat_tinggal_ke_sekolah', 'waktu_tempuh_ke_sekolah'
        ];

        $fieldAngka = [
            'nisn_siswa', 'nik_siswa', 'jumlah_saudara', 'urutan_anak', 'no_kartu_keluarga', 'nik_ayah', 'no_hp_ayah', 'nik_ibu', 'no_hp_ibu', 'rt', 'rw', 'tinggi_badan', 'berat_badan'
        ];

        $field16Digit = [
            'nik_siswa', 'no_kartu_keluarga', 'nik_ayah', 'nik_ibu'
        ];

        $fieldEncrypt = [
            'jalur_pendaftaran', 
            'agama_siswa', 
            'pendidikan_terakhir_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'pendidikan_terakhir_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
            'provinsi', 'kota_atau_kabupaten', 'kecamatan', 'kelurahan'
        ];

        foreach ($_POST as $key => $value) {
            $$key = mysqli_real_escape_string($conn, in_array($key, $fieldEncrypt) ? decrypt($value) : $value);

            // Wajib diisi
            if ($value === '' && in_array($key, $fieldWajib)) {
                $nameKey = implode(' ', pisahField($key));
                echo json_encode([
                    'status' => false,
                    'message' => ucwords($nameKey).' wajib diisi.',
                ]);
                exit;
            }

            // Hanya angka
            if ($value !== '' && in_array($key, $fieldAngka) && !ctype_digit(strval($value))) {
                $nameKey = implode(' ', pisahField($key));
                echo json_encode([
                    'status' => false,
                    'message' => ucwords($nameKey).' hanya boleh angka.',
                ]);
                exit;
            }

            // Harus 16 digit
            if ($value !== '' && in_array($key, $field16Digit) && strlen($value) !== 16) {
                $nameKey = implode(' ', pisahField($key));
                echo json_encode([
                    'status' => false,
                    'message' => ucwords($nameKey).' harus 16 digit.',
                ]);
                exit;
            }
        }

        // Validasi file `foto_siswa`
        if (!isset($_FILES['foto_siswa']) || $_FILES['foto_siswa']['error'] === 4) {
            echo json_encode([
                'status' => false,
                'message' => 'Foto siswa wajib diisi.'
            ]);
            exit;
        }

        $fileFotoSiswa = $_FILES['foto_siswa'];
        $maxSizeFotoSiswa = 2 * 1024 * 1024;
        $allowedExtFotoSiswa = ['jpg', 'jpeg', 'png'];
        $extFotoSiswa = strtolower(pathinfo($fileFotoSiswa['name'], PATHINFO_EXTENSION));

        if (!in_array($extFotoSiswa, $allowedExtFotoSiswa)) {
            echo json_encode([
                'status' => false,
                'message' => 'Foto siswa hanya boleh JPG, JPEG, atau PNG.'
            ]);
            exit;
        }

        if ($fileFotoSiswa['size'] > $maxSizeFotoSiswa) {
            echo json_encode([
                'status' => false,
                'message' => 'Ukuran foto siswa maksimal 2MB.'
            ]);
            exit;
        }

        // Validasi file `upload_file_kartu_keluarga`
        if (!isset($_FILES['upload_file_kartu_keluarga']) || $_FILES['upload_file_kartu_keluarga']['error'] === 4) {
            echo json_encode([
                'status' => false,
                'message' => 'File kartu keluarga wajib diisi.'
            ]);
            exit;
        }

        $fileKK = $_FILES['upload_file_kartu_keluarga'];
        $maxSizeFileKK = 5 * 1024 * 1024;
        $allowedExtFileKK = ['pdf', 'jpg', 'jpeg', 'png'];
        $extFileKK = strtolower(pathinfo($fileKK['name'], PATHINFO_EXTENSION));

        if (!in_array($extFileKK, $allowedExtFileKK)) {
            echo json_encode([
                'status' => false,
                'message' => 'File kartu keluarga hanya boleh PDF, JPG, JPEG, atau PNG.'
            ]);
            exit;
        }

        if ($fileKK['size'] > $maxSizeFileKK) {
            echo json_encode([
                'status' => false,
                'message' => 'Ukuran file kartu keluarga maksimal 5MB.'
            ]);
            exit;
        }

        // Validasi file `foto_tanda_tangan_ayah_atau_ibu`
        if (!isset($_FILES['foto_tanda_tangan_ayah_atau_ibu']) || $_FILES['foto_tanda_tangan_ayah_atau_ibu']['error'] === 4) {
            echo json_encode([
                'status' => false,
                'message' => 'Foto tanda tangan ayah atau ibu wajib diisi.'
            ]);
            exit;
        }

        $fileFotoTtdOrtu = $_FILES['foto_tanda_tangan_ayah_atau_ibu'];
        $maxSizeFotoTtdOrtu = 2 * 1024 * 1024;
        $allowedExtFotoTtdOrtu = ['jpg', 'jpeg', 'png'];
        $extFotoTtdOrtu = strtolower(pathinfo($fileFotoTtdOrtu['name'], PATHINFO_EXTENSION));

        if (!in_array($extFotoTtdOrtu, $allowedExtFotoTtdOrtu)) {
            echo json_encode([
                'status' => false,
                'message' => 'Foto tanda tangan ayah atau ibu hanya boleh JPG, JPEG, atau PNG.'
            ]);
            exit;
        }

        if ($fileFotoTtdOrtu['size'] > $maxSizeFotoTtdOrtu) {
            echo json_encode([
                'status' => false,
                'message' => 'Ukuran foto tanda tangan ayah atau ibu maksimal 2MB.'
            ]);
            exit;
        }

        // checkbox pernyataan
        if (empty($_POST['pernyataan'])){
            echo json_encode([
                'status' => false,
                'message' => 'Pernyataan wajib diisi.'
            ]);
            exit;
        }

        //get gelombang aktif
        $dtGelombangAktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ppdb_gelombang WHERE mulai <= '$dateNow' AND selesai >= '$dateNow' AND idTahunAjaran='$ta_aktif[idTahunAjaran]' LIMIT 1"));
        $gelombang = $dtGelombangAktif['idGlombang'];
        $biaya = $dtGelombangAktif['biaya'];
        // generate no pendaftaran
        $dtSiswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(no_pendaftaran) as max_kode FROM siswa WHERE untukAjaran='$ta_aktif[idTahunAjaran]'"));
        if (empty($dtSiswa['max_kode'])){
            $urutan = 1;
        }else{
            $kode_terakhir = $dtSiswa['max_kode'];
            $urutan = (int) substr($kode_terakhir, 4, 4);
            $urutan++;
        }
        $no_pendaftaran = 'PPDB'.sprintf("%05s", $urutan);

        // variabel setting
        $tanggalPendaftaran = $dateNow;
        $tahunAjaran = $ta_aktif['idTahunAjaran'];
        $passwordHash = password_hash($no_kartu_keluarga, PASSWORD_DEFAULT);
        
        // foto siswa, file kk, ttd ortu
        $uploadDir = "assets/images/uploads/";

        if (!empty($fileFotoSiswa['name'])){
            $ext = pathinfo($fileFotoSiswa['name'], PATHINFO_EXTENSION);
            $newFileName = 'foto-'.$no_pendaftaran.'-'.time().".".$ext;
            $targetFotoSiswa = $uploadDir . $newFileName;
            move_uploaded_file($fileFotoSiswa['tmp_name'], '../'.$targetFotoSiswa);
        }
    
        if (!empty($fileKK['name'])){
            $ext = pathinfo($fileKK['name'], PATHINFO_EXTENSION);
            $newFileName = 'file-kk-'.$no_pendaftaran.'-'.time().".".$ext;
            $targetFileKK = $uploadDir . $newFileName;
            move_uploaded_file($fileKK['tmp_name'], '../'.$targetFileKK);
        }
        
        if (!empty($fileFotoTtdOrtu['name'])){
            $ext = pathinfo($fileFotoTtdOrtu['name'], PATHINFO_EXTENSION);
            $newFileName = 'foto-ttd-'.$no_pendaftaran.'-'.time().".".$ext;
            $targetFotoTtdOrtu = $uploadDir . $newFileName;
            move_uploaded_file($fileFotoTtdOrtu['tmp_name'], '../'.$targetFotoTtdOrtu);
        }
        
        // alamat
        $dtProvinsi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_provinsi WHERE id='$provinsi' LIMIT 1"));
        $nmProvinsi = $dtProvinsi['name'];
        $dtKabupaten = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_kabupaten WHERE id='$kota_atau_kabupaten' LIMIT 1"));
        $nmKabupaten = $dtKabupaten['type'].' '.$dtKabupaten['name'];
        $dtKecamatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_kecamatan WHERE id='$kecamatan' LIMIT 1"));
        $nmKecamatan = $dtKecamatan['name'];
        $dtKelurahan= mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_kelurahan WHERE id='$kelurahan' LIMIT 1"));
        $nmKelurahan = $dtKelurahan['name'];
        $rtRw = $rt.' '.$rw;

        // cek nik siswa
        $cekNik = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE nik_siswa='$nik_siswa' AND nisSiswa IS NULL AND untukAjaran='$ta_aktif[idTahunAjaran]' AND id_gelombang='$gelombang'"));
        if ($cekNik !== 0){
            echo json_encode([
                'status' => false,
                'message' => 'NIK siswa telah terdaftar.',
            ]);
        }

        //simpan data
        $query = mysqli_query($conn, "
            INSERT INTO siswa (
                no_pendaftaran, password_ppdb,
                tanggal_pendaftaran, jalur_pendaftaran, gelombang_tahun_ajaran, untukAjaran, id_gelombang, tipe_asal_sekolah, asal_sekolah, kecamatan_sekolah_asal, 
                nisnSiswa, nmSiswa, foto_siswa, nik_siswa, tempat_lahir, tglLahirSiswa, jkSiswa, agamaSiswa, jml_saudara, urutan_anak, kewarganegaraan, no_reg_akta_kelahiran, tempat_tinggal, moda_transportasi, hobi, file_kk, no_kk, nama_kepala_keluarga,
                nik_ayah, nama_ayah, noHpOrtu, email_ayah_ibu, tmpt_lahir_ayah, tgl_lahir_ayah, pendidikan_terakhir_ayah, pekerjaan_ayah, penghasilan_ayah, nik_ibu, nama_ibu, noHpIbu, tmpt_lahir_ibu, tgl_lahir_ibu, pendidikan_terakhir_ibu, pekerjaan_ibu, penghasilan_ibu, ttdOrtu,   
                provinsi, kab_kota, kecamatan, kelurahan, rt_rw, koordinat_lintang, koordinat_bujur, alamatOrtu,
                tinggi_badan, berat_badan, jarak_tempuh, waktu_tempuh, 
            )
            VALUES (
                '$no_pendaftaran', '$passwordHash',
                '$tanggalPendaftaran', '$jalur_pendaftaran', '$tahun_ajaran_atau_gelombang', '$tahunAjaran', '$gelombang', '$asal_sekolah', '$nama_asal_sekolah', '$kecamatan_TK_atau_RA_asal',
                '$nisn_siswa', '$nama_siswa', '$targetFotoSiswa', '$nik_siswa', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$agama_siswa', '$jumlah_saudara', '$urutan_anak', '$kewarganegaraan', '$no_reg_akta_kelahiran', '$tempat_tinggal', '$moda_transportasi', '$hobi', '$targetFileKK', '$no_kartu_keluarga', '$nama_kepala_keluarga',
                '$nik_ayah', '$nama_ayah', '$no_hp_ayah', '$email_ayah_atau_ibu', '$tempat_lahir_ayah', '$tanggal_lahir_ayah', '$pendidikan_terakhir_ayah', '$pekerjaan_ayah', '$penghasilan_ayah', '$nik_ibu', '$nama_ibu', '$no_hp_ibu', '$tempat_lahir_ibu', '$tanggal_lahir_ibu', '$pendidikan_terakhir_ibu', '$pekerjaan_ibu', '$penghasilan_ibu', '$targetFotoTtdOrtu',
                '$nmProvinsi', '$nmKabupaten', '$nmKecamatan', '$nmKelurahan', '$rtRw', '$koordinat_lintang', '$koordinat_bujur', '$alamat',
                '$tinggi_badan', '$berat_badan', '$jarak_tempat_tinggal_ke_sekolah', '$waktu_tempuh_ke_sekolah', 
            )
        ");

        if ($query){
            $idSiswa = mysqli_insert_id($conn);
            mysqli_query($conn, "
                INSERT INTO ppdb_status (idGlombang, idSiswa, statusPendaftaran) 
                VALUES ('$gelombang', '$idSiswa', 'PROSES VERIFIKASI')
            ");

            // kirim notif akun whatsapp
            $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
            $linkSend = $idt['link_one_sender'];
            $apiKey = $idt['token'];
            $sender = $idt['wa'];
            $number = $no_hp_ayah;
            $linkLogin = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? "https" : "http").'://'.$_SERVER['HTTP_HOST'].'/login';
            $message = "Assalamu'alaikum Wr. Wb. Informasi Akun PPDB, ".$idt['nmSekolah']."

Calon Siswa a/n ".strtoupper($nama_siswa)."

NIK SISWA: ".$nik_siswa."
Password: ".$no_kartu_keluarga."

Harap segera login untuk periksa kembali biodata calon peserta didik, upload bukti pembayaran dan cetak formulir pendaftaran

".$linkLogin;
            send_wa($linkSend, $apiKey, $sender, $number, $message);

            $_SESSION['notif'] = 'success-daftar';
            echo json_encode([
                'status' => true,
                'message' => 'Data berhail disimpan.',
                'link' => './jadwal'
            ]);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'Terjadi kesalahan,silahkan coba lagi.',
            ]);
        }
        exit;
    }

    function pisahField($string) {
        return explode('_', $string);
    }
?>