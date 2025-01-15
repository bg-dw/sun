<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4 id="card-title">Sinkron File</h4>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" onclick="get_update()" id="btn-cek-update">Sinkron</button>
                <div class="empty-state" style="display: none;" id="info-suc">
                    <div class="empty-state-icon bg-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2>File Ditemukan</h2>
                    <div class="alert alert-success" id="msg">
                    </div>
                    <p class="lead mt-4" id="text-apply">
                    </p>
                </div>
                <div class="empty-state" style="display: none;" id="execute">
                    <div id="timer-box" style="display: none;">
                        <h4><span id="timer" class="badge badge-secondary"></span></h4>
                    </div>
                    <div id="load-data" style="display: none;">
                        <div class="loader-inframe" id="loader-icon"></div>
                        <h4 id="loader-text"></h4>
                    </div>
                </div>
                <div class="empty-state" style="display: none;" id="info-err">
                    <div class="empty-state-icon bg-danger">
                        <i class="fas fa-times"></i>
                    </div>
                    <h2 id="err-text">Gagal mendapatkan pembaruan</h2>
                    <p class="lead">
                        Coba lagi?
                    </p>
                    <button class="btn btn-primary mt-4" onclick="get_update()">Ya</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete-modal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('delete-libur')) ?>"
                        method="post">
                        <div class="modal-body">
                            <input type="hidden" name="id" class="form-control" required id="d-id">
                            <center>
                                <h3 id="d-tgl"></h3>
                                <h3 id="d-ket"></h3>
                            </center>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="submit" class="btn btn-primary">Ya</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let temp_data = [];

    let startTime = Date.now();
    let interval;
    function start() {
        interval = setInterval(function () {
            var elapsedTime = Date.now() - startTime;
            document.getElementById("timer").innerHTML = (elapsedTime / 1000).toFixed(1) + " s";
        }, 100);
    }
    function get_update() {
        start();
        $(".loader").show();
        $("#execute").show();
        $("#btn-cek-update").hide();
        $("#timer-box").show();
        $("#info-err").hide();
        if (!window.navigator.onLine) {
            $("#info-err").show();
            $("#err-text").html("Anda sedang offline, periksa kembali internet anda!");
        }

        $.ajax({
            url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('cek-file')); ?>",
            type: 'get',
            success: function (result) {
                $(".loader").hide();
                var data = JSON.parse(result);
                if (!data) {
                    console.log(result);
                } else {
                    const detail = data.msg.replace(/(\r\n|\r|\n)/g, '<br>');
                    $('#msg').html(detail);
                    $("#info-suc").show();
                    temp_data.push(data.ver);
                    temp_data.push(data.raw);
                    temp_data.push(data.msg);
                    download_file();
                    notif("Berhasil mendapatkan data server!", "suc");
                    $("#info-err").hide();
                }
            },
            error: function (result) {
                $(".loader").hide();
                $("#info-err").show();
                notif("Gagal mendapatkan data server!", "err");
                console.log(result);
            }
        });
    }
    function stop() {
        clearInterval(interval);
    }

    function download_file() {
        $("#text-apply").hide();
        $("#info-suc").hide();
        $("#loader-text").html("Mengunduh Sumber File");
        $("#load-data").show();
        $("#loader-icon").show();
        apply_update();
    }
    function apply_update() {
        $.ajax({
            url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('perbaharui')); ?>",
            type: 'POST',
            data: {
                ver: temp_data[0],
                url: temp_data[1],
                msg: temp_data[2]
            },
            success: function (result) {
                var data = JSON.parse(result);
                if (!data) {
                    console.log(result);
                    $("#loader-text").html("GALAT!");
                } else {
                    $("#loader-text").html(data);
                    $("#loader-icon").hide();
                    $("#btn-apply").hide();
                    stop();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error: ", textStatus, errorThrown);
                $("#loader-text").html("Gagal menerapkan pembaruan!");
            }
        });
    }
</script>
<?= $this->endSection() ?>