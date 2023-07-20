<?= $this->extend('v_guru/Main') ?>
<?= $this->section('content') ?>
<?php
// dd($home);
?>
<style>
    .absen {
        height: 310px;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
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
                <h4>Absensi Hari Ini Kelas
                    <?= session()->get('kelas'); ?>
                </h4>
            </div>
            <div class="card-body">
                <div class="absen daftar-1 table-responsive">
                    <ul id="list" style="margin-left: -40px;">
                    </ul>
                </div>
            </div>
            <div class="card-footer"></div>
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
        tampil_siswa();
        setInterval(function () {
            cek_siswa();
        }, 1000);
    });
    var tamp_satu = [];
    var last_satu = 0;

    function cek_siswa() {
        $.ajax({
            url: "<?= base_url('/get_last'); ?>",
            type: 'post',
            data: { d_kelas: "<?= session()->get('kelas'); ?>" },
            success: function (result) {
                let data = JSON.parse(result);
                console.log(data['total']);
                if (last_satu != data['total']) {
                    last_satu = data['total']
                    reload_list();
                }
            }
        });
    }

    function tampil_siswa() {
        tamp_satu = [];
        $.ajax({
            url: "<?= base_url('/show'); ?>",
            type: 'post',
            data: { d_kelas: "<?= session()->get('kelas'); ?>" },
            success: function (result) {
                let data = JSON.parse(result);
                console.log(data);
                for (let x in data) {
                    tamp_satu.push([data[x]['jam_absensi'], data[x]['nama']]
                    );
                }
                buat_list();
            }
        });
    }

    function buat_list() {
        let i = 0;
        for (let x in tamp_satu) {
            // setInterval(function () {
            $("#list").append('<li><h5 style="margin-top:15px;"><span class="badge badge-secondary">' + tamp_satu[i][0].substring(0, 5) + '</span> ' + tamp_satu[i][1] + '</h5></li>');
            i++;
            // }, 1000);
        }
        // if (i > 4) {//lakukan scroll data jika data lebih dari 4
        //     loop_satu();
        // }
    }
    function reload_list() {
        $('#list').remove();
        $(".daftar-1").append('<ul id="list" style="margin-left: -40px;"></ul>');
        tampil_siswa();
    }

    function siswa_per_kelas() {
        var options;
        var kelas = [];
        var jumlah = [];
        $.ajax({
            url: "<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('get_siswa_kelas')); ?>",
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
</script>
<?= $this->endSection() ?>