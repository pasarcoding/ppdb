<div class="col-md-12">
    
    <div class="box" style="border: none;">
        <div class="box-body" style="padding: 0;">
            <form id="form-data-siswa" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>

                <div style="background-color: #00a65a; color: white; padding: 10px; font-weight: bold;">
                    DATA SISWA
                </div>
                
                <div style="padding: 15px">
                    <div class="form-group">
                        <label for="nisn_siswa">NISN Siswa</label>
                        <input type="text" id="nisn_siswa" name="nisn_siswa" class="form-control" placeholder="Kosongkan NISN Siswa Jika Tidak Tahu" onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['nisnSiswa'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa <span class="text-danger">*</span></label>
                        <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" placeholder="Masukkan Nama Siswa" required value="<?= $dtSiswa['nmSiswa'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="nik_siswa">NIK Siswa <span class="text-danger">*</span></label>
                        <input type="text" id="nik_siswa" name="nik_siswa" class="form-control" placeholder="Masukkan NIK Siswa" required readonly onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['nik_siswa'] ?>">
                        <small><i>Panjang NIK Siswa 16 Digit, Jika Ingin Mengubah NIK Siswa harus menghubungi petugas</i></small>
                    </div>

                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir Siswa" required value="<?= $dtSiswa['tempat_lahir'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control class-date-picker" style="background-color: white;" placeholder="Masukkan Tanggal Lahir Siswa (YYYY-MM-DD)" required value="<?= $dtSiswa['tglLahirSiswa'] ?>">
                    </div>

                    <div class="form-group radio-success">
                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label><br>
                        <label>
                            <input type="radio" name="jenis_kelamin" value="L" <?= $dtSiswa['jkSiswa'] == 'L' ? 'checked' : '' ?>> Laki-laki
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="jenis_kelamin" value="P" <?= $dtSiswa['jkSiswa'] == 'P' ? 'checked' : '' ?>> Perempuan
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="agama_siswa">Agama Siswa <span class="text-danger">*</span></label>
                        <select id="agama_siswa" name="agama_siswa" class="form-control" required>
                            <option value="">- PILIH AGAMA SISWA -</option>
                            <?php
                                $qAgama= mysqli_query($conn, "SELECT * FROM rb_agama ORDER BY id_agama ASC");
                                while ($dt = mysqli_fetch_assoc($qAgama)){
                                    echo '<option value="'.encrypt($dt['id_agama']).'" '.($dtSiswa['agamaSiswa'] == $dt['id_agama'] ? 'selected' : '').'>'.strtoupper($dt['nama_agama']).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="jumlah_saudara">Jumlah Saudara <span class="text-danger">*</span></label>
                        <input type="number" id="jumlah_saudara" name="jumlah_saudara" class="form-control" placeholder="Masukkan Jumlah Saudara" required onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['jml_saudara'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="urutan_anak">Urutan Anak <span class="text-danger">*</span></label>
                        <input type="number" id="urutan_anak" name="urutan_anak" class="form-control" placeholder="Masukkan Urutan Anak" required onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['urutan_anak'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="kewarganegaraan">Kewarganegaraan <span class="text-danger">*</span></label>
                        <select id="kewarganegaraan" name="kewarganegaraan" class="form-control" required>
                            <option value="">- PILIH KEWARGANEGARAAN -</option>
                            <option <?= $dtSiswa['kewarganegaraan'] == 'WNI' ? 'selected' : '' ?>>WNI</option>
                            <option <?= $dtSiswa['kewarganegaraan'] == 'WNA' ? 'selected' : '' ?>>WNA</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_reg_akta_kelahiran">No Reg Akta Kelahiran</label>
                        <input type="text" id="no_reg_akta_kelahiran" name="no_reg_akta_kelahiran" class="form-control" placeholder="No Registrasi Akta Kelahiran" value="<?= $dtSiswa['no_reg_akta_kelahiran'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="tempat_tinggal">Tempat Tinggal <span class="text-danger">*</span></label>
                        <select id="tempat_tinggal" name="tempat_tinggal" class="form-control" required>
                            <option value="">- PILIH TEMPAT TINGGAL -</option>
                            <option <?= $dtSiswa['tempat_tinggal'] == 'BERSAMA ORANG TUA' ? 'selected' : '' ?>>BERSAMA ORANG TUA</option>
                            <option <?= $dtSiswa['tempat_tinggal'] == 'WALI' ? 'selected' : '' ?>>WALI</option>
                            <option <?= $dtSiswa['tempat_tinggal'] == 'KOS' ? 'selected' : '' ?>>KOS</option>
                            <option <?= $dtSiswa['tempat_tinggal'] == 'ASRAMA' ? 'selected' : '' ?>>ASRAMA</option>
                            <option <?= $dtSiswa['tempat_tinggal'] == 'PANTI ASUHAN' ? 'selected' : '' ?>>PANTI ASUHAN</option>
                            <option <?= $dtSiswa['tempat_tinggal'] == 'LAINNYA' ? 'selected' : '' ?>>LAINNYA</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="moda_transportasi">Moda Transportasi <span class="text-danger">*</span></label>
                        <select id="moda_transportasi" name="moda_transportasi" class="form-control" required>
                            <option value="">- PILIH MODA TRANSPORTASI -</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'JALAN KAKI' ? 'selected' : '' ?>>JALAN KAKI</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'KENDARAAN PRIBADI' ? 'selected' : '' ?>>KENDARAAN PRIBADI</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'KENDARAAN UMUM/ANGKOT' ? 'selected' : '' ?>>KENDARAAN UMUM/ANGKOT</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'JEMPUTAN SEKOLAH' ? 'selected' : '' ?>>JEMPUTAN SEKOLAH</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'KERETA API' ? 'selected' : '' ?>>KERETA API</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'OJEK' ? 'selected' : '' ?>>OJEK</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'BECAK/ANDONG/DOKAR/DELMAN' ? 'selected' : '' ?>>BECAK/ANDONG/DOKAR/DELMAN</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'PERAHU PENYEBRANGAN/RAKIT' ? 'selected' : '' ?>>PERAHU PENYEBRANGAN/RAKIT</option>
                            <option <?= $dtSiswa['moda_transportasi'] == 'LAINNYA' ? 'selected' : '' ?>>LAINNYA</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hobi">Hobi <span class="text-danger">*</span></label>
                        <input type="text" id="hobi" name="hobi" class="form-control" placeholder="Masukkan Hobi" required value="<?= $dtSiswa['hobi'] ?>">
                    </div>
                </div>

                <div style="background-color: #00a65a; color: white; padding: 10px; font-weight: bold;">
                    DATA KARTU KELUARGA
                </div>

                <div style="padding: 15px">
                    <div class="form-group">
                        <label for="no_kartu_keluarga">No Kartu Keluarga <span class="text-danger">*</span></label>
                        <input type="text" id="no_kartu_keluarga" name="no_kartu_keluarga" class="form-control" placeholder="Masukkan No Kartu Keluarga" required onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['no_kk'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="nama_kepala_keluarga">Nama Kepala Keluarga</label>
                        <input type="text" id="nama_kepala_keluarga" name="nama_kepala_keluarga" class="form-control" placeholder="Masukkan Nama Kepala Keluarga" value="<?= $dtSiswa['nama_kepala_keluarga'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="upload_file_kartu_keluarga">Upload File Kartu Keluarga <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="upload_file_kartu_keluarga" name="upload_file_kartu_keluarga" accept=".jpg,.jpeg,.png,.pdf">
                        <a <?= !empty($dtSiswa['file_kk']) ? '' : 'style="display:none"' ?> href="#" class="text-sm btn-pdf-images" id="btn-file-kk" data-file="<?= '../'.$dtSiswa['file_kk'] ?>" data-ext="<?= strtolower(pathinfo('../'.$dtSiswa['buktiTf'], PATHINFO_EXTENSION)) ?>" data-title="Kartu Keluarga">
                            <i>Lihat File KK</i>
                        </a>
                        <br>
                        <small class="text-muted" style="font-style: italic">Maksimum ukuran file 5 mb.</small>
                    </div>
                </div>
                
                <div style="padding-left: 15px; padding-right: 15px">
                    <div class="form-group">
                        <button type="submit" name="update" class="btn btn-success btn-block">Perbarui Data Pendaftaran</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
            
</div>

<script>
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
    const validator = $("#form-data-siswa").validate({
        rules: {
            nisn_siswa : { 
                required: function(element) {
                    return $(element).val().length > 0;
                },
                digits : true 
            },
            nama_siswa : { required: true },
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
                required: function(element) {
                    return $(element).val().length > 0;
                },
                extension: "pdf|jpg|jpeg|png", 
                maxfilesize: 5242880 // 5 MB dalam byte
            },
            no_kartu_keluarga : { 
                required: true,
                digits: true, 
                minlength: 16, 
                maxlength: 16 
            },
        },
        messages: {
            nisn_siswa : {
                digits: "NISN siswa hanya boleh angka."
            },
            nama_siswa : "Nama siswa wajib diisi.",
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
                extension: "Format file harus PDF, JPG, JPEG, atau PNG.",
                maxfilesize: "Ukuran file maksimal 5 MB."
            },
            no_kartu_keluarga : {
                required: "No kartu keluarga wajib diisi.",
                minlength: "No kartu keluarga harus 16 digit.",
                maxlength: "No kartu keluarga harus 16 digit.",
                digits: "No kartu keluarga hanya boleh angka."
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "jenis_kelamin") {
                error.insertAfter(element.closest(".radio-success"));
            } else {
                error.insertAfter(element);
            }
            element.addClass('is-invalid');
        },
        success: function (label, element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            var formData = new FormData($('#form-data-siswa')[0]);
            $.ajax({
                url: 'data?act=' + encodeURIComponent('<?= encrypt('data-siswa') ?>'),
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
                        $('#btn-file-kk').data('file', resp.file);
                        $('#btn-file-kk').data('ext', resp.ext);
                        $('#btn-file-kk').show();
                        Swal.fire({
                            title: "Sukses",
                            text: resp.message,
                            icon: "success"
                        });
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
    });
</script>