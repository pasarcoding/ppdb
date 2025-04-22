<?php 
    session_start();
    error_reporting(0);
    include '../config/koneksi.php';
    include '../config/enkripsi_deskripsi.php';
    include '../config/fungsi_wa.php';

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

    $dtSiswa = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT 
            sws.*, 
            stts.statusPendafataran, stts.statusPemberkasan, stts.statusPembayaran, 
            brks.formulir, brks.suratPernyataan, brks.asliKTP, brks.asliAktaKelahiran, 
            brks.copyKTP, brks.copyKK, brks.copyAktaKelahiran, brks.copyDTKS
        FROM siswa sws 
        LEFT JOIN ppdb_status stts 
            ON sws.idSiswa = stts.idSiswa AND sws.id_gelombang = stts.idGlombang 
        LEFT JOIN ppdb_pemberkasan brks 
            ON sws.idSiswa = brks.idSiswa AND sws.id_gelombang = brks.idGlombang 
        WHERE sws.idSiswa = '$idSiswa' 
        LIMIT 1
    "));

    if ($act == 'password'){
        $passwordLama = $_POST['password_lama'];
        $passwordBaru = $_POST['password_baru'];
        
        if (strlen($passwordBaru) < 8){
            echo json_encode([
                'status' => false,
                'message' => 'Minimal 8 karakter untuk password.',
            ]);
            exit;
        }

        if (!password_verify($passwordLama, $dtSiswa['password_ppdb'])){
            echo json_encode([
                'status' => false,
                'message' => 'Password lama anda salah.',
            ]);
            exit;
        }

        $hashPasswordBaru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE siswa SET password_ppdb='$hashPasswordBaru' WHERE idSiswa='$idSiswa'");

        echo json_encode([
            'status' => true,
            'message' => 'Password berhasil diperbarui.',
        ]);
        exit;
    }

    if ($act == 'foto'){
        if (!isset($_FILES['upload_foto_siswa']) || $_FILES['upload_foto_siswa']['error'] === 4) {
            echo json_encode([
                'status' => false,
                'message' => 'Foto siswa wajib diisi.'
            ]);
            exit;
        }

        $fileFotoSiswa = $_FILES['upload_foto_siswa'];
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

        // foto siswa dan file kk
        $uploadDir = "assets/images/uploads/";

        if (!empty($fileFotoSiswa['name'])){
            $ext = pathinfo($fileFotoSiswa['name'], PATHINFO_EXTENSION);
            $newFileName = 'foto-'.$dtSiswa['no_pendaftaran'].'-'.time().".".$ext;
            $targetFotoSiswa = $uploadDir . $newFileName;
            if (move_uploaded_file($fileFotoSiswa['tmp_name'], '../'.$targetFotoSiswa)) {
                if (!empty($dtSiswa['foto_siswa']) && file_exists('../'.$dtSiswa['foto_siswa'])){
                    unlink('../'.$dtSiswa['foto_siswa']);
                }

                mysqli_query($conn, "UPDATE siswa SET foto_siswa='$targetFotoSiswa' WHERE idSiswa='$idSiswa'");
            }
        }

        $sws = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto_siswa FROM siswa WHERE idSiswa='$idSiswa'"));
        echo json_encode([
            'status' => true,
            'message' => 'Foto berhasil diperbarui.',
            'foto' => '../'.$sws['foto_siswa']
        ]);
        exit;
    }

    if ($act == 'bukti-bayar'){
        if (!isset($_FILES['upload_bukti_transfer']) || $_FILES['upload_bukti_transfer']['error'] === 4) {
            echo json_encode([
                'status' => false,
                'message' => 'File bukti transfer wajib diisi.'
            ]);
            exit;
        }

        $fileBuktiTf= $_FILES['upload_bukti_transfer'];
        $maxSizeFileBuktiTf = 2 * 1024 * 1024;
        $allowedExtFileBuktiTf = ['jpg', 'jpeg', 'png'];
        $extFileBuktiTf = strtolower(pathinfo($fileBuktiTf['name'], PATHINFO_EXTENSION));

        if (!in_array($extFileBuktiTf, $allowedExtFileBuktiTf)) {
            echo json_encode([
                'status' => false,
                'message' => 'File bukti transfer hanya boleh JPG, JPEG, atau PNG.'
            ]);
            exit;
        }

        if ($fileBuktiTf['size'] > $maxSizeFileBuktiTf) {
            echo json_encode([
                'status' => false,
                'message' => 'Ukuran file bukti transfer maksimal 2MB.'
            ]);
            exit;
        }

        // foto siswa dan file kk
        $uploadDir = "assets/images/uploads/";

        if (!empty($fileBuktiTf['name'])){
            $ext = pathinfo($fileBuktiTf['name'], PATHINFO_EXTENSION);
            $newFileName = 'bukti-tf-'.$dtSiswa['no_pendaftaran'].'-'.time().".".$ext;
            $targetFileBuktiTf = $uploadDir . $newFileName;
            if (move_uploaded_file($fileBuktiTf['tmp_name'], '../'.$targetFileBuktiTf)) {
                if (!empty($dtSiswa['buktiTf']) && file_exists('../'.$dtSiswa['buktiTf'])){
                    unlink('../'.$dtSiswa['buktiTf']);
                }

                mysqli_query($conn, "UPDATE siswa SET buktiTf='$targetFileBuktiTf' WHERE idSiswa='$idSiswa'");
            }
        }

        
        // kirim notif whatsapp ke petugas
        $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
        $linkSend = $idt['link_one_sender'];
        $apiKey = $idt['token'];
        $sender = $idt['wa'];
        $qPetugas = mysqli_query($conn, "SELECT * FROM ppdb_petugas");
        if (mysqli_num_rows($qPetugas) != 0){
            while ($dt = mysqli_fetch_assoc($qPetugas)){
                $number = $dt['no_hp'];
                $message = "Assalamu'alaikum Wr. Wb. a.n ".$dtSiswa['no_pendaftaran']." - ".$dtSiswa['nmSiswa']." telah melakukan upload bukti pembayaran. Terima kasih."; 
                send_wa($linkSend, $apiKey, $sender, $number, $message);
            }
        }
        
        $sws = mysqli_fetch_assoc(mysqli_query($conn, "SELECT buktiTf FROM siswa WHERE idSiswa='$idSiswa'"));
        echo json_encode([
            'status' => true,
            'message' => 'File bukti transfer berhasil diupload.',
            'status_pembayaran' => $dtSiswa['statusPembayaran'],
            'tanggal_bayar' => $dtSiswa['tglBayarTf'] ?? '-',
            'file' => '../'.$sws['buktiTf'],
            'ext' => pathinfo($sws['buktiTf'], PATHINFO_EXTENSION)
        ]);
        exit;
    }

    if ($act == 'data-pendaftaran'){
        $fieldWajib = [
            'tanggal_pendaftaran', 'jalur_pendaftaran', 'tahun_ajaran_atau_gelombang', 'biaya', 'asal_sekolah', 'nama_asal_sekolah',
        ];

        $fieldAngka = [
            'npsn_sekolah'
        ];

        $field16Digit = [
            'npsn_sekolah'
        ];

        $fieldEncrypt = [
            'jalur_pendaftaran', 
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

            // Harus 8 digit
            if ($value !== '' && in_array($key, $field16Digit) && strlen($value) !== 8) {
                $nameKey = implode(' ', pisahField($key));
                echo json_encode([
                    'status' => false,
                    'message' => ucwords($nameKey).' harus 8 digit.',
                ]);
                exit;
            }
        }

        //update data
        $query = mysqli_query($conn, "
            UPDATE 
                siswa
            SET 
                jalur_pendaftaran='$jalur_pendaftaran',
                tipe_asal_sekolah='$asal_sekolah',
                npsn_sekolah='$npsn_sekolah',
                asal_sekolah='$nama_asal_sekolah',
                kecamatan_sekolah_asal='$kecamatan_TK_atau_RA_asal'
            WHERE
                idSiswa='$idSiswa'
        ");

        if ($query){
            echo json_encode([
                'status' => true,
                'message' => 'Data berhail diperbarui.',
            ]);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'Terjadi kesalahan, silahkan coba lagi.',
            ]);
        }
        exit;
    }

    if ($act == 'data-siswa'){
        $fieldWajib = [
            'nama_siswa', 'nik_siswa', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama_siswa', 'jumlah_saudara', 'urutan_anak', 'kewarganegaraan', 'tempat_tinggal', 'moda_transportasi', 'hobi', 'no_kartu_keluarga',
        ];

        $fieldAngka = [
            'nisn_siswa', 'nik_siswa', 'jumlah_saudara', 'urutan_anak', 'no_kartu_keluarga'
        ];

        $field16Digit = [
            'nik_siswa', 'no_kartu_keluarga'
        ];

        $fieldEncrypt = [
            'agama_siswa'
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
        
        // Validasi file `upload_file_kartu_keluarga`
        if (isset($_FILES['upload_file_kartu_keluarga']) && $_FILES['upload_file_kartu_keluarga']['error'] === UPLOAD_ERR_OK && $_FILES['upload_file_kartu_keluarga']['size'] > 0) {
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
            
            // file kk
            $uploadDir = "assets/images/uploads/";

            if (!empty($fileKK['name'])){
                $ext = pathinfo($fileKK['name'], PATHINFO_EXTENSION);
                $newFileName = 'file-kk-'.$dtSiswa['no_pendaftaran'].'-'.time().".".$ext;
                $targetFileKK = $uploadDir . $newFileName;
                if (move_uploaded_file($fileKK['tmp_name'], '../'.$targetFileKK)){
                    if (!empty($dtSiswa['file_kk']) && file_exists('../'.$dtSiswa['file_kk'])){
                        unlink('../'.$dtSiswa['file_kk']);
                    }
            
                    mysqli_query($conn, "
                        UPDATE 
                            siswa
                        SET 
                            file_kk='$targetFileKK'
                        WHERE
                            idSiswa='$idSiswa'
                    ");
                }
            }
            
        }

        //update data
        $query = mysqli_query($conn, "
            UPDATE 
                siswa
            SET 
                nisnSiswa='$nisn_siswa',
                nmSiswa='$nama_siswa',
                nik_siswa='$nik_siswa',
                tempat_lahir='$tempat_lahir',
                tglLahirSiswa='$tanggal_lahir',
                jkSiswa='$jenis_kelamin',
                agamaSiswa='$agama_siswa',
                jml_saudara='$jumlah_saudara',
                urutan_anak='$urutan_anak',
                kewarganegaraan='$kewarganegaraan',
                no_reg_akta_kelahiran='$no_reg_akta_kelahiran',
                tempat_tinggal='$tempat_tinggal',
                moda_transportasi='$moda_transportasi', 
                hobi='$hobi', 
                no_kk='$no_kartu_keluarga', 
                nama_kepala_keluarga='$nama_kepala_keluarga'
            WHERE
                idSiswa='$idSiswa'
        ");

        if ($query){
            $sws = mysqli_fetch_assoc(mysqli_query($conn, "SELECT file_kk FROM siswa WHERE idSiswa='$idSiswa'"));
            echo json_encode([
                'status' => true,
                'message' => 'Data berhail diperbarui.',
                'file' => '../'.$sws['file_kk'],
                'ext' => pathinfo($sws['file_kk'], PATHINFO_EXTENSION),
            ]);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'Terjadi kesalahan, silahkan coba lagi.',
            ]);
        }
        exit;
    }

    if ($act == 'data-ortu'){
        $fieldWajib = [
            'nama_ayah', 'no_hp_ayah', 'nama_ibu'
        ];

        $fieldAngka = [
            'nik_ayah', 'no_hp_ayah', 'nik_ibu', 'no_hp_ibu'
        ];

        $field16Digit = [
            'nik_ayah', 'nik_ibu'
        ];

        $fieldEncrypt = [
            'pendidikan_terakhir_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'pendidikan_terakhir_ibu', 'pekerjaan_ibu', 'penghasilan_ibu'
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

        // Validasi file `foto_tanda_tangan_ayah_atau_ibu`
        if (isset($_FILES['foto_tanda_tangan_ayah_atau_ibu']) && $_FILES['foto_tanda_tangan_ayah_atau_ibu']['error'] === UPLOAD_ERR_OK && $_FILES['foto_tanda_tangan_ayah_atau_ibu']['size'] > 0) {
            $fileTTDOrtu = $_FILES['foto_tanda_tangan_ayah_atau_ibu'];
            $maxSizeFileTTDOrtu = 2 * 1024 * 1024;
            $allowedExtFileTTDOrtu = ['pdf', 'jpg', 'jpeg', 'png'];
            $extFileTTDOrtu = strtolower(pathinfo($fileTTDOrtu['name'], PATHINFO_EXTENSION));

            if (!in_array($extFileTTDOrtu, $allowedExtFileTTDOrtu)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'File tanda tangan orang tua hanya boleh JPG, JPEG, atau PNG.'
                ]);
                exit;
            }

            if ($fileTTDOrtu['size'] > $maxSizeFileTTDOrtu) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Ukuran file kartu keluarga maksimal 2MB.'
                ]);
                exit;
            }
            
            // file kk
            $uploadDir = "assets/images/uploads/";

            if (!empty($fileTTDOrtu['name'])){
                $ext = pathinfo($fileTTDOrtu['name'], PATHINFO_EXTENSION);
                $newFileName = 'file-ttd-'.$dtSiswa['no_pendaftaran'].'-'.time().".".$ext;
                $targetFileTTDOrtu = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTTDOrtu['tmp_name'], '../'.$targetFileTTDOrtu)) {
                    if (!empty($dtSiswa['ttdOrtu']) && file_exists('../'.$dtSiswa['ttdOrtu'])) {
                        unlink('../'.$dtSiswa['ttdOrtu']);
                    }

                    mysqli_query($conn, "
                        UPDATE siswa SET ttdOrtu='$targetFileTTDOrtu'
                        WHERE idSiswa='$idSiswa'
                    ");
                }
            }
        }

        //update data
        $query = mysqli_query($conn, "
            UPDATE 
                siswa
            SET 
                nik_ayah='$nik_ayah',
                nama_ayah='$nama_ayah',
                noHpOrtu='$no_hp_ayah',
                email_ayah_ibu='$email_ayah_atau_ibu',
                tmpt_lahir_ayah='$tempat_lahir_ayah',
                tgl_lahir_ayah='$tanggal_lahir_ayah',
                pendidikan_terakhir_ayah='$pendidikan_terakhir_ayah',
                pekerjaan_ayah='$pekerjaan_ayah',
                penghasilan_ayah='$penghasilan_ayah',
                nik_ibu='$nik_ibu',
                noHpIbu='$no_hp_ibu',
                tmpt_lahir_ibu='$tempat_lahir_ibu',
                tgl_lahir_ibu='$tanggal_lahir_ibu', 
                pendidikan_terakhir_ibu='$pendidikan_terakhir_ibu', 
                pekerjaan_ibu='$pekerjaan_ibu', 
                penghasilan_ibu='$penghasilan_ibu'
            WHERE
                idSiswa='$idSiswa'
        ");

        if ($query){
            $sws = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ttdOrtu FROM siswa WHERE idSiswa='$idSiswa'"));
            echo json_encode([
                'status' => true,
                'message' => 'Data berhail diperbarui.',
                'file' => '../'.$sws['ttdOrtu'],
                'ext' => pathinfo($sws['ttdOrtu'], PATHINFO_EXTENSION),
            ]);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'Terjadi kesalahan, silahkan coba lagi.',
            ]);
        }
        exit;


    }

    if ($act == 'data-alamat'){
        $fieldWajib = [
             'provinsi', 'kota_atau_kabupaten', 'kecamatan', 'kelurahan', 'rt', 'rw', 'alamat',
        ];

        $fieldAngka = [
            'rt', 'rw',
        ];

        $fieldEncrypt = [
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
        }
       
        $dtProvinsi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_provinsi WHERE id='$provinsi' LIMIT 1"));
        $nmProvinsi = $dtProvinsi['name'];
        $dtKabupaten = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_kabupaten WHERE id='$kota_atau_kabupaten' LIMIT 1"));
        $nmKabupaten = $dtKabupaten['type'].' '.$dtKabupaten['name'];
        $dtKecamatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_kecamatan WHERE id='$kecamatan' LIMIT 1"));
        $nmKecamatan = $dtKecamatan['name'];
        $dtKelurahan= mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_kelurahan WHERE id='$kelurahan' LIMIT 1"));
        $nmKelurahan = $dtKelurahan['name'];
        $rtRw = $rt.' '.$rw;

        //update data
        $query = mysqli_query($conn, "
            UPDATE 
                siswa
            SET 
                provinsi='$nmProvinsi',
                kab_kota='$nmKabupaten',
                kecamatan='$nmKecamatan',
                kelurahan='$nmKelurahan',
                rt_rw='$rtRw',
                koordinat_lintang='$koordinat_lintang',
                koordinat_bujur='$koordinat_bujur',
                alamatOrtu='$alamat'
            WHERE
                idSiswa='$idSiswa'
        ");

        if ($query){
            echo json_encode([
                'status' => true,
                'message' => 'Data berhail diperbarui.',
            ]);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'Terjadi kesalahan, silahkan coba lagi.',
            ]);
        }
        exit;
    }

    if ($act == 'data-periodik'){
        $fieldWajib = [
            'tinggi_badan', 'berat_badan', 'jarak_tempat_tinggal_ke_sekolah', 'waktu_tempuh_ke_sekolah'
        ];

        $fieldAngka = [
            'tinggi_badan', 'berat_badan'
        ];

        foreach ($_POST as $key => $value) {
            $$key = mysqli_real_escape_string($conn, $value);

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
        }

        
        //update data
        $query = mysqli_query($conn, "
            UPDATE 
                siswa
            SET 
                tinggi_badan='$tinggi_badan',
                berat_badan='$berat_badan',
                jarak_tempuh='$jarak_tempat_tinggal_ke_sekolah',
                waktu_tempuh='$waktu_tempuh_ke_sekolah'
            WHERE
                idSiswa='$idSiswa'
        ");

        if ($query){
            echo json_encode([
                'status' => true,
                'message' => 'Data berhail diperbarui.',
            ]);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'Terjadi kesalahan, silahkan coba lagi.',
            ]);
        }
        exit;
    }

    if ($act == 'data-prestasi'){
        
    }
?>