<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4 id="card-title">Pembaruan Website</h4>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" onclick="get_update()" id="btn-cek-update">Cek
                    Pembaruan</button>
                <div class="empty-state" style="display: none;" id="info-suc">
                    <div class="empty-state-icon bg-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2>Pembaruan ditemukan</h2>
                    <div class="alert alert-success" id="msg">
                    </div>
                    <p class="lead mt-4" id="text-apply">
                        Apakah anda ingin menerapkan pembaruan?
                    </p>
                    <div id="load-data" style="display: none;">
                        <div class="loader-inframe" id="loader-icon"></div>
                        <h4 id="loader-text"></h4>
                    </div>
                    <button class="btn btn-primary mt-2" id="btn-apply" onclick="download_update()">Terapkan
                        Pembaruan</button>
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
    let gagal = 0;
    let berhasil = 0;
    function get_update() {
        $(".loader").show();
        $("#btn-cek-update").hide();
        $("#info-err").hide();
        if (!window.navigator.onLine) {
            $("#info-err").show();
            $("#err-text").html("Anda sedang offline, periksa kembali internet anda!");
        }
        $.ajax({
            url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('cek-pembaruan')); ?>",
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

                    for (var index = 0; index < data.files.url.length; index++) {
                        temp_data.push([data.files.filepath[index], data.files.url[index], data.files.filename[index], data.files.status[index]]);
                    }
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

    function download_update() {
        $("#text-apply").hide();
        $("#loader-text").html("Mengunduh Pembaruan");
        $("#load-data").show();
        for (var i = 0; i < temp_url.length; i++) {
            $("#loader-icon").show();
            apply_update(temp_data[i][0], temp_data[i][1], temp_data[i][2], temp_data[i][3],);
        }
    }
    function apply_update(filepath, file_url, file_name, status) {
        $.ajax({
            url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('terapkan-pembaruan')); ?>",
            type: 'POST',
            data: {
                path: filepath,
                url: file_url,
                name: file_name, // Nama file saat disimpan
                status: status // Status file, sesuaikan dengan kebutuhan 
            },
            success: function (result) {
                var data = JSON.parse(result);
                if (!data) {
                    console.log(result);
                    $("#loader-text").html("GALAT!");
                } else {
                    if (data == false) { gagal++; } else { berhasil++; }

                    $("#loader-text").html(data);
                    $("#loader-text").html("Gagal diperbaharui : " + gagal + ", Berhasil diterapkan : " + berhasil);
                    $("#loader-icon").hide();
                    $("#btn-apply").hide();
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