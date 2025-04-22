<div class="col-md-12">
    
    <div class="box" style="border: none;">
        <div class="box-body" style="padding:0">
            <form id="form-data-alamat" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>

                <div style="background-color: #00a65a; color: white; padding: 10px; font-weight: bold;">
                    DATA ALAMAT
                </div>

                <div style="padding: 15px">
                    <div class="form-group">
                        <label for="provinsi">Provinsi <span class="text-danger">*</span></label>
                        <select id="provinsi" name="provinsi" class="form-control" required>
                            <option value="">- PILIH PROVINSI -</option>
                            <?php
                                $qProvinsi= mysqli_query($conn, "SELECT * FROM rb_provinsi ORDER BY id ASC");
                                while ($dt = mysqli_fetch_assoc($qProvinsi)){
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['name'] == $dtSiswa['provinsi'] ? 'selected' : '').'>'.strtoupper($dt['name']).'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kota_atau_kabupaten">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <select id="kota_atau_kabupaten" name="kota_atau_kabupaten" class="form-control" required>
                            <option value="">- PILIH KOTA/KABUPATEN -</option>
                            <?php
                                $qProvinsi= mysqli_query($conn, "SELECT rb_kabupaten.* FROM rb_kabupaten 
                                    INNER JOIN rb_provinsi ON rb_kabupaten.provinsi_id=rb_provinsi.id 
                                    WHERE rb_provinsi.name='$dtSiswa[provinsi]' ORDER BY rb_kabupaten.id ASC");
                                while ($dt = mysqli_fetch_assoc($qProvinsi)){
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['type'].' '. $dt['name'] == $dtSiswa['kab_kota'] ? 'selected' : '').'>'.strtoupper($dt['name']).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan <span class="text-danger">*</span></label>
                        <select id="kecamatan" name="kecamatan" class="form-control" required>
                            <option value="">- PILIH KECAMATAN -</option>
                            <?php
                                $qProvinsi= mysqli_query($conn, "SELECT rb_kecamatan.* FROM rb_kecamatan 
                                    INNER JOIN rb_kabupaten ON rb_kecamatan.kabupaten_id=rb_kabupaten.id 
                                    WHERE CONCAT(rb_kabupaten.type,' ',rb_kabupaten.name)='$dtSiswa[kab_kota]' ORDER BY rb_kecamatan.id ASC");
                                while ($dt = mysqli_fetch_assoc($qProvinsi)){
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['name'] == $dtSiswa['kecamatan'] ? 'selected' : '').'>'.strtoupper($dt['name']).'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kelurahan">Kelurahan <span class="text-danger">*</span></label>
                        <select id="kelurahan" name="kelurahan" class="form-control" required>
                            <option value="">- PILIH KELURAHAN -</option>
                            <?php
                                $qProvinsi= mysqli_query($conn, "SELECT rb_kelurahan.* FROM rb_kelurahan 
                                    INNER JOIN rb_kecamatan ON rb_kelurahan.kecamatan_id=rb_kecamatan.id 
                                    WHERE rb_kecamatan.name='$dtSiswa[kecamatan]' ORDER BY rb_kelurahan.id ASC");
                                while ($dt = mysqli_fetch_assoc($qProvinsi)){
                                    echo '<option value="'.encrypt($dt['id']).'" '.($dt['name'] == $dtSiswa['kelurahan'] ? 'selected' : '').'>'.strtoupper($dt['name']).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <?php $rtrw = explode(' ', $dtSiswa['rt_rw']); ?>
                    <div class="form-group">
                        <label for="rt">RT <span class="text-danger">*</span></label>
                        <input type="text" id="rt" name="rt" class="form-control" placeholder="Masukkan RT" required onkeypress="return hanyaAngka(event)" value="<?= $rtrw[0] ?>">
                    </div>

                    <div class="form-group">
                        <label for="rw">RW <span class="text-danger">*</span></label>
                        <input type="text" id="rw" name="rw" class="form-control" placeholder="Masukkan RW" required onkeypress="return hanyaAngka(event)" value="<?= $rtrw[1] ?>">
                    </div>

                    <div class="form-group">
                        <label for="koordinat_lintang">Koordinat Lintang</label>
                        <input type="text" id="koordinat_lintang" name="koordinat_lintang" class="form-control" placeholder="Kosongkan Jika Belum Tahu" value="<?= $dtSiswa['koordinat_lintang'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="koordinat_bujur">Koordinat Bujur</label>
                        <input type="text" id="koordinat_bujur" name="koordinat_bujur" class="form-control" placeholder="Kosongkan Jika Belum Tahu" value="<?= $dtSiswa['koordinat_bujur'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat Jalan / Gang dan No Rumah Saja" rows="4" required><?= $dtSiswa['alamatOrtu'] ?></textarea>
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
    const validator = $("#form-data-alamat").validate({
        rules: {
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
        },
        messages: {
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
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            element.addClass('is-invalid');
        },
        success: function (label, element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            var formData = new FormData($('#form-data-alamat')[0]);
            $.ajax({
                url: 'data?act=' + encodeURIComponent('<?= encrypt('data-alamat') ?>'),
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