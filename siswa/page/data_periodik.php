<div class="col-md-12">
    
    <div class="box" style="border: none;">
        <div class="box-body" style="padding:0">
            <form id="form-data-periodik" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>

                <div style="background-color: #00a65a; color: white; padding: 10px; font-weight: bold;">
                    DATA PERIODIK
                </div>

                <div style="padding: 15px">
                    <div class="form-group">
                        <label for="tinggi_badan">Tinggi Badan <span class="text-danger">*</span></label>
                        <input type="number" id="tinggi_badan" name="tinggi_badan" class="form-control" placeholder="Masukkan Tinggi Badan" required onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['tinggi_badan'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="berat_badan">Berat Badan <span class="text-danger">*</span></label>
                        <input type="number" id="berat_badan" name="berat_badan" class="form-control" placeholder="Masukkan Berat Badan" required onkeypress="return hanyaAngka(event)" value="<?= $dtSiswa['berat_badan'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="jarak_tempat_tinggal_ke_sekolah">Jarak Tempat Tinggal ke Sekolah <span class="text-danger">*</span></label>
                        <select id="jarak_tempat_tinggal_ke_sekolah" name="jarak_tempat_tinggal_ke_sekolah" class="form-control" required>
                            <option value="">- PILIH JARAK -</option>
                            <option <?= $dtSiswa['jarak_tempuh'] == 'LEBIH DARI 1 KM' ? 'selected' : '' ?>>LEBIH DARI 1 KM</option>
                            <option <?= $dtSiswa['jarak_tempuh'] == 'KURANG DARI 1 KM' ? 'selected' : '' ?>>KURANG DARI 1 KM</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="waktu_tempuh_ke_sekolah">Waktu Tempuh ke Sekolah <span class="text-danger">*</span></label>
                        <input type="text" id="waktu_tempuh_ke_sekolah" name="waktu_tempuh_ke_sekolah" class="form-control" placeholder="Masukkan Waktu Tempuh ke Sekolah" required value="<?= $dtSiswa['waktu_tempuh'] ?>">
                        <small class="text-muted" style="font-style: italic">Contoh: 1 jam 30 menit atau 15 menit</small>
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
    const validator = $("#form-data-periodik").validate({
        rules: {
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
        },
        messages: {
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
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            element.addClass('is-invalid');
        },
        success: function (label, element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            var formData = new FormData($('#form-data-periodik')[0]);
            $.ajax({
                url: 'data?act=' + encodeURIComponent('<?= encrypt('data-periodik') ?>'),
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