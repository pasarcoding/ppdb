<div class="col-md-12">
    
    <div class="box" style="border: none;">
        <div class="box-body" style="padding:0">
            <form id="form-data-ortu" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>

                <div style="background-color: #00a65a; color: white; padding: 10px; font-weight: bold;">
                    DATA AYAH
                </div>

                <div style="padding: 15px">
                    <div class="form-group">
                        <label for="nik_ayah">NIK Ayah</label>
                        <input type="text" id="nik_ayah" name="nik_ayah" class="form-control" placeholder="Masukkan NIK Ayah" onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['nik_ayah'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_ayah">Nama Ayah <span class="text-danger">*</span></label>
                        <input type="text" id="nama_ayah" name="nama_ayah" class="form-control" placeholder="Masukkan Nama Ayah" required value="<?= $dtSiswa['nama_ayah'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="no_hp_ayah">No HP Ayah <span class="text-danger">*</span></label>
                        <input type="text" id="no_hp_ayah" name="no_hp_ayah" class="form-control" placeholder="Masukkan No HP Ayah" required onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['noHpOrtu'] ?>">
                        <small class="text-muted" style="font-style: italic">Masukkan nohp ortu/wali (informasi login akun siswa akan diinfokan via whatsapp)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="email_ayah_atau_ibu">Email Ayah/Ibu</label>
                        <input type="email" id="email_ayah_atau_ibu" name="email_ayah_atau_ibu" class="form-control" placeholder="Masukkan Email Ayah atau Ibu" value="<?= $dtSiswa['email_ayah_ibu'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="tempat_lahir_ayah">Tempat Lahir Ayah</label>
                        <input type="text" id="tempat_lahir_ayah" name="tempat_lahir_ayah" class="form-control" placeholder="Masukkan Tempat Lahir Ayah" value="<?= $dtSiswa['tmpt_lahir_ayah'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir_ayah">Tanggal Lahir Ayah</label>
                        <input type="text" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" class="form-control class-date-picker" style="background-color: white;" placeholder="Masukkan Tanggal Lahir Ayah (YYYY-MM-DD)" value="<?= $dtSiswa['tgl_lahir_ayah'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="pendidikan_terakhir_ayah">Pendidikan Terakhir Ayah</label>
                        <select id="pendidikan_terakhir_ayah" name="pendidikan_terakhir_ayah" class="form-control">
                            <option value="">- PILIH PENDIDIKAN TERAKHIR AYAH -</option>
                            <?php
                                $qPendidikan= mysqli_query($conn, "SELECT * FROM rb_pendidikan ORDER BY id ASC");
                                while ($dt = mysqli_fetch_assoc($qPendidikan)){
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['id'] == $dtSiswa['pendidikan_terakhir_ayah'] ? 'selected' : '').'>'.strtoupper($dt['tingkat_pendidikan']).'</option>';
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
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['id'] == $dtSiswa['pekerjaan_ayah'] ? 'selected' : '').'>'.strtoupper($dt['pekerjaan']).'</option>';
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
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['id'] == $dtSiswa['penghasilan_ayah'] ? 'selected' : '').'>'.strtoupper($dt['kategori']).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div style="background-color: #00a65a; color: white; padding: 10px; font-weight: bold;">
                    DATA IBU
                </div>

                <div style="padding: 15px">
                    <div class="form-group">
                        <label for="nik_ibu">NIK Ibu</label>
                        <input type="text" id="nik_ibu" name="nik_ibu" class="form-control" placeholder="Masukkan NIK Ibu" onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['nik_ibu'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu <span class="text-danger">*</span></label>
                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-control" placeholder="Masukkan Nama Ibu" required value="<?= $dtSiswa['nama_ibu'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="no_hp_ibu">No HP Ibu</label>
                        <input type="text" id="no_hp_ibu" name="no_hp_ibu" class="form-control" placeholder="Masukkan No HP Ibu" onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['noHpIbu'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="tempat_lahir_ibu">Tempat Lahir Ibu</label>
                        <input type="text" id="tempat_lahir_ibu" name="tempat_lahir_ibu" class="form-control" placeholder="Masukkan Tempat Lahir Ibu"  value="<?= $dtSiswa['tmpt_lahir_ibu'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir_ibu">Tanggal Lahir Ibu</label>
                        <input type="text" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" class="form-control class-date-picker" style="background-color: white;" placeholder="Masukkan Tanggal Lahir Ibu (YYYY-MM-DD)"  value="<?= $dtSiswa['tgl_lahir_ibu'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="pendidikan_terakhir_ibu">Pendidikan Terakhir Ibu</label>
                        <select id="pendidikan_terakhir_ibu" name="pendidikan_terakhir_ibu" class="form-control">
                            <option value="">- PILIH PENDIDIKAN TERAKHIR IBU -</option>
                            <?php
                                $qPendidikan= mysqli_query($conn, "SELECT * FROM rb_pendidikan ORDER BY id ASC");
                                while ($dt = mysqli_fetch_assoc($qPendidikan)){
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['id'] == $dtSiswa['pendidikan_terakhir_ibu'] ? 'selected' : '').'>'.strtoupper($dt['tingkat_pendidikan']).'</option>';
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
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['id'] == $dtSiswa['pekerjaan_ibu'] ? 'selected' : '').'>'.strtoupper($dt['pekerjaan']).'</option>';
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
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['id'] == $dtSiswa['penghasilan_ibu'] ? 'selected' : '').'>'.strtoupper($dt['kategori']).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div style="background-color: #00a65a; color: white; padding: 10px; font-weight: bold;">
                    TANDA TANGAN ORANG TUA
                </div>

                <div style="padding: 15px">
                    <div class="form-group">
                        <label for="foto_tanda_tangan_ayah_atau_ibu">Foto Tanda Tangan Ayah/Ibu <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="foto_tanda_tangan_ayah_atau_ibu" name="foto_tanda_tangan_ayah_atau_ibu" accept=".jpg,.jpeg,.png">
                        <a <?= !empty($dtSiswa['ttdOrtu']) ? '' : 'style="display:none"' ?> href="#" class="text-sm btn-pdf-images" id="btn-foto-ttd" data-file="<?= '../'.$dtSiswa['ttdOrtu'] ?>" data-ext="<?= strtolower(pathinfo('../'.$dtSiswa['buktiTf'], PATHINFO_EXTENSION)) ?>" data-title="Tanda Tangan Orang Tua">
                            <i>Lihat Foto TTD</i>
                        </a>
                        <br>
                        <small class="text-muted" style="font-style: italic">Maksimum ukuran file 2 mb.</small>
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
    const validator = $("#form-data-ortu").validate({
        rules: {
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
                required: function(element) {
                    return $(element).val().length > 0;
                },
                extension: "jpg|jpeg|png",
                maxfilesize: 2097152 // 2 MB dalam byte
            },
        },
        messages: {
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
                extension: "Hanya file JPG, JPEG, atau PNG yang diperbolehkan.",
                maxfilesize: "Ukuran file maksimal 2 MB."
            },
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            element.addClass('is-invalid');
        },
        success: function (label, element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            var formData = new FormData($('#form-data-ortu')[0]);
            $.ajax({
                url: 'data?act=' + encodeURIComponent('<?= encrypt('data-ortu') ?>'),
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
                        $('#btn-foto-ttd').data('file', resp.file);
                        $('#btn-foto-ttd').data('ext', resp.ext);
                        $('#btn-foto-ttd').show();
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