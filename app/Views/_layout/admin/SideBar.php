<?php
$uri = current_url(true);
$segments = $uri->getSegments(); ?>
<aside id="sidebar-wrapper" class="d-print-none">
    <div class="sidebar-brand">
        <a href="<?= base_url('admin/home') ?>"> <img alt="image" src="<?= base_url() ?>/public/assets/img/logo.png"
                class="header-logo" />
            <span class="logo-name">PRESENSI</span>
        </a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown <?php if ($segments[0] === 'admin' && $segments[1] === 'home') {
            echo "active";
        } ?>">
            <a href="<?= base_url('admin/home') ?>" class="nav-link"><i
                    data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown <?php if ($segments[0] === 'admin' && ($segments[1] === 'presensi' || $segments[1] === 'rekap-presensi')) {
            echo "active";
        } ?>">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="list"></i><span>Presensi</span></a>
            <ul class="dropdown-menu">
                <li class="<?php if ($segments[0] === 'admin' && $segments[1] === 'presensi') {
                    echo "active";
                } ?>"><a class="nav-link" href="<?= base_url('admin/presensi') ?>">Hari ini</a></li>
                <li class="<?php if ($segments[0] === 'admin' && $segments[1] === 'rekap-presensi') {
                    echo "active";
                } ?>"><a class="nav-link" href="<?= base_url('admin/rekap-presensi') ?>">Rekap Presensi</a></li>
            </ul>
        </li>
        <li class="menu-header">Data Master</li>
        <li class="dropdown <?php if ($segments[0] === 'admin' && ($segments[1] === 'data-periode')) {
            echo "active";
        } ?>">
            <a href="<?= base_url('admin/data-periode') ?>" class="nav-link">
                <i data-feather="check-circle"></i><span>Data Periode</span>
            </a>
        </li>
        <li class="dropdown <?php if ($segments[0] === 'admin' && ($segments[1] === 'data-guru')) {
            echo "active";
        } ?>">
            <a href="<?= base_url('admin/data-guru') ?>" class="nav-link">
                <i data-feather="book"></i><span>Data Guru</span>
            </a>
        </li>
        <li class="dropdown <?php if ($segments[0] === 'admin' && ($segments[1] === 'data-siswa')) {
            echo "active";
        } ?>">
            <a href="<?= base_url('admin/data-siswa') ?>" class="nav-link">
                <i data-feather="users"></i><span> Data Peserta Didik</span>
            </a>
        </li>
        <li class="dropdown <?php if ($segments[0] === 'admin' && ($segments[1] === 'data-kelas')) {
            echo "active";
        } ?>">
            <a href="<?= base_url('admin/data-kelas') ?>" class="nav-link">
                <i data-feather="home"></i><span>Data Kelas</span>
            </a>
        </li>
        <li class="dropdown <?php if ($segments[0] === 'admin' && ($segments[1] === 'data-presensi')) {
            echo "active";
        } ?>">
            <a href="<?= base_url('admin/data-presensi') ?>" class="nav-link">
                <i data-feather="book-open"></i><span>Data Presensi</span>
            </a>
        </li>
    </ul>
</aside>