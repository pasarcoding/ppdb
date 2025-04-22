
<?php include "header.php"; ?>

<body>
    <?php include "menu.php"; ?>

    <br><br><br><br>
    
    <?php 
        $countGelombangAktif = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM ppdb_gelombang WHERE mulai <= '$dateNow' AND selesai >= '$dateNow' AND idTahunAjaran='$ta_aktif[idTahunAjaran]'"));
    ?>
    <section class="py-3 bg-transparent">
        <div class="container">
            <!-- Title Section -->
            <div class="section-title text-center pb-25">
                <h3 class="title">JADWAL PPDB <?= strtoupper($ta_aktif['nmTahunAjaran']) ?></h3>
                <p class="text-muted"><?= ($countGelombangAktif == 0 ? '<span class="text-danger">Pendaftaran ditutup</span>' : '<span class="text-success">Pendaftaran dibuka</span>') ?></p>
            </div>
            
            <!-- Content -->
            <div class="container form-input mb-5">
                <?php
                    $key = 0;
                    $qGelombang = mysqli_query($conn, "SELECT * FROM ppdb_gelombang WHERE idTahunAjaran='$ta_aktif[idTahunAjaran]' ORDER BY idGlombang ASC");
                    while ($dt = mysqli_fetch_assoc($qGelombang)) :
                        if ($dt['mulai'] <= $dateNow && $dt['selesai'] >= $dateNow){
                            $style = ' background-color: #28a745;';
                            $status = '<span class="text-success">Aktif</span>';
                        }else{
                            $style = ' background-color: #dc3545;';
                            $status = '<span class="text-danger">Tidak Aktif</span>';
                        }
                ?>
                        <div class="accordion" id="accordionJadwal" style="font-size:0.875rem !important; ">
                            <div class="card">
                                <div class="card-header" id="heading<?= $key ?>" style="<?= $style ?> padding: .5rem;">
                                    <h2 class="mb-0">
                                        <button style="text-decoration: none; color: white;  font-size:0.875rem" class="btn btn-link collapsed d-flex justify-content-between align-items-center w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="false" aria-controls="collapse<?= $key ?>">
                                            <?= $dt['nmGelombang'] ?>
                                            <i class="fas fa-chevron-down arrow-icon ml-auto"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>" data-parent="#accordionJadwal">
                                    <div class="card-body" style="border-bottom: 1px solid #dee2e6;">
                                        <ul style="list-style-type: disc; padding-left:20px;">
                                            <li class="p-2">
                                                <strong>Tanggal Dibuka / Ditutup</strong>
                                                <br><?= tgl_raport($dt['mulai']).' - '.tgl_raport($dt['selesai']) ?>
                                            </li>
                                            <li class="p-2">
                                                <strong>Biaya</strong> 
                                                <br><?= buatRp($dt['biaya']) ?>
                                            </li>
                                            <li class="p-2">
                                                <strong>Status Gelombang</strong> 
                                                <br><?= $status ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php 
                        $key++; 
                    endwhile; 
                ?>
            </div>
            <div class="container text-center mb-5">
                <button type="button" class="btn btn-success btn-block px-4 py-2 btn-daftar" <?= $countGelombangAktif == 0 ? 'disabled' : '' ?>>
                    <?= $countGelombangAktif == 0 ? 'Pendaftaran Ditutup' : 'Daftar Sekarang' ?>
                </button>
            </div>
        </div>
    </section>
    
    <?php include "footer.php"; ?>
    
    <script>
        $(document).on('click', '.btn-daftar', function(){
            const btn = $(this);
            btn.attr('disabled', true);
            const token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'data/daftar?act=' + encodeURIComponent('<?= encrypt('jadwal') ?>'),
                method: 'POST',
                data: { token:token },
                dataType: 'json', 
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
                error: function() {
                    Swal.fire({
                        title: "Gagal",
                        text: "Terjadi kesalahan, silahkan refresh halaman ini.",
                        icon: "error"
                    });
                },
                complete: function() {
                    btn.attr('disabled', false);
                }
            })
        });
    </script>
</body>

</html>