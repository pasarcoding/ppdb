<?php
session_start();
error_reporting(1);
include "config/koneksi.php";

$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));

$query = "SELECT idTahunAjaran, nmTahunAjaran FROM tahun_ajaran WHERE idTahunAjaran >= 7 ORDER BY idTahunAjaran ASC";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (mysqli_num_rows($result) > 0) {
    // Menyimpan hasil query untuk digunakan dalam dropdown
    $tahunAjaranData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tahunAjaranData[] = $row;
    }
} else {
    $tahunAjaranData = [];
}

$successMessage = ''; // Menyimpan pesan sukses

// Proses penyimpanan data ke database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $tahunAjaran = $_POST['untukAjaran'];
    $nmSiswa = $_POST['nmSiswa'];
    $tempatLahir = $_POST['tempat_lahir'];
    $tglLahirSiswa = $_POST['tglLahirSiswa'];
    $alamatOrtu = $_POST['alamatOrtu'];
    $asalSekolah = $_POST['asal_sekolah'];
    $noHpIbu = $_POST['noHpIbu'];
    $noHpAyah = isset($_POST['noHpAyah']) ? $_POST['noHpAyah'] : null; // Opsional
    $sumberInformasi = $_POST['sumberInformasi'];
    $tanggal_pendaftaran = date('Y-m-d');
    // Membuat query untuk memasukkan data ke tabel siswa
    $query = "INSERT INTO siswa (nmSiswa, tempat_lahir, tanggal_pendaftaran, tglLahirSiswa, alamatOrtu, asal_sekolah, noHpSis, noHpOrtu, sumberInformasi, statusSiswa, untukAjaran)
              VALUES ('$nmSiswa', '$tempatLahir', '$tanggal_pendaftaran', '$tglLahirSiswa', '$alamatOrtu', '$asalSekolah', '$noHpIbu', '$noHpAyah', '$sumberInformasi','Inden','$tahunAjaran')";

    // Menjalankan query
    if (mysqli_query($conn, $query)) {
        // Mengambil ID siswa yang baru saja dimasukkan
        $idSiswa = mysqli_insert_id($conn);

        // Membuat query untuk memasukkan data ke tabel ppdb_status
        $queryStatus = "INSERT INTO ppdb_status (idSiswa) VALUES ('$idSiswa')";

        // Menjalankan query untuk memasukkan data ke tabel ppdb_status
        if (mysqli_query($conn, $queryStatus)) {
            // Jika data berhasil disimpan
            echo "<script>window.location='success.php';</script>";
        } else {
            // Jika terjadi error saat memasukkan ke ppdb_status
            echo "<script>alert('Terjadi kesalahan: " . mysqli_error($conn) . "'); window.location='daftar_titipan';</script>";
        }
    } else {
        // Jika terjadi error saat memasukkan ke tabel siswa
        echo "<script>alert('Terjadi kesalahan: " . mysqli_error($conn) . "'); window.location='daftar_titipan';</script>";
    }
}
?>


<?php include "header.php"; ?>

<body>
    <?php include "menu.php"; ?>

    <br><br><br><br>

    <section id="jadwal-pendaftaran" class="py-3 bg-transparent">
        <div class="container">
            <!-- Title Section -->
            <div class="section-title text-center pb-25">
                <h3 class="title">DAFTAR TITIPAN/INDEN PPDB</h3>
                <p class="lead text-muted">Silahkan isikan data siswa titipan</p>
            </div>
        </div>
    </section>
    <div class="container form-input mt-2 mb-3">
        <form action="" method="POST" class="form-input input-items">
            <!-- Tahun Ajaran -->
            <div class="row">

                <div class="col-md-6">

                    <div class="mb-3 form-style-five">
                        <label for="untukAjaran" class="form-label">Tahun Ajaran</label>
                        <div class="input-items default">
                            <select id="untukAjaran" name="untukAjaran" class="form-select" required>
                                <?php if (!empty($tahunAjaranData)): ?>
                                    <?php foreach ($tahunAjaranData as $tahun): ?>
                                        <option value="<?php echo $tahun['idTahunAjaran']; ?>">
                                            <?php echo $tahun['nmTahunAjaran']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Tidak ada tahun ajaran tersedia</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Calon Siswa -->
                    <div class="mb-3 form-style-five">
                        <label for="nmSiswa" class="form-label">Nama Calon Siswa</label>
                        <div class="input-items default">
                            <input type="text" id="nmSiswa" name="nmSiswa" class="form-control" required>
                        </div>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="mb-3 form-style-five">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <div class="input-items default">
                            <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" required>
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3 form-style-five">
                        <label for="tglLahirSiswa" class="form-label">Tanggal Lahir</label>
                        <div class="input-items default">
                            <input type="date" id="tglLahirSiswa" name="tglLahirSiswa" class="form-control" required>
                        </div>
                    </div>

                </div>
                <div class="col-md-6"> <!-- Alamat -->
                    <div class="mb-3 form-style-five">
                        <label for="alamatOrtu" class="form-label">Alamat</label>
                        <div class="input-items default">
                            <input type="text" id="alamatOrtu" name="alamatOrtu" class="form-control" required>
                        </div>
                    </div>

                    <!-- Sekolah Asal -->
                    <div class="mb-3 form-style-five">
                        <label for="asal_sekolah" class="form-label">Sekolah Asal</label>
                        <div class="input-items default">
                            <input type="text" id="asal_sekolah" name="asal_sekolah" class="form-control" required>
                        </div>
                    </div>

                    <!-- No HP Ibu -->
                    <div class="mb-3 form-style-five">
                        <label for="noHpIbu" class="form-label">No HP Ibu</label>
                        <div class="input-items default">
                            <input type="number" id="noHpIbu" name="noHpIbu" class="form-control" required>
                        </div>
                    </div>

                    <!-- No HP Ayah -->
                    <div class="mb-3 form-style-five">
                        <label for="noHpAyah" class="form-label">No HP Ayah</label>
                        <div class="input-items default">
                            <input type="number" id="noHpAyah" name="noHpAyah" class="form-control">
                        </div>
                    </div>


                </div>
            </div>

            <!-- Sumber Informasi -->
            <div class="mb-3 form-style-five">
                <label for="sumberInformasi" class="form-label">Sumber Informasi</label>
                <div class="input-items default">
                    <select id="sumberInformasi" name="sumberInformasi" class="form-select" required>
                        <option value="Google">Google</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Tiktok">Tiktok</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Website Sekolah">Website Sekolah</option>
                        <option value="Spanduk">Spanduk</option>
                        <option value="Saudara">Saudara</option>
                        <option value="Tetangga">Tetangga</option>
                        <option value="Teman Kerja">Teman Kerja</option>
                        <option value="Guru/Karyawan SD Muhammadiyah 3">Guru/Karyawan SD Muhammadiyah 3</option>
                        <option value="Alumni SD Muhammadiyah 3">Alumni SD Muhammadiyah 3</option>
                        <option value="Open House SD Muhammadiyah 3">Open House SD Muhammadiyah 3</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-success w-100 w-sm-auto">
                    Daftar
                </button>
            </div>
        </form>

    </div>

    <?php include "footer.php"; ?>

</body>

</html>