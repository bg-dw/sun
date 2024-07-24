//.app/Views/v_guru/=V_password
<?= $this->extend('v_guru/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="card-title">Update Password</h4>
            </div>
            <div class="card-body" id="f-password">
                <form action="<?= base_url('/' . bin2hex('guru/update/password')) ?>" method="post"
                    onsubmit="return confirm('Simpan data?')">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password Lama</label>
                            <input type="password" minlength="3" class="form-control"
                                placeholder="Password Anda Saat ini" onkeyup="cek_pwd_lama()" id="inp-pass-lama"
                                required>
                            <div class="" id="color-info-lama">
                                <span id="text-info-lama"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Password Baru</label>
                            <input type="text" name="pass" minlength="6" class="form-control"
                                placeholder="Minimal 6 Karakter" id="inp-pass" required>
                            <div class="" id="color-info">
                                <span id="text-info"></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit" id="btn-simpan-password"
                            style="display: none;">Simpan</button>
                        <button class="btn btn-secondary" type="button"
                            onclick="location.href='<?= $_SERVER['HTTP_REFERER']; ?>'">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function cek_pwd_lama() {
        var pw = $('#inp-pass-lama').val();
        if (pw.length > 3) {
            $.ajax({
                url: "<?= base_url('/' . bin2hex('guru/cek-password-lama')); ?>",
                type: 'post',
                data: { pass: pw },
                success: function (result) {
                    let data = JSON.parse(result);
                    if (data === null) {
                        $('#inp-pass-lama').attr("class", "form-control is-invalid");
                        $('#color-info-lama').attr("class", "invalid-feedback");
                        $('#text-info-lama').text("Password Tidak Sesuai!");
                        $('#btn-simpan-password').hide();
                    } else {
                        $('#inp-pass-lama').attr("class", "form-control is-valid");
                        $('#color-info-lama').attr("class", "valid-feedback");
                        $('#text-info-lama').text("Password Sesuai!");
                        $('#btn-simpan-password').show();
                    }
                },
                error: function (data) {
                    $('#btn-simpan-password').hide();
                    $('#inp-pass-lama').attr("class", "form-control is-invalid");
                    $('#color-info-lama').attr("class", "invalid-feedback");
                    $('#text-info-lama').text("Gagal Cek Password!");
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>