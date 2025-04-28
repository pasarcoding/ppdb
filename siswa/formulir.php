<?php 
    session_start();
    // error_reporting(0);
    include '../vendor/autoload.php';
    include '../config/koneksi.php';
    include "../config/fungsi_login.php";
    include "../config/enkripsi_deskripsi.php";
    include "../config/fungsi_indotgl.php";
    include "../config/library.php";

    use Mpdf\Mpdf;

    // CSRF TOKEN
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // jika belum login
    if (!isLogin()){
        echo "<script>document.location='../login';</script>";
        exit;
    }

    // load data
    $idSiswa = isset($_SESSION['siswa']) ? decrypt($_SESSION['siswa']) : '';
    $dtSiswa = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT 
            sws.*, 
            glmbng.biaya, glmbng.nmGelombang,
            ta.nmTahunAjaran,
            jalur.nmJalur,
            agama.nama_agama
            
        FROM siswa sws 
        LEFT JOIN ppdb_gelombang glmbng 
            ON sws.id_gelombang = glmbng.idGlombang
        LEFT JOIN tahun_ajaran ta 
            ON sws.untukAjaran = ta.idTahunAjaran
        LEFT JOIN ppdb_jalur jalur 
            ON sws.jalur_pendaftaran = jalur.idJalur
        LEFT JOIN rb_agama agama 
            ON sws.agamaSiswa = agama.id_agama

        WHERE sws.idSiswa = '$idSiswa' 
        LIMIT 1
    "));
    $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas LIMIT 1"));

    $mpdf = new Mpdf([
        'format' => 'A4', // Bisa juga: 'Letter', 'Legal', 'A5', 'Folio', dsb
        'orientation' => 'P', // 'P' = Portrait, 'L' = Landscape
        'margin_left' => 8,
        'margin_right' => 8,
        'margin_top' => 8,
        'margin_bottom' => 8,
    ]);

    // logo
    $logoPath = $idt['url'].'/gambar/logo/'.$idt['logo_kanan'];
    $logoData = file_get_contents($logoPath);
    $logoBase64 = base64_encode($logoData);
    $logoSrc = 'data:image/png;base64,' . $logoBase64;
    
    $jenisKelamin = !empty($dtSiswa['jkSiswa']) ? ($dtSiswa['jkSiswa'] == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN') : '';
    $dtPendidikanAyah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_pendidikan WHERE id='$dtSiswa[pendidikan_terakhir_ayah]'"));
    $pendidikanAyah = $dtPendidikanAyah['tingkat_pendidikan'];
    $dtPekerjaanAyah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_pekerjaan WHERE id='$dtSiswa[pekerjaan_ayah]'"));
    $pekerjaanAyah = $dtPekerjaanAyah['pekerjaan'];
    $dtPenghasilanAyah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_pendidikan WHERE id='$dtSiswa[penghasilan_ayah]'"));
    $penghasilanAyah = $dtPenghasilanAyah['tingkat_pendidikan'];
    $dtPendidikanIbu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_pendidikan WHERE id='$dtSiswa[pendidikan_terakhir_ibu]'"));
    $pendidikanIbu = $dtPendidikanIbu['tingkat_pendidikan'];
    $dtPekerjaanIbu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_pekerjaan WHERE id='$dtSiswa[pekerjaan_ibu]'"));
    $pekerjaanIbu = $dtPekerjaanIbu['pekerjaan'];
    $dtPenghasilanIbu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_pendidikan WHERE id='$dtSiswa[penghasilan_ibu]'"));
    $penghasilanIbu = $dtPenghasilanIbu['tingkat_pendidikan'];
    
    $rtRw = explode(' ', $dtSiswa['rt_rw']);
    $alamatLengkap = $dtSiswa['alamatOrtu'].' | RT '.$rtRw[0].' / RW '.$rtRw[1].' KEL. '.$dtSiswa['kecamatan'].' KEC. '.$dtSiswa['kelurahan'].' KAB/KOTA. '.$dtSiswa['kab_kot'].' PROV. '.$dtSiswa['provinsi'];

    $html = '
        <div style="text-align: center;">
            <img src="' . $logoSrc . '" width="60" style="margin-bottom:15px;">
            <div style="font-size:16px; font-weight:bold; margin-bottom:5px;">'.strtoupper($idt['nmSekolah']).'</div>
            <div style="font-size:13px; margin-bottom:5px;">'.strtoupper($idt['alamat']).'</div>
            <div style="font-size:13px; margin-bottom:15px;">Telp. 02220526830. Email <a href="mailto:sdsmuhammadiyah3bdg@gmail.com" style="color:blue;">sdsmuhammadiyah3bdg@gmail.com</a></div>
        </div>

        <div style="text-align: center; font-size:15px; font-weight:bold; margin-bottom:30px;">FORMULIR PENDAFTARAN</div>

        <table border="0" style="font-size: 13px; margin-bottom:20px;">
            <tr>
                <td style="width:410px">
                    <table>
                        <tr>
                            <td style="font-weight:bold; width:140px;">No. Pendaftaran</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['no_pendaftaran']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Tgl Daftar</td>
                            <td>:</td>
                            <td>'.strtoupper(tgl_raport($dtSiswa['tanggal_pendaftaran'])).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">T.A / Gelombang</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nmTahunAjaran'].' / '.$dtSiswa['nmGelombang']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Jalur</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nmJalur']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Sekolah Asal</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['asal_sekolah'].' ('.$dtSiswa['tipe_asal_sekolah'].')').'</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">NIK Siswa</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nik_siswa']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">NO KK</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['no_kk']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">NO Reg Akta Lahir</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['no_reg_akta_kelahiran']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">NISN Siswa</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nisnSiswa']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Nama Siswa</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nmSiswa']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Jenis Kelamin</td>
                            <td>:</td>
                            <td>'.strtoupper($jenisKelamin).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Kewarganegaraan</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['kewarganegaraan']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Tempat Lahir</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['tempat_lahir']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Tanggal Lahir</td>
                            <td>:</td>
                            <td>'.strtoupper(tgl_raport($dtSiswa['tglLahirSiswa'])).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Agama</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nama_agama']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Tempat Tinggal</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['tempat_tinggal']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Moda Transportasi</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['moda_transportasi']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Hobi</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['hobi']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Urutan Anak</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['urutan_anak']).'</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">NIK Ayah</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nik_ayah']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Nama Ayah</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nama_ayah']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Tanggal Lahir</td>
                            <td>:</td>
                            <td>'.strtoupper(tgl_raport($dtSiswa['tgl_lahir_ayah'])).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Pendidikan</td>
                            <td>:</td>
                            <td>'.strtoupper($pendidikanAyah).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Pekerjaan</td>
                            <td>:</td>
                            <td>'.strtoupper($pekerjaanAyah).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Penghasilan</td>
                            <td>:</td>
                            <td>'.strtoupper($penghasilanAyah).'</td>
                        </tr>
                    </table>
                </td>
                <td style="width:340px">
                    <table>
                        <tr>
                            <td style="font-weight:bold; width:130px;">NIK Ibu</td>
                            <td width="10px">:</td>
                            <td>'.strtoupper($dtSiswa['nik_ibu']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Nama Ibu</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['nama_ibu']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Tanggal Lahir</td>
                            <td>:</td>
                            <td>'.strtoupper(tgl_raport($dtSiswa['tgl_lahir_ibu'])).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Pendidikan</td>
                            <td>:</td>
                            <td>'.strtoupper($pendidikanIbu).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Pekerjaan</td>
                            <td>:</td>
                            <td>'.strtoupper($pekerjaanIbu).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Penghasilan</td>
                            <td>:</td>
                            <td>'.strtoupper($penghasilanIbu).'</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Tinggi Badan</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['tinggi_badan']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Berat Badan</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['berat_badan']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Jarak Tempat Tinggal Ke Sekolah</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['jarak_tempuh']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Waktu Tempuh</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['waktu_tempuh']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Lintang</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['koordinat_lintang']).'</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Bujur</td>
                            <td>:</td>
                            <td>'.strtoupper($dtSiswa['koordinat_bujur']).'</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 15px;">
                    <table>
                        <tr>
                            <td style="font-weight:bold; width:140px;">Alamat Lengkap</td>
                            <td width="10px">:</td>
                            <td>'.strtoupper($alamatLengkap).'</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div style="text-align: center; font-size: 13px; margin-bottom:20px;">
            "Demikian data ini saya buat dengan sebenar-benarnya dan bila terjadi isian yang dibuat tidak benar, saya bersedia menanggung kesalahan input yang ditimbulkannya"
        </div>

        <table style="font-size:13px;">
            <tr>
                <td style="width:520px">
                    <table>
                        <tr><td style="padding-left:10px;">Harap dibawa saat daftar ulang <font style="color:red">*</font></td></tr>
                        <tr><td style="padding-left:30px;">1. Formulir Pendaftaran</td></tr>
                        <tr><td style="padding-left:30px;">2. Fotocopy KTP Ortu / Wali</td></tr>
                        <tr><td style="padding-left:30px;">3. Fotocopy Kartu Keluarga</td></tr>
                        <tr><td style="padding-left:30px;">4. Fotocopy Akta Kelahiran</td></tr>
                        <tr><td style="padding-left:30px;">5. Fotocopy Ijazah TK/RA (boleh menyusul)</td></tr>
                        <tr><td style="padding-left:30px;">6. Surat Pernyataan [download dari menu panduan & browsur]</td></tr>
                    </table>
                </td>
                <td style="width:175px ; text-align:center">
                    '.strtoupper($idt['kabupaten'].', '.tgl_raport(date('Y-m-d'))).'
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    (......................)
                </td>
            </tr>
        </table>
    ';

    $mpdf->WriteHTML($html);
    $mpdf->Output('FORMULIR - '.$dtSiswa['no_pendaftaran'].'.pdf', \Mpdf\Output\Destination::INLINE); // atau DOWNLOAD
?>