<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="card-title">Data Kelas</h4>
                <div class="card-header-action" role="group" aria-label="Basic example" id="group-btn">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-modal"
                        id="btn-import">
                        <i class="fas fa-file-import"></i> Import
                    </button>
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
                                <th class="text-center">Periode</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Guru Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($kelas) && count($kelas) > 0) {
                                foreach ($kelas as $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 7%">
                                            <?= $i++; ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <button class="btn btn-warning" data-toggle="tooltip" title="Edit Kelas"
                                                onclick="update('<?= $row['id_kelas'] ?>','<?= $row['id_periode'] ?>','<?= $row['id_guru'] ?>','<?= $row['kelas'] ?>')">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger" data-toggle="tooltip" title="Hapus Kelas"
                                                onclick="hapus('<?= $row['id_kelas'] ?>','<?= $row['nama_guru'] ?>','<?= $row['kelas'] ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <?= $row['tahun_awal'] . " - " . $row['tahun_akhir'] ?>
                                        </td>
                                        <td class="text-center" style="width: 5%">
                                            <?= $row['kelas'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nama_guru'] ?>
                                            <?= empty($row['gelar_guru']) ? "" : ", " . $row['gelar_guru']; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body" id="f-add" style="display:none;">
                <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('kelas') . '/' . bin2hex('add')) ?>"
                    method="post" onsubmit="return confirm('Simpan data?')">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Periode</label>
                            <select name="periode" class="form-control" required>
                                <?php foreach ($periode as $row): ?>
                                    <option value="<?= $row['id_periode'] ?>"><?= $row['tahun_awal'] . " - " . $row['tahun_akhir'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Guru Kelas</label>
                            <select name="guru" class="form-control select2" style="width:100%;" required>
                                <?php foreach ($guru as $bar): ?>
                                    <option value="<?= $bar['id_guru'] ?>"><?= $bar['nama_guru'] ?><?= empty($bar['gelar_guru']) ? "" : ", " . $bar['gelar_guru']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Nama Kelas</label>
                            <input type="text" name="kelas" class="form-control" placeholder="Ex: VI" required>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" id="btn-cancel">Batal</button>
                    </div>
                </form>
            </div>
            <div class="card-body" id="f-update" style="display:none;">
                <form
                    action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('kelas') . '/' . bin2hex('update')) ?>"
                    method="post" onsubmit="return confirm('Simpan data?')">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <input type="hidden" name="id" id="u-id">
                        <div class="form-group col-md-4">
                            <label>Periode</label>
                            <select name="periode" class="form-control" required id="u-opt-periode">
                                <?php foreach ($periode as $row): ?>
                                    <option value="<?= $row['id_periode'] ?>"><?= $row['tahun_awal'] . " - " . $row['tahun_akhir'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Guru Kelas</label>
                            <select name="guru" class="form-control select2" style="width:100%;" required
                                id="u-opt-guru">
                                <?php foreach ($guru as $bar): ?>
                                    <option value="<?= $bar['id_guru'] ?>"><?= $bar['nama_guru'] ?><?= empty($bar['gelar_guru']) ? "" : ", " . $bar['gelar_guru']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Nama Kelas</label>
                            <input type="text" name="kelas" class="form-control" placeholder="Ex: VI" required
                                id="u-kelas">
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" onclick="batal()">Batal</button>
                    </div>
                </form>
            </div>
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
            <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('kelas') . '/' . bin2hex('delete')) ?>"
                method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" class="form-control" required id="d-id">
                    <center>
                        <h3 id="d-kelas"></h3>
                        <h3 id="d-nama"></h3>
                        <label class="text-danger">Seluruh data yang berkaitan dengan Kelas diatas akan terhapus. Hapus
                            data?</label>
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
<script>
    $('#btn-import').click(function () {
        $('#add-modal').appendTo('body').modal('show');
    });
    $('#btn-add').click(function () {
        $('#tbl-data').hide('slow');
        $('#group-btn').hide('slow');
        $('#f-add').show('slow');
        $('#card-title').text('Tambah Kelas');
    });
    $('#btn-cancel').click(function () {
        $('#f-add').hide('slow');
        $('#group-btn').show('slow');
        $('#tbl-data').show('slow');
        $('#card-title').text('Data Kelas');
    });

    function update(id_k, id_p, id_g, kelas, nama) {
        $('#u-id').val(id_k);
        $('#u-opt-periode').val(id_p).trigger('change');
        $('#u-opt-guru').val(id_g).trigger('change');
        $('#u-kelas').val(kelas);
        $('#tbl-data').hide('slow');
        $('#group-btn').hide('slow');
        $('#f-update').show('slow');
        $('#card-title').text('Edit Kelas');
    }

    function batal() {
        $('#f-update').hide('slow');
        $('#group-btn').show('slow');
        $('#tbl-data').show('slow');
        $('#card-title').text('Data Kelas');
    }

    function hapus(id, nama, kelas) {
        $('#d-id').val(id);
        $('#d-nama').text(nama);
        $('#d-kelas').text("KELAS : " + kelas);
        $('#delete-modal').appendTo('body').modal('show');
    }
</script>
<?= $this->endSection() ?>