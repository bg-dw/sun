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
    <style>
    </style>
</head>

<body>
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
                <div class="col-md-12" style="margin-top: 15%;">
                    <center>
                        <h4>Dimohon untuk tidak <br> menggunakan mouse dan keyboard selama proses Absensi</h4>
                    </center>
                </div>
                <div class="col-md-12 mt-5">
                    <center>
                        <h1 id="sh_inp"></h1>
                    </center>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>/public/assets/js/jquery-3.7.0.js"></script>
    <!-- JS Libraies -->
    <script src="<?= base_url() ?>/public/assets/js/app.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="<?= base_url() ?>/public/assets/bundles/izitoast/js/iziToast.min.js"></script>
    <!-- tamplate JS File -->
    <script src="<?= base_url() ?>/public/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="<?= base_url() ?>/public/assets/js/custom.js"></script>
    <script>
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
                        if (data['kelas'] == 'I') {
                            reload_satu();
                        } else if (data['kelas'] == 'II') {
                            reload_dua();
                        } else if (data['kelas'] == 'III') {
                            reload_tiga();
                        } else if (data['kelas'] == 'IV') {
                            reload_empat();
                        } else if (data['kelas'] == 'V') {
                            reload_lima();
                        } else if (data['kelas'] == 'VI') {
                            reload_enam();
                        }
                    }
                }
            });
        }
        input.addEventListener("keypress", function (event) {
            // If the user presses the "Enter" key on the keyboard
            $('#sh_inp').text(input.value);
            if (event.key === "Enter") {
                // Cancel the default action, if needed
                event.preventDefault();
                tambah(input.value);
                input.value = '';
            }
        });
    </script>
</body>

</html>