<?php
$uri = current_url(true);
$segments = $uri->getSegments(); ?>
<aside id="sidebar-wrapper" class="d-print-none">
    <div class="sidebar-brand">
        <a href="<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('home')) ?>"> <img alt="image"
                src="<?= base_url() ?>/public/assets/img/logo.png" class="header-logo" />
            <span class="logo-name">PRESENSI</span>
        </a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown <?php if ($segments[0] === bin2hex('guru') && $segments[1] === bin2hex('home')) {
            echo "active";
        } ?>">
            <a href="<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('home')) ?>" class="nav-link"><i
                    data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown <?php if ($segments[0] === bin2hex('guru') && $segments[1] === bin2hex('presensi')) {
            echo "active";
        } ?>">
            <a href="<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('presensi')) ?>" class="nav-link">
                <i data-feather="check-square"></i><span>Hari Ini</span>
            </a>
        </li>
        <li class="dropdown <?php if ($segments[0] === bin2hex('guru') && $segments[1] === bin2hex('rekap-presensi')) {
            echo "active";
        } ?>">
            <a href="<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('rekap-presensi')) ?>" class="nav-link">
                <i data-feather="book"></i><span>Rekap Presensi</span>
            </a>
        </li>
        <li class="menu-header">Data Master</li>
        <li class="dropdown <?php if ($segments[0] === bin2hex('guru') && ($segments[1] === bin2hex('data-siswa'))) {
            echo "active";
        } ?>">
            <a href="<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('data-siswa')) ?>" class="nav-link">
                <i data-feather="users"></i><span> Data Peserta Didik</span>
            </a>
        </li>
    </ul>
</aside>