<section class="sidebar">
	<font face="Arial">
		<!-- Sidebar user panel -->
		<div class="user-panel" style="height:65px; display: flex; align-items: center;">
			<div class="pull-left image">
				<img src="<?= '../'.$dtSiswa['foto_siswa'] ?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?= strtoupper($dtSiswa['nmSiswa']) ?></p>
				<a href="#"><?= $ta['nmTahunAjaran'].' | '.$dtSiswa['nmGelombang'] ?></a>
			</div>
		</div>

		<?php
            switch ($view) {
                case 'data-pendaftar':
                    $judul = "<span class='fa fa-user'></span> Data Pendaftaran";
                    $aktifBiodata = 'active';
                    $aktifBiodata1 = 'active';
                    break;
                case 'data-siswa':
                    $judul = "<span class='fa fa-user'></span> Data Siswa";
                    $aktifBiodata = 'active';
                    $aktifBiodata2 = 'active';
                    break;
                case 'data-ortu':
                    $judul = "<span class='fa fa-users'></span> Data Orang Tua";
                    $aktifBiodata = 'active';
                    $aktifBiodata3 = 'active';
                    break;
                case 'data-alamat':
                    $judul = "<span class='fa fa-map-marker'></span> Data Alamat";
                    $aktifBiodata = 'active';
                    $aktifBiodata4 = 'active';
                    break;
                case 'data-periodik':
                    $judul = "<span class='fa fa-clock-o'></span> Data Periodik";
                    $aktifBiodata = 'active';
                    $aktifBiodata5 = 'active';
                    break;
                case 'data-prestasi':
                    $judul = "<span class='fa fa-star'></span> Data Prestasi (Jika Ada)";
                    $aktifBiodata = 'active';
                    $aktifBiodata6 = 'active';
                    break;
                default:
                    $judul = "<span class='fa fa-dashboard'></span> Dashboard";
                    $aktifHome = 'active';
            }
		?>

		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo $aktifHome; ?>"><a href="./"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="treeview <?php echo $aktifBiodata; ?>">
                <a href="#">
                    <i class="fa fa-edit faa-shake animated"></i>
                    <span>Biodata Siswa</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo $aktifBiodata1; ?>"><a href="index?view=data-pendaftar"><i class="fa fa-minus"></i> Data Pendaftar</a></li>
                    <li class="<?php echo $aktifBiodata2; ?>"><a href="index?view=data-siswa"><i class="fa fa-minus"></i> Data Siswa</a></li>
                    <li class="<?php echo $aktifBiodata3; ?>"><a href="index?view=data-ortu"><i class="fa fa-minus"></i> Data Ortu</a></li>
                    <li class="<?php echo $aktifBiodata4; ?>"><a href="index?view=data-alamat"><i class="fa fa-minus"></i> Data Alamat</a></li>
                    <li class="<?php echo $aktifBiodata5; ?>"><a href="index?view=data-periodik"><i class="fa fa-minus"></i> Data Periodik</a></li>
                    <li class="<?php echo $aktifBiodata6; ?>"><a href="index?view=data-prestasi"><i class="fa fa-minus"></i> Data Prestasi <span class="pull-right badge" style="font-size: 9px; padding-top:5px; background-color: #dc3545;">New</span></a></li>
                </ul>
            </li>
        </ul>
    </font>
</section>