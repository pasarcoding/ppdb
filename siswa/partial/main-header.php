<!-- Logo -->
<a href="?view=dashboard" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">PPDB</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>PPDB</b></span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= '../'.$dtSiswa['foto_siswa'] ?>" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?= strtoupper($dtSiswa['nmSiswa']) ?></span> <span class='caret'></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="<?= '../'.$dtSiswa['foto_siswa'] ?>" class="img-circle" alt="User Image">
                        <p>
                            <?=  strtoupper($dtSiswa['nmSiswa']) ?>
                            <small>Calon Siswa</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                            <button type="button" class="btn btn-default btn-flat btn-edit-password">Ubah Password</button>
                        </div>
                        <div class="pull-right">
                            <a href='index?view=logout' class='btn btn-default btn-flat'>Logout</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>