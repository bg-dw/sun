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
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section" style="overflow: hidden;">
            <div class="container">
                <div class="row flogin" style="margin-top: 50px;">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4"
                        id="card-gen">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Buka Kunci</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="hash">Data</label>
                                    <input id="hash" type="text" class="form-control" name="hash" tabindex="1"
                                        value="<?= $key ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-lg btn-block" tabindex="4"
                                        onclick="generate();" id="btn-gen">
                                        Generate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4"
                        id="card-unlock" style="display: none;">
                        <div class="card card-primary" id="bd-unlock">
                            <div class="card-header">
                                <h4>Buka Kunci</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group" id="inp_key">
                                    <label for="key">Key</label>
                                    <input id="key" type="text" class="form-control" tabindex="1" required>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-lg btn-block" tabindex="4"
                                        onclick="unlock();" id="btn-unlock">
                                        Unlock
                                    </button>
                                    <button type="button" class="btn btn-success btn-lg btn-block" tabindex="4"
                                        style="display: none;" id="btn-unlock-suc">
                                        APLIKASI TERBUKA
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <?= $this->include('_layout/alert') ?>

    <script>
        $("#btn-gen").click(function () {
            $("#card-gen").hide();
            $("#card-unlock").show();
            var left = $('#bd-unlock').offset().left;
            $("#bd-unlock").css({ left: left }).animate({ "left": "0px" }, "slow");
        });

        function generate() {
            var hash = $('#hash').val();
            $.ajax({
                url: "<?= base_url('/generate_code'); ?>",
                type: 'get',
                success: function (result) {
                    let data = JSON.parse(result);
                    console.log(data);
                },
                error: function (data) {
                    console.log(" Gagal");
                }
            });
        }

        function unlock() {
            var key = $('#key').val();
            $.ajax({
                url: "<?= base_url('/unlock'); ?>",
                type: 'post',
                data: { in_key: key },
                success: function (result) {
                    let data = JSON.parse(result);
                    if (data) {
                        $('#inp_key').hide();
                        $('#btn-unlock').hide();
                        $('#btn-unlock-suc').show();
                        window.setTimeout(function () {
                            // Move to a new location or you can do something else
                            window.location.href = "<?= base_url('/' . bin2hex('login')); ?>";
                        }, 3000);
                    }
                    console.log(data);
                },
                error: function (data) {
                    console.log(" Gagal");
                }
            });
        }
    </script>
</body>

</html>