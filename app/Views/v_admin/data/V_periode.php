<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="card-title">Data Periode</h4>
                <div class="card-header-action" role="group" aria-label="Basic example" id="group-btn">
                    <button type="button" class="btn btn-primary" id="btn-add">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
            <div class="card-body" id="tbl-data">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    No.
                                </th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">Tahun Awal</th>
                                <th class="text-center">Tahun Akhir</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($periode) && count($periode) > 0):
                                foreach ($periode as $row):
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 4%">
                                            <?= $i++ . "."; ?>
                                        </td>
                                        <td class="text-center" style="width: 11%">
                                            <?php if ($row['status_periode'] === "non-aktif"): ?>
                                                <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Periode"
                                                    onclick="update_periode('<?= $row['id_periode'] ?>','<?= $row['tahun_awal'] ?>','<?= $row['tahun_akhir'] ?>','<?= $row['status_periode'] ?>')">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $row['tahun_awal'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $row['tahun_akhir'] ?>
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <button
                                                class="btn btn-sm btn-<?= ($row['status_periode'] == 'aktif') ? 'success' : 'secondary'; ?>"
                                                <?php if ($row['status_periode'] == 'non-aktif'): ?>onclick="set_act('<?= $row['id_periode'] ?>')" data-toggle="tooltip"
                                                    title="Klik untuk Edit" <?php endif; ?>>
                                                <?= strtoupper($row['status_periode']); ?>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body" id="f-add" style="display:none;">
                <?= csrf_field(); ?>
                <form
                    action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('data-periode') . '/' . bin2hex('add')) ?>"
                    method="post" onsubmit="return cek_isi()">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Tahun Awal</label>
                            <input type="number" class="form-control" name="tahun" value="<?= date('Y') ?>"
                                placeholder="Ex:<?= date('Y') ?>" id="t1" onchange="set_tahun()" required
                                min="<?= date('Y') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Tahun Akhir</label>
                            <input type="number" class="form-control" value="<?= date('Y') + 1 ?>"
                                placeholder="Ex:<?= date('Y') + 1 ?>" id="t2" disabled>
                            <label class="text-danger" style="display: none;" id="label-warning">Tahun akhir tidak boleh
                                lebih kecil dari
                                Tahun Awal!</label>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" id="btn-cancel">Batal</button>
                    </div>
                </form>
            </div>
            <div class="card-body" id="f-update" style="display:none;">
                <?= csrf_field(); ?>
                <form
                    action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('data-periode') . '/' . bin2hex('update')) ?>"
                    method="post" onsubmit="return cek_update()">
                    <div class="form-row">
                        <input type="hidden" name="id" required id="u-id">
                        <div class="form-group col-md-6">
                            <label for="u-t1">Tahun Awal</label>
                            <input type="number" class="form-control" name="tahun" value=""
                                placeholder="Ex:<?= date('Y') ?>" id="u-t1" onchange="set_tahun2()" required
                                min="<?= date('Y') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="u-t2">Tahun Akhir</label>
                            <input type="number" class="form-control" value="" placeholder="Ex:<?= date('Y') + 1 ?>"
                                id="u-t2" disabled>
                            <label class="text-danger" style="display: none;" id="u-label-warning">Tahun akhir tidak
                                boleh
                                lebih kecil dari
                                Tahun Awal!</label>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" onclick="batal()">Batal</button>
                    </div>
                </form>
            </div>
            <!-- Modal update Status periode -->
            <div class="modal fade" id="m-act" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Perbaharui Status Periode</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form
                            action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('data-periode') . '/' . bin2hex('set-status')) ?>"
                            method="post">
                            <div class="modal-body">
                                <input type="hidden" name="id" required id="inp-u-status">
                                Perubahan status periode, Harus dilakukan ketika tahun ajaran sebelumnya telah berakhir.
                                "Aktifkan"
                                periode terpilih?
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="submit" class="btn btn-primary">Aktifkan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btn-add').click(function () {
        $('#tbl-data').hide('slow');
        $('#btn-add').hide('slow');
        $('#f-add').show('slow');
    });

    $('#btn-cancel').click(function () {
        $('#f-add').hide('slow');
        $('#btn-add').show('slow');
        $('#tbl-data').show('slow');
    });

    function set_act(id) {
        $('#inp-u-status').val(id);
        $('#m-act').appendTo("body").modal('show');
    }

    //update periode
    function update_periode(id, awal, akhir) {
        $('#u-id').val(id);
        $('#u-t1').val(awal);
        $('#u-t2').val(akhir);
        $('#tbl-data').hide('slow');
        $('#btn-add').hide('slow');
        $('#f-update').show('slow');
    }

    function batal() {
        $('#f-update').hide('slow');
        $('#btn-add').show('slow');
        $('#tbl-data').show('slow');
    }

    function set_tahun() {
        let t1 = $('#t1').val();
        let t2 = $('#t2').val();
        if (t1 != "") {
            $('#t2').val(parseInt(t1) + 1);
        }
    }

    function cek_isi() {
        let t1 = $('#t1').val();
        let t2 = $('#t2').val();
        if (t1 < t2) {
            return true;
        } else {
            $('#label-warning').show();
            return false
        }
    }

    function set_tahun2() {
        let t1 = $('#u-t1').val();
        let t2 = $('#u-t2').val();
        if (t1 != "") {
            $('#u-t2').val(parseInt(t1) + 1);
        }
    }

    function cek_update() {
        let t1 = $('#u-t1').val();
        let t2 = $('#u-t2').val();
        if (t1 < t2) {
            let x = confirm("Perbaharui Tahun Periode?");
            if (x == true) { return true; } else { return false; }
        } else {
            $('#label-warning').show();
            return false
        }
    }
</script>
<?= $this->endSection() ?>