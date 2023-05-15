<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row ">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Total Siswa</h5>
                                <h2 class="mb-3 font-18">258</h2>
                                <p class="mb-0"><span class="col-green">10%</span> Increase</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="<?= base_url() ?>/public/assets/img/banner/1.png" alt="">
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
                                <h5 class="font-15"> Total Siswi</h5>
                                <h2 class="mb-3 font-18">1,287</h2>
                                <p class="mb-0"><span class="col-orange">09%</span> Decrease</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="<?= base_url() ?>/public/assets/img/banner/2.png" alt="">
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
                                <h2 class="mb-3 font-18">128</h2>
                                <p class="mb-0"><span class="col-green">18%</span>
                                    Increase</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="<?= base_url() ?>/public/assets/img/banner/3.png" alt="">
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
                                <h2 class="mb-3 font-18">$48,697</h2>
                                <p class="mb-0"><span class="col-green">42%</span> Increase</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="<?= base_url() ?>/public/assets/img/banner/4.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
        <div class="card">
            <div class="card-header">
                <h4>Persentase Absensi</h4>
            </div>
            <div class="card-body">
                <div class="recent-report__chart">
                    <div id="chart2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
        <div class="card">
            <div class="card-header">
                <h4>Siswa Per-Kelas</h4>
            </div>
            <div class="card-body">
                <div class="recent-report__chart">
                    <div id="chart7"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>