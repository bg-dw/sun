<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>PRESENSI</title>
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/app.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/components.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/shadow__btn.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/public/assets/img/favicon.ico">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/bundles/izitoast/css/iziToast.min.css">
    <script src="<?= base_url() ?>/public/assets/js/jquery-3.7.0.js"></script>
    <style>
        body {
            /* overflow-x: hidden;
            overflow-y: hidden; */
        }

        .card {
            /* From https://css.glass */
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(6.6px);
            -webkit-backdrop-filter: blur(6.6px);
        }
    </style>
</head>

<body class="light theme-light">
    <div id="app">
        <section class="section" style="overflow: hidden;">
            <div class="row list m-2">
                <div class="col-md-4">
                    <input type="number" name="rfid" class="form-control" id="nomor" name="id"
                        style="margin-top:-500px;" />
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row">
                <div class="card card-primary mx-auto">
                    <div class="card-body">
                        <div class="col-md-12" style="margin-top: 2%;">
                            <center>
                                <h4>Dimohon untuk tidak <br> menggunakan mouse dan keyboard selama proses Absensi</h4>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-2 mt-3">
                <div class="col-md-12">
                    <center>
                        <h1 id="sh_inp"></h1>
                    </center>
                </div>
                <div class="col-md-7">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="text-right"><input id="tot_text" type="number" value="<?= $total_siswa; ?>"
                                    readonly style="display: none;">
                            </div>
                            <div class="text-center">
                                <h2 class="progress-text">0%</h2>
                                <div class="progress" data-height="15">
                                    <div id="status" class="progress-bar bg-success" data-width="0%"></div>
                                </div>
                                <table width="100%" class="table table-striped">
                                    <tbody id="parent"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="author-box-center">
                        <center>
                            <img alt="image" id="pic" src="<?= base_url() ?>/public/assets/img/default.png" class=""
                                width="300vw" height="300vh">
                        </center>
                    </div>
                    <div class="card card-primary author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <h2 id="nama" class="">Nama</h2>
                                </div>
                                <div class="author-box-job">
                                    <h4 id="kelas">Kelas</h4>
                                </div>
                            </div>
                            <div class="text-center">
                                <h3 id="jam">Jam absen</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- JS Libraies -->
    <script src="<?= base_url() ?>/public/assets/js/app.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="<?= base_url() ?>/public/assets/bundles/apexcharts/apexcharts.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/bundles/izitoast/js/iziToast.min.js"></script>
    <!-- tamplate JS File -->
    <script src="<?= base_url() ?>/public/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="<?= base_url() ?>/public/assets/js/custom.js"></script>
    <script>
        var a = x = 0;
        var total = 0;

        $(function () {
            input.focus();
        });

        var input = document.getElementById("nomor");
        function tambah(rfid) {
            $.ajax({
                url: "<?= base_url('/inp'); ?>",
                type: 'post',
                data: { in_rfid: rfid },
                success: function (result) {
                    let data = JSON.parse(result);
                    if (data['status'] == 'success') {
                        $('#sh_inp').css({ 'color': 'green' });
                        $('#sh_inp').text("Berhasil");
                        add_list(data['nama'], data['kelas'], data['jam'], data['pic'], data['total']);
                    } else {
                        $('#sh_inp').css({ 'color': 'red' });
                        $('#sh_inp').text(data['isi']);
                    }
                },
                error: function (data) {
                    console.log("[" + rfid + "] Gagal");
                }
            });
        }
        input.addEventListener("keypress", function (event) {
            $('#sh_inp').text(input.value);
            if (event.key === "Enter") {
                // Cancel the default action, if needed
                event.preventDefault();
                tambah(input.value);
                input.value = '';
            }
        });

        x = $('#tot_text').val();
        function add_list(nama, kelas, jam, pic, total) {
            if (!total) {
                total = 0;
            }
            $('#nama').text(nama);
            $('#kelas').text(kelas);
            $('#jam').text(jam);
            if (pic) {
                $('#pic').attr("src", "<?= base_url() ?>/public/assets/img/siswa/" + pic);
            } else {
                $('#pic').attr("src", "<?= base_url() ?>/public/assets/img/default.png");
            }
            $('#parent').prepend('<tr><td><h2>' + nama + '</h2></td><td><b>' + jam + '</b></td> </tr>');
            $('.progress-text').text(((total / x) * 100).toFixed(2) + "%");
            $('#status').css('width', ((total / x) * 100).toFixed(2) + "%");

            var z = $("#parent").children().length;
            if (z > 5) {
                $("#parent").children("tr:last").remove();
                $('.progress-text').text(((total / x) * 100).toFixed(2) + "%");
                $('#status').css('width', ((total / x) * 100).toFixed(2) + "%");
            }
        }


    </script>
</body>

</html>