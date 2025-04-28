<?php include "header.php"; ?>

<?php 
    $dtGelombangAktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ppdb_gelombang WHERE mulai <= '$dateNow' AND selesai >= '$dateNow' AND idTahunAjaran='$ta_aktif[idTahunAjaran]' LIMIT 1"));
    if (!$dtGelombangAktif){
        $_SESSION['notif'] = 'error-gelombang';
        echo "<script>document.location='./jadwal';</script>";
        exit;
    }
    
    $countSiswaGelombang = mysqli_num_rows(mysqli_query($conn, "SELECT idSiswa FROM siswa WHERE idGelombang='$dtGelombangAktif[idGlombang]'"));
    if ($countSiswaGelombang == $dtGelombangAktif['kuota']){
        $_SESSION['notif'] = 'error-kuota';
        echo "<script>document.location='./jadwal';</script>";
        exit;
    }
?>

<body>
    <?php include "menu.php"; ?>

    <br><br><br><br>
    
    <?php 
        $dtGelombang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ppdb_gelombang WHERE mulai <= '$dateNow' AND selesai >= '$dateNow' AND idTahunAjaran='$ta_aktif[idTahunAjaran]' LIMIT 1"));
    ?>
    <section class="py-3 bg-transparent">
        <div class="container">
            <!-- Title Section -->
            <div class="section-title text-center pb-25">
                <h3 class="title">FORM PENDAFTARAN SISWA BARU</h3>
                <p class="text-muted" style="font-size:0.875rem">Isikan data pada form dibawah dengan sebenar-benarnya</p>
            </div>

            <!-- Alert -->
            <div class="container form-input">
                <div class="alert alert-primary shadow-sm" style="font-size:0.875rem">
                    Sebelum mengisi formulir mohon siapkan file pas foto calon siswa (max 2 MB) &amp; KK (max 2 MB) dengan format (.jpg) untuk di <b>Upload</b>, lembar akta kelahiran untuk mengisi No Reg Akta kelahiran, diharapkan setelah melakukan pendaftaran <b> segera login dan melengkapi berkas pendaftaran lainnya didalam akun calon siswa.</b>
                </div>
            </div>
            
            <!-- Content -->
            <div class="container form-input mb-5">
                <div class="main-container shadow-sm col-md-12">
                    <div class="step-sidebar d-none d-sm-block">
                        <div class="step-item active" data-step="1">
                            <div class="step-number">1</div>
                            <div class="step-title">Data Pendaftaran</div>
                        </div>
                        <div class="divider"></div>
                        <div class="step-item" data-step="2">
                            <div class="step-number">2</div>
                            <div class="step-title">Data Siswa</div>
                        </div>
                        <div class="divider"></div>
                        <div class="step-item" data-step="3">
                            <div class="step-number">3</div>
                            <div class="step-title">Data Orang Tua</div>
                        </div>
                        <div class="divider"></div>
                        <div class="step-item" data-step="4">
                            <div class="step-number">4</div>
                            <div class="step-title">Data Alamat</div>
                        </div>
                        <div class="divider"></div>
                        <div class="step-item" data-step="5">
                            <div class="step-number">5</div>
                            <div class="step-title">Data Periodik</div>
                        </div>
                    </div>
                    <div class="form-section">
                        <div id="step-form">
                            <form id="psbForm" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>
                                <div class="step-content" data-step="1">
                                    <div class="form-group">
                                        <label for="tanggal_pendaftaran">Tanggal Pendaftaran <span class="text-danger">*</span></label>
                                        <input type="text" id="tanggal_pendaftaran" name="tanggal_pendaftaran" placeholder="Masukkan Tanggal Pendaftaran" class="form-control bg-white" required readonly value="<?= tgl_raport($dateNow) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="jalur_pendaftaran">Jalur Pendaftaran <span class="text-danger">*</span></label>
                                        <select id="jalur_pendaftaran" name="jalur_pendaftaran" class="form-control" required>
                                            <option value="">- PILIH JALUR -</option>
                                            <?php
                                                $qJalurPpdb = mysqli_query($conn, "SELECT * FROM ppdb_jalur ORDER BY idJalur ASC");
                                                while ($dt = mysqli_fetch_assoc($qJalurPpdb)){
                                                    echo '<option value="'.encrypt($dt['idJalur']).'">'.strtoupper($dt['nmJalur']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tahun_ajaran_atau_gelombang">Tahun Ajaran / Gelombang <span class="text-danger">*</span></label>
                                        <input type="text" id="tahun_ajaran_atau_gelombang" name="tahun_ajaran_atau_gelombang" placeholder="Masukkan Tahun Ajaran / Gelombang" class="form-control bg-white" value="<?= $ta_aktif['nmTahunAjaran'].' | '.$dtGelombang['nmGelombang'] ?>" readonly required>
                                    </div>

                                    <div class="form-group">
                                        <label for="biaya">Biaya <span class="text-danger">*</span></label>
                                        <input type="text" id="biaya" name="biaya" class="form-control bg-white" placeholder="Masukkan Biaya" value="<?= buatRp($dtGelombang['biaya']) ?>" readonly required>
                                    </div>

                                    <div class="form-group">
                                        <label for="asal_sekolah">Asal Sekolah <span class="text-danger">*</span></label>
                                        <select id="asal_sekolah" name="asal_sekolah" class="form-control" required>
                                            <option value="">- PILIH ASAL SEKOLAH -</option>
                                            <option>TK</option>
                                            <option>RA</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_asal_sekolah">Nama Asal Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" id="nama_asal_sekolah" name="nama_asal_sekolah" class="form-control" placeholder="Masukkan Nama Sekolah" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="kecamatan_TK_atau_RA_asal">Kecamatan TK/RA Asal</label>
                                        <input type="text" id="kecamatan_TK_atau_RA_asal" name="kecamatan_TK_atau_RA_asal" class="form-control" placeholder="Masukkan Kecamatan TK/RA Asal">
                                    </div>
                                </div>

                                <div class="step-content d-none" data-step="2">
                                    <div class="form-group">
                                        <label for="nisn_siswa">NISN Siswa</label>
                                        <input type="text" id="nisn_siswa" name="nisn_siswa" class="form-control" placeholder="Kosongkan NISN Siswa Jika Tidak Tahu" onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_siswa">Nama Siswa <span class="text-danger">*</span></label>
                                        <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" placeholder="Masukkan Nama Siswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto_siswa">Foto Siswa <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="foto_siswa" name="foto_siswa" accept=".jpg,.jpeg,.png" required>
                                        <small class="text-muted" style="font-style: italic">Maksimum ukuran file 2 mb.</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="nik_siswa">NIK Siswa <span class="text-danger">*</span></label>
                                        <input type="text" id="nik_siswa" name="nik_siswa" class="form-control" placeholder="Masukkan NIK Siswa" required onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir Siswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control class-date-picker" style="background-color: white;" placeholder="Masukkan Tanggal Lahir Siswa (YYYY-MM-DD)" required>
                                    </div>

                                    <div class="form-group radio-success">
                                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label><br>
                                        <label>
                                            <input type="radio" name="jenis_kelamin" value="L" checked> Laki-laki
                                        </label>
                                        <br>
                                        <label>
                                            <input type="radio" name="jenis_kelamin" value="P"> Perempuan
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="agama_siswa">Agama Siswa <span class="text-danger">*</span></label>
                                        <select id="agama_siswa" name="agama_siswa" class="form-control" required>
                                            <option value="">- PILIH AGAMA SISWA -</option>
                                            <?php
                                                $qAgama= mysqli_query($conn, "SELECT * FROM rb_agama ORDER BY id_agama ASC");
                                                while ($dt = mysqli_fetch_assoc($qAgama)){
                                                    echo '<option value="'.encrypt($dt['id_agama']).'">'.strtoupper($dt['nama_agama']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="jumlah_saudara">Jumlah Saudara <span class="text-danger">*</span></label>
                                        <input type="number" id="jumlah_saudara" name="jumlah_saudara" class="form-control" placeholder="Masukkan Jumlah Saudara" required onkeypress="return hanyaAngka(event)">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="urutan_anak">Urutan Anak <span class="text-danger">*</span></label>
                                        <input type="number" id="urutan_anak" name="urutan_anak" class="form-control" placeholder="Masukkan Urutan Anak" required onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="kewarganegaraan">Kewarganegaraan <span class="text-danger">*</span></label>
                                        <select id="kewarganegaraan" name="kewarganegaraan" class="form-control" required>
                                            <option value="">- PILIH KEWARGANEGARAAN -</option>
                                            <option>WNI</option>
                                            <option>WNA</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="no_reg_akta_kelahiran">No Reg Akta Kelahiran</label>
                                        <input type="text" id="no_reg_akta_kelahiran" name="no_reg_akta_kelahiran" class="form-control" placeholder="No Registrasi Akta Kelahiran">
                                    </div>

                                    <div class="form-group">
                                        <label for="tempat_tinggal">Tempat Tinggal <span class="text-danger">*</span></label>
                                        <select id="tempat_tinggal" name="tempat_tinggal" class="form-control" required>
                                            <option value="">- PILIH TEMPAT TINGGAL -</option>
                                            <option>BERSAMA ORANG TUA</option>
                                            <option>WALI</option>
                                            <option>KOS</option>
                                            <option>ASRAMA</option>
                                            <option>PANTI ASUHAN</option>
                                            <option>LAINNYA</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="moda_transportasi">Moda Transportasi <span class="text-danger">*</span></label>
                                        <select id="moda_transportasi" name="moda_transportasi" class="form-control" required>
                                            <option value="">- PILIH MODA TRANSPORTASI -</option>
                                            <option>JALAN KAKI</option>
                                            <option>KENDARAAN PRIBADI</option>
                                            <option>KENDARAAN UMUM/ANGKOT</option>
                                            <option>JEMPUTAN SEKOLAH</option>
                                            <option>KERETA API</option>
                                            <option>OJEK</option>
                                            <option>BECAK/ANDONG/DOKAR/DELMAN</option>
                                            <option>PERAHU PENYEBRANGAN/RAKIT</option>
                                            <option>LAINNYA</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="hobi">Hobi <span class="text-danger">*</span></label>
                                        <input type="text" id="hobi" name="hobi" class="form-control" placeholder="Masukkan Hobi" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="upload_file_kartu_keluarga">Upload File Kartu Keluarga <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="upload_file_kartu_keluarga" name="upload_file_kartu_keluarga" accept=".jpg,.jpeg,.png,.pdf" required>
                                        <small class="text-muted" style="font-style: italic">Maksimum ukuran file 5 mb.</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="no_kartu_keluarga">No Kartu Keluarga <span class="text-danger">*</span></label>
                                        <input type="text" id="no_kartu_keluarga" name="no_kartu_keluarga" class="form-control" placeholder="Masukkan No Kartu Keluarga" required onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_kepala_keluarga">Nama Kepala Keluarga</label>
                                        <input type="text" id="nama_kepala_keluarga" name="nama_kepala_keluarga" class="form-control" placeholder="Masukkan Nama Kepala Keluarga">
                                    </div>
                                </div>
                                
                                <div class="step-content d-none" data-step="3">
                                    <div class="alert alert-primary shadow-sm" style="font-size:0.875rem">
                                        <b>INFORMASI DATA AYAH</b>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nik_ayah">NIK Ayah</label>
                                        <input type="text" id="nik_ayah" name="nik_ayah" class="form-control" placeholder="Masukkan NIK Ayah" onkeypress="return hanyaAngka(event)">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nama_ayah">Nama Ayah <span class="text-danger">*</span></label>
                                        <input type="text" id="nama_ayah" name="nama_ayah" class="form-control" placeholder="Masukkan Nama Ayah" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="no_hp_ayah">No HP Ayah <span class="text-danger">*</span></label>
                                        <input type="text" id="no_hp_ayah" name="no_hp_ayah" class="form-control" placeholder="Masukkan No HP Ayah" required onkeypress="return hanyaAngka(event)">
                                        <small class="text-muted" style="font-style: italic">Masukkan nohp ortu/wali (informasi login akun siswa akan diinfokan via whatsapp)</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email_ayah_atau_ibu">Email Ayah/Ibu</label>
                                        <input type="email" id="email_ayah_atau_ibu" name="email_ayah_atau_ibu" class="form-control" placeholder="Masukkan Email Ayah atau Ibu">
                                    </div>

                                    <div class="form-group">
                                        <label for="tempat_lahir_ayah">Tempat Lahir Ayah</label>
                                        <input type="text" id="tempat_lahir_ayah" name="tempat_lahir_ayah" class="form-control" placeholder="Masukkan Tempat Lahir Ayah">
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_lahir_ayah">Tanggal Lahir Ayah</label>
                                        <input type="text" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" class="form-control class-date-picker" style="background-color: white;" placeholder="Masukkan Tanggal Lahir Ayah (YYYY-MM-DD)">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="pendidikan_terakhir_ayah">Pendidikan Terakhir Ayah</label>
                                        <select id="pendidikan_terakhir_ayah" name="pendidikan_terakhir_ayah" class="form-control">
                                            <option value="">- PILIH PENDIDIKAN TERAKHIR AYAH -</option>
                                            <?php
                                                $qPendidikan= mysqli_query($conn, "SELECT * FROM rb_pendidikan ORDER BY id ASC");
                                                while ($dt = mysqli_fetch_assoc($qPendidikan)){
                                                    echo '<option value="'.encrypt($dt['id']).'">'.strtoupper($dt['tingkat_pendidikan']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                        <select id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-control">
                                            <option value="">- PILIH PEKERJAAN AYAH -</option>
                                            <?php
                                                $qPekerjaan= mysqli_query($conn, "SELECT * FROM rb_pekerjaan ORDER BY id ASC");
                                                while ($dt = mysqli_fetch_assoc($qPekerjaan)){
                                                    echo '<option value="'.encrypt($dt['id']).'">'.strtoupper($dt['pekerjaan']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="penghasilan_ayah">Penghasilan Ayah</label>
                                        <select id="penghasilan_ayah" name="penghasilan_ayah" class="form-control">
                                            <option value="">- PILIH PENGHASILAN AYAH -</option>
                                            <?php
                                                $qPenghasilan= mysqli_query($conn, "SELECT * FROM rb_penghasilan ORDER BY id ASC");
                                                while ($dt = mysqli_fetch_assoc($qPenghasilan)){
                                                    echo '<option value="'.encrypt($dt['id']).'">'.strtoupper($dt['kategori']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="alert alert-primary shadow-sm" style="font-size:0.875rem">
                                        <b>INFORMASI DATA IBU</b>
                                    </div>

                                    <div class="form-group">
                                        <label for="nik_ibu">NIK Ibu</label>
                                        <input type="text" id="nik_ibu" name="nik_ibu" class="form-control" placeholder="Masukkan NIK Ibu" onkeypress="return hanyaAngka(event)">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nama_ibu">Nama Ibu <span class="text-danger">*</span></label>
                                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-control" placeholder="Masukkan Nama Ibu" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="no_hp_ibu">No HP Ibu</label>
                                        <input type="text" id="no_hp_ibu" name="no_hp_ibu" class="form-control" placeholder="Masukkan No HP Ibu" onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="tempat_lahir_ibu">Tempat Lahir Ibu</label>
                                        <input type="text" id="tempat_lahir_ibu" name="tempat_lahir_ibu" class="form-control" placeholder="Masukkan Tempat Lahir Ibu">
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_lahir_ibu">Tanggal Lahir Ibu</label>
                                        <input type="text" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" class="form-control class-date-picker" style="background-color: white;" placeholder="Masukkan Tanggal Lahir Ibu (YYYY-MM-DD)">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="pendidikan_terakhir_ibu">Pendidikan Terakhir Ibu</label>
                                        <select id="pendidikan_terakhir_ibu" name="pendidikan_terakhir_ibu" class="form-control">
                                            <option value="">- PILIH PENDIDIKAN TERAKHIR IBU -</option>
                                            <?php
                                                $qPendidikan= mysqli_query($conn, "SELECT * FROM rb_pendidikan ORDER BY id ASC");
                                                while ($dt = mysqli_fetch_assoc($qPendidikan)){
                                                    echo '<option value="'.encrypt($dt['id']).'">'.strtoupper($dt['tingkat_pendidikan']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                        <select id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-control">
                                            <option value="">- PILIH PEKERJAAN IBU -</option>
                                            <?php
                                                $qPekerjaan= mysqli_query($conn, "SELECT * FROM rb_pekerjaan ORDER BY id ASC");
                                                while ($dt = mysqli_fetch_assoc($qPekerjaan)){
                                                    echo '<option value="'.encrypt($dt['id']).'">'.strtoupper($dt['pekerjaan']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="penghasilan_ibu">Penghasilan Ibu</label>
                                        <select id="penghasilan_ibu" name="penghasilan_ibu" class="form-control">
                                            <option value="">- PILIH PENGHASILAN IBU -</option>
                                            <?php
                                                $qPenghasilan= mysqli_query($conn, "SELECT * FROM rb_penghasilan ORDER BY id ASC");
                                                while ($dt = mysqli_fetch_assoc($qPenghasilan)){
                                                    echo '<option value="'.encrypt($dt['id']).'">'.strtoupper($dt['kategori']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto_tanda_tangan_ayah_atau_ibu">Foto Tanda Tangan Ayah/Ibu <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="foto_tanda_tangan_ayah_atau_ibu" name="foto_tanda_tangan_ayah_atau_ibu" accept=".jpg,.jpeg,.png" required>
                                        <small class="text-muted" style="font-style: italic">Maksimum ukuran file 2 mb.</small>
                                    </div>
                                </div>
                                
                                <div class="step-content d-none" data-step="4">
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi <span class="text-danger">*</span></label>
                                        <select id="provinsi" name="provinsi" class="form-control" required>
                                            <option value="">- PILIH PROVINSI -</option>
                                            <?php
                                                $qProvinsi= mysqli_query($conn, "SELECT * FROM rb_provinsi ORDER BY id ASC");
                                                while ($dt = mysqli_fetch_assoc($qProvinsi)){
                                                    echo '<option value="'.encrypt($dt['id']).'">'.strtoupper($dt['name']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="kota_atau_kabupaten">Kota/Kabupaten <span class="text-danger">*</span></label>
                                        <select id="kota_atau_kabupaten" name="kota_atau_kabupaten" class="form-control" required>
                                            <option value="">- PILIH KOTA/KABUPATEN -</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan <span class="text-danger">*</span></label>
                                        <select id="kecamatan" name="kecamatan" class="form-control" required>
                                            <option value="">- PILIH KECAMATAN -</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan <span class="text-danger">*</span></label>
                                        <select id="kelurahan" name="kelurahan" class="form-control" required>
                                            <option value="">- PILIH KELURAHAN -</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="rt">RT <span class="text-danger">*</span></label>
                                        <input type="text" id="rt" name="rt" class="form-control" placeholder="Masukkan RT" required onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="rw">RW <span class="text-danger">*</span></label>
                                        <input type="text" id="rw" name="rw" class="form-control" placeholder="Masukkan RW" required onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="koordinat_lintang">Koordinat Lintang</label>
                                        <input type="text" id="koordinat_lintang" name="koordinat_lintang" class="form-control" placeholder="Kosongkan Jika Belum Tahu">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="koordinat_bujur">Koordinat Bujur</label>
                                        <input type="text" id="koordinat_bujur" name="koordinat_bujur" class="form-control" placeholder="Kosongkan Jika Belum Tahu">
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                        <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat Jalan / Gang dan No Rumah Saja" rows="4" required></textarea>
                                    </div>
                                </div>

                                <div class="step-content d-none" data-step="5">
                                    <div class="form-group">
                                        <label for="tinggi_badan">Tinggi Badan <span class="text-danger">*</span></label>
                                        <input type="number" id="tinggi_badan" name="tinggi_badan" class="form-control" placeholder="Masukkan Tinggi Badan" required onkeypress="return hanyaAngka(event)">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="berat_badan">Berat Badan <span class="text-danger">*</span></label>
                                        <input type="number" id="berat_badan" name="berat_badan" class="form-control" placeholder="Masukkan Berat Badan" required onkeypress="return hanyaAngka(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="jarak_tempat_tinggal_ke_sekolah">Jarak Tempat Tinggal ke Sekolah <span class="text-danger">*</span></label>
                                        <select id="jarak_tempat_tinggal_ke_sekolah" name="jarak_tempat_tinggal_ke_sekolah" class="form-control" required>
                                            <option value="">- PILIH JARAK -</option>
                                            <option>LEBIH DARI 1 KM</option>
                                            <option>KURANG DARI 1 KM</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="waktu_tempuh_ke_sekolah">Waktu Tempuh ke Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" id="waktu_tempuh_ke_sekolah" name="waktu_tempuh_ke_sekolah" class="form-control" placeholder="Masukkan Waktu Tempuh ke Sekolah" required>
                                        <small class="text-muted" style="font-style: italic">Contoh: 1 jam 30 menit atau 15 menit</small>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="pernyataan" class="custom-control-input" id="pernyataan" required>
                                            <label class="custom-control-label" for="pernyataan">Demikian data ini saya buat dengan sebenar-benarnya dan bila terjadi isian yang dibuat tidak benar, saya bersedia menanggung kesalahan input yang ditimbulkannya</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="nav-buttons">
                                    <button class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                                    <button type="submit" class="btn btn-success" id="nextBtn">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include "footer.php"; ?>
    
    <script src="assets/plugins/validate/jquery.validate.min.js"></script>
    <script>
        let currentStep = 1;
        const totalSteps = 5;

        // Tampilkan konten dan aktifkan step di sidebar
        function updateStepDisplay(step) {
            // Tampilkan hanya step yang aktif
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.add('d-none');
                if (parseInt(content.dataset.step) === step) {
                    content.classList.remove('d-none');
                }
            });

            // Update sidebar active
            document.querySelectorAll('.step-item').forEach(item => {
                const stepNumber = parseInt(item.dataset.step);
                item.classList.remove('active', 'completed');
                if (stepNumber === step) {
                    item.classList.add('active');
                } else if (stepNumber < step) {
                    item.classList.add('completed');
                }
            });

            togglePrevBtn();
            toggleNextBtnText();

            if (step == 1){
                focusAndScroll('#tanggal_pendaftaran');
            }else if (step == 2){
                focusAndScroll('#nisn_siswa');
            }else if (step == 3){
                focusAndScroll('#nik_ayah');
            }else if (step == 4){
                focusAndScroll('#provinsi');
            }else if (step == 5){
                focusAndScroll('#tinggi_badan');
            }
        }

        function togglePrevBtn() {
            $('#prevBtn').prop('disabled', currentStep === 1);
        }

        function toggleNextBtnText() {
            $('#nextBtn').text(currentStep === totalSteps ? 'Daftarkan Siswa' : 'Next');
        }

        // Validasi jQuery Validator
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).addClass('error');
            },
            unhighlight: function (element) {
                $(element).removeClass('error');
            }
        });

        $.validator.addMethod("maxfilesize", function(value, element, param) {
            if (element.files.length === 0) return true;
            return element.files[0].size <= param;
        }, "Ukuran file terlalu besar.");

        $.validator.addMethod("pattern", function(value, element, param) {
            return this.optional(element) || param.test(value);
        }, "Format tidak valid");

        $.validator.addMethod("extension", function(value, element, param) {
            const fileName = element.value;
            const ext = fileName.split('.').pop().toLowerCase();
            return this.optional(element) || param.split('|').indexOf(ext) !== -1;
        }, "Format file tidak valid. Harus berupa JPG, JPEG, atau PNG.");

        // Inisialisasi validasi form
        const validator = $("#psbForm").validate({
            rules: {
                // step 1
                tanggal_pendaftaran: { required: true },
                jalur_pendaftaran: { required: true },
                tahun_ajaran_atau_gelombang: { required: true },
                biaya : { required: true },
                asal_sekolah : { required: true },
                nama_asal_sekolah : { required: true },
                // step 2
                nisn_siswa : { 
                    required: function(element) {
                        return $(element).val().length > 0;
                    },
                    digits : true 
                },
                nama_siswa : { required: true },
                foto_siswa : { 
                    required: true,
                    extension: "jpg|jpeg|png",
                    maxfilesize: 2097152 // 2 MB dalam byte
                },
                nik_siswa : { 
                    required: true, 
                    digits: true, 
                    minlength: 16, 
                    maxlength: 16 
                },
                tempat_lahir : { required: true },
                tanggal_lahir : { 
                    required: true,
                    pattern: /^\d{4}-\d{2}-\d{2}$/
                },
                jenis_kelamin : { required: true },
                agama_siswa : { required: true },
                jumlah_saudara : { 
                    required: true,
                    digits: true
                },
                urutan_anak : { 
                    required: true,
                    digits: true
                },
                kewarganegaraan : { required: true },
                tempat_tinggal : { required: true },
                moda_transportasi : { required: true },
                hobi : { required: true },
                upload_file_kartu_keluarga : { 
                    required: true,
                    extension: "pdf|jpg|jpeg|png", 
                    maxfilesize: 5242880 // 5 MB dalam byte
                },
                no_kartu_keluarga : { 
                    required: true,
                    digits: true, 
                    minlength: 16, 
                    maxlength: 16 
                },
                //step 3
                nik_ayah : { 
                    required: function(element) {
                        return $(element).val().length > 0;
                    },
                    digits: true, 
                    minlength: 16, 
                    maxlength: 16 
                },
                nama_ayah : { required: true },
                no_hp_ayah : { 
                    required: true,
                    digits: true
                },
                email_ayah_atau_ibu : { 
                    required: function(element) {
                        return $(element).val().length > 0;
                    },
                    email: true
                },
                tanggal_lahir_ayah : { 
                    required: function(element) {
                        return $(element).val().length > 0;
                    },
                    pattern: /^\d{4}-\d{2}-\d{2}$/
                },
                nik_ibu : { 
                    required: function(element) {
                        return $(element).val().length > 0;
                    },
                    digits: true, 
                    minlength: 16, 
                    maxlength: 16 
                },
                nama_ibu : { required: true },
                no_hp_ibu : { 
                    required: function(element) {
                        return $(element).val().length > 0;
                    },
                    digits: true
                },
                tanggal_lahir_ibu : { 
                    required: function(element) {
                        return $(element).val().length > 0;
                    },
                    pattern: /^\d{4}-\d{2}-\d{2}$/
                },
                foto_tanda_tangan_ayah_atau_ibu : { 
                    required: true,
                    extension: "jpg|jpeg|png",
                    maxfilesize: 2097152 // 2 MB dalam byte
                },
                // step 4
                provinsi : { required: true },
                kota_atau_kabupaten : { required: true },
                kecamatan : { required: true },
                kelurahan : { required: true },
                rt : { 
                    required: true,
                    digits: true
                },
                rw : { 
                    required: true,
                    digits: true
                },
                alamat : { required: true },
                // step 5
                tinggi_badan : { 
                    required: true,
                    digits: true,  
                },
                berat_badan : { 
                    required: true,
                    digits: true, 
                },
                jarak_tempat_tinggal_ke_sekolah : { required: true },
                waktu_tempuh_ke_sekolah : { required: true },
                pernyataan : { required: true },
            },
            messages: {
                // step 1
                tanggal_pendaftaran: "Tanggal pendaftaran wajib diisi.",
                jalur_pendaftaran: "Jalur pendaftaran belum dipilih.",
                tahun_ajaran_atau_gelombang: "Tahun ajaran/gelombang wajib diisi.",
                biaya: "Biaya wajib diisi.",
                asal_sekolah: "Asal sekolah wajib diisi.",
                nama_asal_sekolah: "Nama asal sekolah wajib diisi.",
                // step 2
                nisn_siswa : {
                    digits: "NISN siswa hanya boleh angka."
                },
                nama_siswa : "Nama siswa wajib diisi.",
                foto_siswa : {
                    required : "Foto siswa wajib diisi.",
                    extension: "Hanya file JPG, JPEG, atau PNG yang diperbolehkan.",
                    maxfilesize: "Ukuran file maksimal 2 MB."
                },
                nik_siswa : {
                    required: "NIK siswa wajib diisi",
                    minlength: "NIK siswa harus 16 digit",
                    maxlength: "NIK siswa harus 16 digit",
                    digits: "NIK siswa hanya boleh angka"
                },
                tempat_lahir : "Tempat lahir wajib diisi.",
                tanggal_lahir : {
                    required: "Tanggal lahir wajib diisi.",
                    pattern: "Format tanggal lahir harus YYYY-MM-DD."
                },
                jenis_kelamin : "Jenis kelamin belum dipilih.",
                agama_siswa : "Agama siswa belum dipilih.",
                jumlah_saudara : {
                    required: "Jumlah saudara wajib diisi.",
                    digits: "Jumlah saudara hanya boleh angka."
                },
                urutan_anak : {
                    required: "Urutan anak wajib diisi.",
                    digits: "Urutan anak hanya boleh angka."
                },
                kewarganegaraan : "Kewarganegaraan belum dipilih.",
                tempat_tinggal : "Tempat tinggal belum dipilih.",
                moda_transportasi : "Moda transportasi belum dipilih.",
                hobi : "Hobi wajib diisi.",
                upload_file_kartu_keluarga : {
                    required: "File kartu keluarga wajib diisi.",
                    extension: "Format file harus PDF, JPG, JPEG, atau PNG.",
                    maxfilesize: "Ukuran file maksimal 5 MB."
                },
                no_kartu_keluarga : {
                    required: "No kartu keluarga wajib diisi.",
                    minlength: "No kartu keluarga harus 16 digit.",
                    maxlength: "No kartu keluarga harus 16 digit.",
                    digits: "No kartu keluarga hanya boleh angka."
                },
                //step 3
                nik_ayah : {
                    minlength: "NIK ayah harus 16 digit.",
                    maxlength: "NIK ayah harus 16 digit.",
                    digits: "NIK ayah hanya boleh angka."
                },
                nama_ayah : "Nama ayah wajib diisi.",
                no_hp_ayah: {
                    required: "No HP ayah wajib diisi.",
                    digits: "No HP ayah hanya boleh angka."
                },
                email_ayah_atau_ibu : {
                    email: "Masukkan email yang valid."
                },
                tanggal_lahir_ayah : {
                    pattern: "Format tanggal lahir ayah harus YYYY-MM-DD."
                },
                nik_ibu : {
                    minlength: "NIK ibu harus 16 digit.",
                    maxlength: "NIK ibu harus 16 digit.",
                    digits: "NIK ibu hanya boleh angka."
                },
                nama_ibu : "Nama ibu wajib diisi.",
                no_hp_ibu : {
                    digits: "No HP ibu hanya boleh angka."
                },
                tanggal_lahir_ibu : {
                    pattern: "Format tanggal lahir ibu harus YYYY-MM-DD."
                },
                foto_tanda_tangan_ayah_atau_ibu : {
                    required : "Foto tanda tangan ayah/ibu wajib diisi.",
                    extension: "Hanya file JPG, JPEG, atau PNG yang diperbolehkan.",
                    maxfilesize: "Ukuran file maksimal 2 MB."
                },
                // step 4
                provinsi : "Provinsi belum dipilih.",
                kota_atau_kabupaten : "Kota/kabupaten belum dipilih.",
                kecamatan : "Kecamatan belum dipilih.",
                kelurahan : "Kelurahan belum dipilih.",
                rt : {
                    required: "RT wajib diisi.",
                    digits: "RT hanya boleh angka."
                },
                rw : {
                    required: "RW wajib diisi.",
                    digits: "RW hanya boleh angka."
                },
                alamat : "Alamat wajib diisi.",
                // step 5
                tinggi_badan : {
                    required: "Tinggi badan wajib diisi.",
                    digits: "Tinggi badan hanya boleh angka."
                },
                berat_badan : {
                    required: "Berat badan wajib diisi.",
                    digits: "Berat badan hanya boleh angka."
                },
                jarak_tempat_tinggal_ke_sekolah : "Jarak tempat tinggal belum dipilih.",
                waktu_tempuh_ke_sekolah : "Waktu tempuh belum dipilih.",
                pernyataan : "Pernyataan wajib diceklis.",
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "jenis_kelamin") {
                    error.insertAfter(element.closest(".radio-success"));
                } if (element.attr("name") == "pernyataan") {
                    error.insertAfter(element.closest(".custom-checkbox"));
                } else {
                    error.insertAfter(element);
                }
                element.addClass('is-invalid');
            },
            success: function (label, element) {
                // Hapus kelas is-invalid setelah error diperbaiki
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                // Hanya lanjut ke step berikutnya
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateStepDisplay(currentStep);
                } else {
                    var formData = new FormData($('#psbForm')[0]);
                    $.ajax({
                        url: 'data/daftar?act=' + encodeURIComponent('<?= encrypt('simpan-pendaftaran') ?>'),
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function(resp) {
                            if (!resp.status){
                                Swal.fire({
                                    title: "Gagal",
                                    text: resp.message,
                                    icon: "error"
                                });
                            }else{
                                window.location = resp.link
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Gagal",
                                text: "Terjadi kesalahan, silahkan coba lagi.",
                                icon: "error"
                            });
                        }
                    });
                    return false;
                }
            }
        });

        // Tombol Selanjutnya
        $('#nextBtn').on('click', function (e) {
            e.preventDefault();

            // Ambil semua input dan select di step saat ini
            const currentFields = $(`.step-content[data-step="${currentStep}"]`).find('input, select');

            let isValid = true;

            // Validasi satu per satu
            currentFields.each(function () {
                if (!validator.element(this)) {
                    isValid = false;
                }
            });

            // Jika ada error, beri tanda error di sidebar
            document.querySelectorAll('.step-item').forEach(item => {
                const stepNumber = parseInt(item.dataset.step);
                item.classList.remove('error'); // Hapus kelas error yang lama

                // Cek jika step ini gagal validasi
                if (stepNumber === currentStep && !isValid) {
                    item.classList.add('error'); // Tambahkan kelas error pada step yang bermasalah
                }
            });
            
            if (isValid) {
                $('#psbForm').submit(); // trigger submitHandler
            }
        });

        // Tombol Sebelumnya
        $('#prevBtn').on('click', function (e) {
            e.preventDefault();
            if (currentStep > 1) {
                currentStep--;
                updateStepDisplay(currentStep);
            }
        });

        // Inisialisasi tampilan pertama
        $(document).ready(function () {
            updateStepDisplay(currentStep);
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

        $(document).on('change', '#provinsi', function () {
            const token = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).val();
            $.ajax({
                url: 'data/wilayah?act=' + encodeURIComponent('<?= encrypt('kabupaten') ?>'),
                method: 'POST',
                data: { id: id, token:token },
                dataType: 'json', 
                beforeSend: function() {
                    $('#kota_atau_kabupaten').html('<option>Loading...</option>');
                },
                success: function(resp) {
                    if (!resp.status){
                        Swal.fire({
                            title: "Gagal",
                            text: resp.message,
                            icon: "error"
                        });
                    }else{
                        $('#kota_atau_kabupaten').html(resp.data);
                        $('#kecamatan').html('<option value="">- PILIH KECAMATAN -</option>');
                        $('#kelurahan').html('<option value="">- PILIH KELURAHAN -</option>');
                    }
                }
            })
        });

        $(document).on('change', '#kota_atau_kabupaten', function () {
            const token = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).val();
            $.ajax({
                url: 'data/wilayah?act=' + encodeURIComponent('<?= encrypt('kecamatan') ?>'),
                method: 'POST',
                data: { id: id, token:token },
                dataType: 'json', 
                beforeSend: function() {
                    $('#kecamatan').html('<option>Loading...</option>');
                },
                success: function(resp) {
                    if (!resp.status){
                        Swal.fire({
                            title: "Gagal",
                            text: resp.message,
                            icon: "error"
                        });
                    }else{
                        $('#kecamatan').html(resp.data);
                        $('#kelurahan').html('<option value="">- PILIH KELURAHAN -</option>');
                    }
                }
            })
        });

        
        $(document).on('change', '#kecamatan', function () {
            const token = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).val();
            $.ajax({
                url: 'data/wilayah?act=' + encodeURIComponent('<?= encrypt('kelurahan') ?>'),
                method: 'POST',
                data: { id: id, token:token },
                dataType: 'json', 
                beforeSend: function() {
                    $('#kelurahan').html('<option>Loading...</option>');
                },
                success: function(resp) {
                    if (!resp.status){
                        Swal.fire({
                            title: "Gagal",
                            text: resp.message,
                            icon: "error"
                        });
                    }else{
                        $('#kelurahan').html(resp.data);
                    }
                }
            })
        });

        function focusAndScroll(selector) {
            var el = $(selector);
            if (el.length) {
                $('html, body').animate({
                    scrollTop: el.offset().top - 150
                }, 500, function() {
                    el.focus();
                });
            }
        }
    </script>

</body>

</html>