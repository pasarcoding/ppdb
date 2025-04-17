<?php
session_start();
error_reporting(1);
include "config/koneksi.php";
$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));

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

    <!--====== Favicon Icon ======-->

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
    <!-- Flatpickr CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->

    <!-- Flatpickr JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->

</head>