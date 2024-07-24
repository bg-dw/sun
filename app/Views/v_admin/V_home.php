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
                                    <?php if (isset($home) && ($home["L"] != null || $home["P"] != null)) {
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
                                        <?php if (isset($home) && ($home["L"] != null || $home["P"] != null)) {
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
                                <h5 class="font-15">Total Pendidik</h5>
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
                <h4>Absensi Hari Ini ( Per-Kelas )</h4>
            </div>
            <div class="card-body table-responsive">
                <div class="recent-report__chart">
                    <div id="chart1"></div>
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
                    <div id="siswa-kelas"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        siswa_per_kelas();
        absensi();
    });

    function siswa_per_kelas() {
        var options;
        var kelas = [];
        var jumlah = [];
        $.ajax({
            url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('get_siswa_kelas')); ?>",
            type: 'get',
            success: function (result) {
                let data = JSON.parse(result);
                for (let i = 0; i < data.length; i++) {
                    kelas.push("Kelas " + data[i]['kelas']);
                    jumlah.push(parseInt(data[i]['tot']));
                }
                options = {
                    chart: {
                        width: 360,
                        type: 'pie',
                    },
                    labels: kelas,
                    series: jumlah,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                }

                var chart = new ApexCharts(
                    document.querySelector("#siswa-kelas"),
                    options
                );

                chart.render();
            }
        });
    }
    function absensi() {
        var options;
        var kelas = [];
        var jumlah = [];
        $.ajax({
            url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('get_absen_today')); ?>",
            type: 'get',
            success: function (result) {
                let data = JSON.parse(result);
                // console.log(data);
                for (let i = 0; i < data.length; i++) {
                    kelas.push("Kelas " + data[i]['kelas']);
                    jumlah.push(parseInt(data[i]['tot']));
                }
                // console.log(kelas);
            }
        });
        var options = {
            chart: {
                height: 350,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    endingShape: 'rounded',
                    columnWidth: '80%',
                },
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Sudah Absen',
                data: jumlah
            }],
            xaxis: {
                categories: kelas,
                labels: {
                    style: {
                        colors: '#9aa0ac',
                    }
                }
            },
            yaxis: {
                title: {
                    text: '( Jumlah Siswa - Siswi )'
                },
                labels: {
                    style: {
                        color: '#9aa0ac',
                    }
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Org"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#chart1"),
            options
        ); setTimeout(function () {
            chart.render();
        }, 500);
    }
</script>
<?= $this->endSection() ?>