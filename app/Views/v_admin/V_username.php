//.app/Views/v_admin/=V_username
<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="card-title">Update Username</h4>
            </div>
            <div class="card-body" id="f-username">
                <form action="<?= base_url('/' . bin2hex('admin/update/username')) ?>" method="post"
                    onsubmit="return confirm('Simpan data?')">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Username Lama</label>
                            <input type="text" minlength="5" class="form-control" placeholder="Username Anda Saat ini"
                                onkeyup="cek_uname_lama()" id="ak-uname-lama" required>
                            <div class="" id="color-info-lama">
                                <span id="text-info-lama"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Username Baru</label>
                            <input type="text" name="uname" minlength="5" class="form-control"
                                placeholder="Minimal 5 Karakter" onkeyup="cek_uname()" id="ak-uname" required>
                            <div class="" id="color-info">
                                <span id="text-info"></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit" id="btn-simpan-username"
                            style="display: none;">Simpan</button>
                        <button class="btn btn-secondary" type="button"
                            onclick="location.href='<?= $_SERVER['HTTP_REFERER']; ?>'"
                            id="btn-cancel-username">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function cek_uname_lama() {
        var usern = $('#ak-uname-lama').val();
        if (usern.length > 4) {
            $.ajax({
                url: "<?= base_url('/' . bin2hex('admin/cek-username-lama')); ?>",
                type: 'post',
                data: { uname: usern },
                success: function (result) {
                    let data = JSON.parse(result);
                    if (data === null) {
                        $('#ak-uname-lama').attr("class", "form-control is-invalid");
                        $('#color-info-lama').attr("class", "invalid-feedback");
                        $('#text-info-lama').text("Username Tidak Sesuai!");
                    } else {
                        $('#ak-uname-lama').attr("class", "form-control is-valid");
                        $('#color-info-lama').attr("class", "valid-feedback");
                        $('#text-info-lama').text("Username Sesuai!");
                    }
                },
                error: function (data) {
                    $('#btn-simpan-username').hide();
                    $('#ak-uname-lama').attr("class", "form-control is-invalid");
                    $('#color-info-lama').attr("class", "invalid-feedback");
                    $('#text-info-lama').text("Gagal Cek Username!");
                }
            });
        }
    }
    function cek_uname() {
        var usern = $('#ak-uname').val();
        if (usern.length > 4) {
            $.ajax({
                url: "<?= base_url('/' . bin2hex('admin/guru/cek-username')); ?>",
                type: 'post',
                data: { uname: usern },
                success: function (result) {
                    let data = JSON.parse(result);
                    if (data === null) {
                        $('#ak-uname').attr("class", "form-control is-valid");
                        $('#color-info').attr("class", "valid-feedback");
                        $('#text-info').text("Bisa digunakan!");
                        $('#btn-simpan-username').show();
                    } else {
                        $('#btn-simpan-username').hide();
                        $('#ak-uname').attr("class", "form-control is-invalid");
                        $('#color-info').attr("class", "invalid-feedback");
                        $('#text-info').text("Cari Username Lain!");
                    }
                },
                error: function (data) {
                    $('#btn-simpan-username').hide();
                    $('#ak-uname').attr("class", "form-control is-invalid");
                    $('#color-info').attr("class", "invalid-feedback");
                    $('#text-info').text("Gagal Cek Username!");
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>