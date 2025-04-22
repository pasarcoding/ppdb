<div class="col-md-12">
    
    <div class="box" style="border: none;">
        <div class="box-body" style="padding:0">
            <form id="form-data-pendaftaran" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>

                <div style="background-color: #00a65a; color: white; padding: 10px; font-weight: bold;">
                    DATA PENDAFTARAN
                </div>

                <div style="padding: 15px">
                    <div class="form-group">
                        <label for="tanggal_pendaftaran">Tanggal Pendaftaran <span class="text-danger">*</span></label>
                        <input type="text" id="tanggal_pendaftaran" name="tanggal_pendaftaran" placeholder="Masukkan Tanggal Pendaftaran" class="form-control bg-white" required readonly value="<?= tgl_raport($dtSiswa['tanggal_pendaftaran']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="jalur_pendaftaran">Jalur Pendaftaran <span class="text-danger">*</span></label>
                        <select id="jalur_pendaftaran" name="jalur_pendaftaran" class="form-control" required>
                            <option value="">- PILIH JALUR -</option>
                            <?php
                                $qJalurPpdb = mysqli_query($conn, "SELECT * FROM ppdb_jalur ORDER BY idJalur ASC");
                                while ($dt = mysqli_fetch_assoc($qJalurPpdb)){
                                    echo '<option value="'.encrypt($dt['idJalur']).'" '.($dt['idJalur'] == $dtSiswa['jalur_pendaftaran'] ? 'selected' : '').'>'.strtoupper($dt['nmJalur']).'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tahun_ajaran_atau_gelombang">Tahun Ajaran / Gelombang <span class="text-danger">*</span></label>
                        <input type="text" id="tahun_ajaran_atau_gelombang" name="tahun_ajaran_atau_gelombang" placeholder="Masukkan Tahun Ajaran / Gelombang" class="form-control bg-white" value="<?= $dtSiswa['gelombang_tahun_ajaran'] ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="biaya">Biaya <span class="text-danger">*</span></label>
                        <input type="text" id="biaya" name="biaya" class="form-control bg-white" placeholder="Masukkan Biaya" value="<?= buatRp($dtSiswa['biaya']) ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="asal_sekolah">Asal Sekolah <span class="text-danger">*</span></label>
                        <select id="asal_sekolah" name="asal_sekolah" class="form-control" required>
                            <option value="">- PILIH ASAL SEKOLAH -</option>
                            <option <?= $dtSiswa['tipe_asal_sekolah'] == 'TK' ? 'selected' : '' ?>>TK</option>
                            <option <?= $dtSiswa['tipe_asal_sekolah'] == 'RA' ? 'selected' : '' ?>>RA</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="npsn_sekolah">NPSN Sekolah</label>
                        <input type="text" id="npsn_sekolah" name="npsn_sekolah" class="form-control" placeholder="Masukkan NPSN Sekolah" value="<?= $dtSiswa['npsn_sekolah'] ?>" onkeypress="return hanyaAngka(event)">
                        <small><i>Hanya Bisa Diisi dengan 8 Digit Angka</i></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_asal_sekolah">Nama Asal Sekolah <span class="text-danger">*</span></label>
                        <input type="text" id="nama_asal_sekolah" name="nama_asal_sekolah" class="form-control" placeholder="Masukkan Nama Sekolah" value="<?= $dtSiswa['asal_sekolah'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="kecamatan_TK_atau_RA_asal">Kecamatan TK/RA Asal</label>
                        <input type="text" id="kecamatan_TK_atau_RA_asal" name="kecamatan_TK_atau_RA_asal" class="form-control" placeholder="Masukkan Kecamatan TK/RA Asal" value="<?= $dtSiswa['kecamatan_sekolah_asal'] ?>">
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

    // Inisialisasi validasi form
    const validator = $("#form-data-pendaftaran").validate({
        rules: {
            tanggal_pendaftaran: { required: true },
            jalur_pendaftaran: { required: true },
            tahun_ajaran_atau_gelombang: { required: true },
            biaya : { required: true },
            npsn_sekolah : { 
                required: function(element) {
                    return $(element).val().length > 0;
                },
                digits : true, 
                minlength: 8, 
                maxlength: 8 
            },
            asal_sekolah : { required: true },
            nama_asal_sekolah : { required: true },
        },
        messages: {
            tanggal_pendaftaran: "Tanggal pendaftaran wajib diisi.",
            jalur_pendaftaran: "Jalur pendaftaran belum dipilih.",
            tahun_ajaran_atau_gelombang: "Tahun ajaran/gelombang wajib diisi.",
            biaya: "Biaya wajib diisi.",
            npsn_sekolah : {
                digits: "NPSN sekolah hanya boleh angka.",
                minlength: "NPSN sekolah harus 8 digit",
                maxlength: "NPSN sekolah harus 8 digit",
            },
            asal_sekolah: "Asal sekolah wajib diisi.",
            nama_asal_sekolah: "Nama asal sekolah wajib diisi.",
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            element.addClass('is-invalid');
        },
        success: function (label, element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            var formData = new FormData($('#form-data-pendaftaran')[0]);
            $.ajax({
                url: 'data?act=' + encodeURIComponent('<?= encrypt('data-pendaftaran') ?>'),
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