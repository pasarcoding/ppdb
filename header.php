<?php
session_start();
error_reporting(1);
include "config/koneksi.php";
include "config/enkripsi_deskripsi.php";
include "config/fungsi_login.php";
include 'config/fungsi_indotgl.php';
include 'config/library.php';

$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
$ta_aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE aktif='Y' LIMIT 1"));
$dateNow = date('Y-m-d');

// CSRF TOKEN
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB | SD Muhammadiyah 3 Bandung</title>
    <link rel="shortcut icon" href="<?= $idt['url'] ?>/gambar/logo/<?php echo $idt['logo_kanan']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--====== Title ======-->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <!--====== Font Awesome ======-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <!--====== Magnific Popup CSS ======-->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="assets/css/slick.css">

    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="assets/css/LineIcons.css">

    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="assets/css/default.css">

    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!--====== Swetalert CSS ======-->
    <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="assets/plugins/flatpickr/flatpickr.min.css">
    
    <!-- Flatpickr JS -->
    <script src="assets/plugins/flatpickr/flatpickr.js"></script>
    <script src="assets/plugins/flatpickr/l10n/id.js"></script>

    <!--====== Sweetalert ======-->
    <script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
</head>