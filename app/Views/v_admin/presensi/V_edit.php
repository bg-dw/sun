<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<?php
function isSunday($date)
{
    return (date('N', strtotime($date)) > 6);
}
?>
<div class="row justify-content-center">.
    <div class="col-md-12">
        <div class="card d-print-none card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-9" id="c-tanggal">
                                <?= csrf_field(); ?>
                                <form
                                    action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('update-presensi') . '/' . bin2hex('multiple')) ?>"
                                    method="post" id="f-by-tgl">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="pil-by-date">Tanggal</label>
                                            <input id="pil-by-date" name="inp-tgl" type="text"
                                                class="form-control daterange-weeks">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="pil-by">Presensi</label>
                                            <select id="pil-by" class="form-control" name="inp-presensi"
                                                onchange="pil_by(this)" required>
                                                <option value="-">=== Memilih ===</option>
                                                <option value="0">
                                                    Tambah
                                                </option>
                                                <option value="1">
                                                    Hadir
                                                </option>
                                                <option value="2">
                                                    Hapus
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-inline">
                                            <button type="button" class="btn btn-primary" onclick="conf_modal()"
                                                id="btn-submit-tgl" style="display:none;">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="alert alert-info alert-has-icon col-md-12">
                                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Info</div>
                                    <b> Pada input tanggal, hanya dapat memilih maksimal 7 hari aktif.</b>
                                    <ul>
                                        <li>Tambah : Akan menambahkan data presensi baru, tanpa menimpa data yang telah
                                            ada.</li>
                                        <li>Hadir : Hanya akan merubah data kehadiran (tidak menambahkan data
                                            baru).</li>
                                        <li>Hapus : Akan menghapus data secara permanen dari database (tidak
                                            dapat dikembalikan).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (session()->has('data')):
    $data = session()->getFlashdata('data'); ?>
    <div class="row justify-content-center">.
        <div class="col-md-12">
            <div class="card d-print-none l-bg-cyan">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Info</div>
                                    <?php for ($i = 0; $i < count($data); $i++): ?>
                                        <b> <?php echo $data[$i][0]; ?></b>
                                        <ul>
                                            <?php if ($data[$i][1] != 0): ?>
                                                <li>Sukses : <?php echo $data[$i][1] . " Data"; ?></li><?php endif; ?>
                                            <?php if ($data[$i][2] != 0): ?>
                                                <li>Gagal :<?php echo $data[$i][2] . " Data"; ?></li><?php endif; ?>
                                        </ul>
                                        <br>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Modal update presensi by tanggal -->
<div class="modal fade" id="m-uby-tgl-t" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambahkan Data Presensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" required id="inp-u-status">
                Tindakan ini akan
                <b><u>MENAMBAHKAN</u></b> data presensi pada tanggal yang telah anda pilih, tanpa merubah data yang
                telah ada sebelumnya.
                Tambahkan data?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" onclick="submit_form()">Tambahkan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="m-uby-tgl-h" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Perbaharui Data Presensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" required id="inp-u-status">
                Tindakan ini akan
                <b><u>MEMPERBAHARUI</u></b> data presensi pada tanggal yang telah anda pilih.
                Simpan data?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" onclick="submit_form()">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="m-uby-tgl-d" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Presensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" required id="inp-u-status">
                Tindakan ini akan
                <b><u>MENGHAPUS</u></b> data presensi dari Basis Data pada taggal yang telah anda pilih.
                Hapus data?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-danger" onclick="submit_form()">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<script>
    function pil_by(e) {
        $("#btn-submit-tgl").show('slow');
        if (e.value == 0) {
            $("#btn-submit-tgl").attr('class', 'btn btn-primary');
            $("#btn-submit-tgl").html('Tambahkan');
        } else if (e.value == 1) {
            $("#btn-submit-tgl").attr('class', 'btn btn-primary');
            $("#btn-submit-tgl").html('Simpan');
        } else if (e.value == 2) {
            $("#btn-submit-tgl").attr('class', 'btn btn-danger');
            $("#btn-submit-tgl").html('Hapus');
        } else if (e.value == "-") {
            $("#btn-submit-tgl").hide('slow');
        }
        // console.log(e.value);
    }

    function conf_modal() {
        var rad = $("#pil-by").val();
        if (rad == 0) {
            $('#m-uby-tgl-t').appendTo('body').modal('show');
            $('#m-uby-tgl-t').modal('show');
        } else if (rad == 1) {
            $('#m-uby-tgl-h').appendTo('body').modal('show');
            $('#m-uby-tgl-h').modal('show');
        } else if (rad == 2) {
            $('#m-uby-tgl-d').appendTo('body').modal('show');
            $('#m-uby-tgl-d').modal('show');
        }
    }

    function submit_form() {
        document.getElementById("f-by-tgl").submit();
    }
</script>
<?= $this->endSection() ?>