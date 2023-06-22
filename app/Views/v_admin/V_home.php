<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<?php
// dd($home);
?>
<div class="row m-t--40">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Jumlah Siswa</h5>
                                <h2 class="mb-3 font-18">
                                    <?php if ($home) {
                                        echo $home["L"];
                                    } ?> Orang
                                </h2>
                                <p class="mb-0">
                                    <?php if (isset($home)) {
                                        echo number_format((($home["L"] / ($home["L"] + $home["P"])) * 100), 1);
                                    } ?>%
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="<?= base_url() ?>/public/assets/img/banner/siswa-kecil.png" alt="PRESENSI"
                                    style="height: 140px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15"> Jumlah Siswi</h5>
                                <h2 class="mb-3 font-18">
                                    <?php if ($home) {
                                        echo $home["P"];
                                    } ?> Orang
                                </h2>
                                <p class="mb-0">
                                    <span class="col-orange">
                                        <?php if (isset($home)) {
                                            echo number_format((($home["P"] / ($home["L"] + $home["P"])) * 100), 1);
                                        } ?>%
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="<?= base_url() ?>/public/assets/img/banner/siswi-kecil.png" alt=""
                                    style="height: 140px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Total Siswa-Siswi</h5>
                                <h2 class="mb-3 font-18">
                                    <?php if ($home) {
                                        echo $home["L"] + $home["P"];
                                    } ?> Orang
                                </h2>
                                <p class="mb-0">
                                    <span class="col-green">
                                        100%
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="<?= base_url() ?>/public/assets/img/banner/murid-kecil.png" alt=""
                                    style="height: 140px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Total Guru</h5>
                                <h2 class="mb-3 font-18">
                                    <?= $guru ?> Orang
                                </h2>
                                <p class="mb-0"><span class="col-green"></span></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="<?= base_url() ?>/public/assets/img/banner/guru-kecil.png" alt=""
                                    style="height: 140px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4>Persentase Absensi</h4>
            </div>
            <div class="card-body table-responsive">
                <div class="recent-report__chart">
                    <div id="chart2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4>Siswa Per-Kelas</h4>
            </div>
            <div class="card-body table-responsive">
                <div class="recent-report__chart">
                    <div id="chart7"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>