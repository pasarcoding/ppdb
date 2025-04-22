<?php
    if ($view == 'dashboard' || $view == '') {
        echo "<div class='row'>";
        include "page/dashboard.php";
        echo "</div>";

    }elseif ($view == 'data-pendaftar') {
        echo "<div class='row'>";
        include "page/data_pendaftar.php";
        echo "</div>";

    }elseif ($view == 'data-siswa') {
        echo "<div class='row'>";
        include "page/data_siswa.php";
        echo "</div>";

    }elseif ($view == 'data-ortu') {
        echo "<div class='row'>";
        include "page/data_ortu.php";
        echo "</div>";

    }elseif ($view == 'data-alamat') {
        echo "<div class='row'>";
        include "page/data_alamat.php";
        echo "</div>";

    }elseif ($view == 'data-periodik') {
        echo "<div class='row'>";
        include "page/data_periodik.php";
        echo "</div>";
        
    }elseif ($view == 'data-prestasi') {
        
        echo "<div class='row'>";
        include "page/data_prestasi.php";
        echo "</div>";
    }
?>