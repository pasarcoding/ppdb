

<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="box" style="border: none;">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="../<?= $dtSiswa['ttdOrtu'] ?>" class="img-fluida" width="100%">
                        </div>

                        <div class="col-md-6 text-center">
                            <img src="../<?= $dtSiswa['foto_siswa'] ?>" class="img-fluida img-foto-siswa" width="100%">
                            <strong style="font-size: 16px;"><?= strtoupper($dtSiswa['nmSiswa']) ?></strong>
                            <br>
                            <span style="font-size: 12px;"><?= $idt['nmSekolah'] ?></span>
                        </div>
                        </div>

                        <!-- Baris khusus untuk tombol-tombol -->
                        <div class="row" style="margin-top: 15px;">
                        <div class="col-md-6">
                            <a href="../siswa/formulir" target="_blank" class="btn btn-primary btn-block btn-sm">
                                Unduh Formulir Pendaftaran
                            </a>
                        </div>

                        <div class="col-md-6">
                            <form id="form-foto" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>
                                <label class="btn btn-info btn-block btn-sm">
                                    Ganti Foto
                                    <input type="file" name="upload_foto_siswa" id="upload_foto_siswa" style="display: none;" accept=".jpg,.jpeg,.png" required>
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box" style="border: none;">
                <div class="box-header" style="background-color: #00a65a; color:white;">
                    <h3 class="box-title" style="font-size: 15px;"><strong>FORM PEMBAYARAN PENDAFTARAN</strong></h3>
                </div>
                <div class="box-body">
                    <form id="form-pembayaran" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>
                            <div class="form-group col-md-6">
                                <label>Status Pembayaran</label>
                                <input type="text" class="form-control" style="background-color: white;" id="status_pembayaran" value="<?= !empty($dtSiswa['buktiTf']) ? $dtSiswa['statusPembayaran'] : '-' ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Bayar</label>
                                <input type="text" class="form-control" style="background-color: white;" id="tanggal_bayar" value="<?= !empty($dtSiswa['tglBayarTf']) ? tgl_raport($dtSiswa['tglBayarTf']) : '-' ?>" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Cara Bayar</label>
                                <input type="text" class="form-control" style="background-color: white;" value="TRANFER" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Upload Bukti Transfer</label>
                                <input type="file" name="upload_bukti_transfer" id="upload_bukti_transfer" class="form-control" accept=".jpg,.jpeg,.png" required>
                                <a <?= !empty($dtSiswa['buktiTf']) ? '' : 'style="display:none"' ?> href="#" class="text-sm btn-pdf-images" id="btn-bukti-tf" data-file="<?= '../'.$dtSiswa['buktiTf'] ?>" data-ext="<?= strtolower(pathinfo('../'.$dtSiswa['buktiTf'], PATHINFO_EXTENSION)) ?>" data-title="Bukti Transfer">
                                    <i>Lihat Bukti Transfer</i>
                                </a>
                            </div>
                            <div class="form-group col-md-12">
                                <button class="btn btn-primary btn-sm btn-block">Upload Bukti Transfer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box" style="border: none;">
                <div class="box-header" style="background-color: #00a65a; color:white;">
                    <h3 class="box-title" style="font-size: 15px;"><strong>STATUS PENDAFTARAN</strong></h3>
                </div>
                <div class="box-body">
                    <strong>STATUS : <?= $dtSiswa['statusPendafataran'] ?></strong>
                    <br>
                    Status Pendaftaran Anda di sekolah <strong><?= $idt['nmSekolah'] ?></strong> Sampai saat ini adalah <strong><?= $dtSiswa['statusPendafataran'] ?></strong>
                </div>
            </div>
            <div class="box" style="border: none;">
                <div class="box-header" style="background-color: #00a65a; color:white;">
                    <h3 class="box-title" style="font-size: 15px;"><strong>STATUS PEMBERKASAN</strong></h3>
                </div>
                <div class="box-body">
                    <strong>STATUS : <?= $dtSiswa['statusPemberkasan'] ?></strong>
                    <br>
                    <table>
                        <tr>
                            <td>
                                <table border="1" width="210px">
                                    <tr>
                                        <td style="padding-left:10px">FORMULIR</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px">SURAT PERNYATAAN</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px">Asli KTP</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px">Asli KK</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px">Asli AKTA KELAHIRAN</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="20px"></td>
                            <td>
                                <table border="1" width="100px">
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['formulir'] ?? 'BELUM' ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['suratPernyataan'] ?? 'BELUM' ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['asliKTP'] ?? 'BELUM' ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['asliKK'] ?? 'BELUM' ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['asliAktaKelahiran'] ?? 'BELUM' ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table border="1" width="210px">
                                    <tr>
                                        <td style="padding-left:10px">Copy KTP</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px">Copy KK</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px">Copy AKTA KELAHIRAN</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px">Copy DTKS (bagi jalur Afirmasi)</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="20px"></td>
                            <td>
                                <table border="1" width="100px">
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['copyKTP'] ?? 'BELUM' ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['copyKK'] ?? 'BELUM' ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['copyAktaKelahiran'] ?? 'BELUM' ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:10px"><?= $dtSiswa['copyDTKAS'] ?? 'TIDAK' ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#upload_foto_siswa').on('change', function() {
        if (this.files.length > 0) {
            $('#form-foto').submit();
        }
    });

    $('#form-foto').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'data?act=' + encodeURIComponent('<?= encrypt('foto') ?>'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false, 
            dataType: 'json', 
            success: function(resp) {
                if (!resp.status){
                    Swal.fire({
                        title: "Gagal",
                        text: resp.message,
                        icon: "error"
                    });
                }else{
                    $('.img-foto-siswa').attr('src', resp.foto);
                    Swal.fire({
                        title: "Sukses",
                        text: resp.message,
                        icon: "success"
                    });
                    $('#form-foto')[0].reset();
                }
            },
            error: function() {
                Swal.fire({
                    title: "Gagal",
                    text: "Terjadi kesalahan, silahkan refresh halaman ini.",
                    icon: "error"
                });
            }
        })
    });

    $('#form-pembayaran').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'data?act=' + encodeURIComponent('<?= encrypt('bukti-bayar') ?>'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false, 
            dataType: 'json', 
            success: function(resp) {
                if (!resp.status){
                    Swal.fire({
                        title: "Gagal",
                        text: resp.message,
                        icon: "error"
                    });
                }else{
                    $('#status_pembayaran').val(resp.status_pembayaran);
                    $('#tanggal_bayar').val(resp.tanggal_bayar);
                    $('#btn-bukti-tf').data('file', resp.file);
                    $('#btn-bukti-tf').data('ext', resp.ext);
                    $('#btn-bukti-tf').show();
                    $('#form-pembayaran')[0].reset();
                    Swal.fire({
                        title: "Sukses",
                        text: resp.message,
                        icon: "success"
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "Gagal",
                    text: "Terjadi kesalahan, silahkan refresh halaman ini.",
                    icon: "error"
                });
            }
        })
    });
</script>