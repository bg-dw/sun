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
                    <h2>Gagal mendapatkan pembaruan</h2>
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
    // function disableF5(e) {
    //     if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
    // }
    let temp_url = "";
    let temp_path = "";
    let temp_filename = "";
    function get_update() {
        $(".loader").show();
        $("#btn-cek-update").hide();
        $("#info-err").hide();
        $.ajax({
            url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('cek-pembaruan')); ?>",
            type: 'get',
            success: function (result) {
                $(".loader").hide();
                let data = JSON.parse(result);
                if (!data) {
                    console.log(result);
                } else {
                    const detail = data.msg.replace(/(\r\n|\r|\n)/g, '<br>');
                    console.log(data.files.url.length);
                    console.log(data.files.filename[0]);
                    $('#msg').html(detail);
                    console.log(data);
                    $("#info-suc").show();
                    temp_url = data.files.url;
                    temp_path = data.files.filepath;
                    temp_filename = data.files.filename;
                    // download_update(data.files.url, data.files.filepath, data.files.filename);
                    notif("Berhasil mendapatkan data server!", "suc");
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

    function download_update(url, path, filename) {
        // console.log(temp_url);
        $("#text-apply").hide();
        $("#loader-text").html("Mengunduh Pembaruan");
        $("#load-data").show();
        for (let index = 0; index < url; index++) {
            $("#loader-text").html(apply(path[index], url[index], filename[index]));
        }
    }
    function apply(path, url, file_name) {
        $.ajax({
            url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('terapkan-pembaruan')); ?>",
            type: 'post',
            data: { path: path, url: url, name: file_name },
            success: function (result) {
                let data = JSON.parse(result);
                if (!data) {
                    console.log(result);
                    return "GALAT!";
                } else {
                    console.log(data);
                    return data;
                }
            },
            error: function (result) {
                return "Gagal menerapkan pembaruan!";
                console.log(result);
            }
        });
    }

    // function apply_update(file) {
    //     $("#loader-text").html("Menerapkan Pembaruan");
    //     $.ajax({
    //         url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('terapkan-pembaruan')); ?>",
    //         type: 'post',
    //         data: { path: file },
    //         success: function (result) {
    //             let data = JSON.parse(result);
    //             if (!data) {
    //                 console.log("1");
    //                 console.log(result);
    //             } else {
    //                 console.log("2");
    //                 console.log(data);
    //                 $("#loader-icon").hide();
    //                 $("#btn-apply").hide();
    //                 $("#loader-text").html("Pembaruan berhasil!");
    //             }
    //         },
    //         error: function (result) {
    //             notif("Gagal unduh pembaruan!", "err");
    //             console.log(result);
    //         }
    //     });
    // }
</script>
<?= $this->endSection() ?>