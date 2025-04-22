
<?php include "header.php"; ?>

<link rel="stylesheet" href="assets/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables/css/responsive.bootstrap4.min.css">

<body>
    <?php include "menu.php"; ?>

    <br><br><br><br>
    
    <section class="py-3 bg-transparent">
        <div class="container">
            <!-- Title Section -->
            <div class="section-title text-center pb-25">
                <h3 class="title">PENDAFTAR</h3>
            </div>

            <!-- Alert -->
            <div class="alert alert-primary" role="alert">
                Pastikan <b>NAMA CALON SISWA</b> terdaftar di halaman ini setelah <b>MELAKUKAN PENDAFTARAN</b>
            </div>
            
            <!-- Content -->
            <dic class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="data-pendaftar" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Pendaftaran</th>
                                <th>Nama Lengkap</th>
                                <th>Asal Sekolah</th>
                                <th>Status Pendaftaran</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </dic>
        </div>
    </section>
    
    <?php include "footer.php"; ?>

    <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = $('meta[name="csrf-token"]').attr('content');
            $('#data-pendaftar').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "data/pendaftar?act=" + encodeURIComponent('<?= encrypt('data') ?>'),
                    type: "POST",
                    data: { token:token },
                },
                columns: [
                    { data: 'no' },
                    { data: 'no_pendaftaran' },
                    { data: 'nama_lengkap' },
                    { data: 'asal_sekolah' },
                    { data: 'status_pendaftaran' }
                ]
            });
        });
    </script>
</body>

</html>