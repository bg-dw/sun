<?php
$uri = current_url(true);
$segments = $uri->getSegments(); ?>
<aside id="sidebar-wrapper">
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
        <li class="dropdown">
            <a href="<?= base_url('admin/siswa') ?>" class="nav-link"><i data-feather="database"></i><span>Peserta
                    Didik</span></a>
        </li>
        <li class="dropdown">
            <a href="<?= base_url('admin/guru') ?>" class="nav-link"><i data-feather="database"></i><span>Data
                    Guru</span></a>
        </li>
    </ul>
</aside>