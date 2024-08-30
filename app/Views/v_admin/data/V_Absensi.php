<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Data Presensi</h4>
                <div class="card-header-action" role="group" aria-label="Basic example" id="group-btn">
                    <button type="button" class="btn btn-primary" id="btn-add">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
            <div class="card-body" id="tbl-data">
                <?php
                ?>
                <div class="table-responsive">
                    <table class="table table-striped" id="data-presensi">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    No.
                                </th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">RFID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($presensi) && count($presensi) > 0) {
                                foreach ($presensi as $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 7%">
                                            <?= ($i++) . "."; ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data"
                                                onclick="update('<?= $row['id_absensi'] ?>','<?= $row['id_siswa'] ?>','<?= $row['id_kelas'] ?>')">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus Data"
                                                onclick="hapus('<?= $row['id_absensi'] ?>','<?= $row['nama'] ?>','<?= $row['kelas'] ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <?= $row['nama'] ?>
                                        </td>
                                        <td style="width: 10%">
                                            <?= $row['kelas'] ?>
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <?php if ($row['rfid']): ?>
                                                <button class="btn btn-sm btn-icon btn-info" data-toggle="tooltip" title="
                                            <?= $row['rfid'] ?>">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-icon btn-outline-warning" data-toggle="tooltip"
                                                    title="Edit RFID" onclick="edit_rfid('<?= $row['id_absensi'] ?>')">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-icon btn-outline-primary" data-toggle="tooltip"
                                                    title="Tambah RFID" onclick="add_rfid('<?= $row['id_absensi'] ?>')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            <?php endif; ?>
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
                <form
                    action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('presensi') . '/' . bin2hex('add')) ?>"
                    method="post">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Nama Siswa/Siswi</label>
                            <select name="siswa" class="form-control select2" style="width:100%;" required>
                                <?php foreach ($siswa as $row): ?>
                                    <option value="<?= $row['id_siswa'] ?>"><?= $row['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Kelas</label>
                            <select name="kelas" class="form-control select2" style="width:100%;" required>
                                <?php foreach ($kelas as $bar): ?>
                                    <option value="<?= $bar['id_kelas'] ?>"><?= $bar['kelas'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Nomor RFID</label>
                            <input type="text" name="rfid" class="form-control" placeholder="Ex: VI" required
                                id="inp-rfid">
                            <label><i>*Silahkan tempelkan kartu pada alat pembaca RFID.</i></label>
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
                    action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('presensi') . '/' . bin2hex('update')) ?>"
                    method="post">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <input type="hidden" name="id" id="u-id">
                        <div class="form-group col-md-4">
                            <label>Nama Siswa/Siswi</label>
                            <select name="siswa" class="form-control select2" style="width:100%;" required id="u-nama">
                                <?php foreach ($siswa as $row): ?>
                                    <option value="<?= $row['id_siswa'] ?>"><?= $row['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Kelas</label>
                            <select name="kelas" class="form-control select2" style="width:100%;" required id="u-kelas">
                                <?php foreach ($kelas as $bar): ?>
                                    <option value="<?= $bar['id_kelas'] ?>"><?= $bar['kelas'] ?></option>
                                <?php endforeach; ?>
                            </select>
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
<div class="modal fade" id="edit-rfid" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit RFID</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('edit') . '/' . bin2hex('rfid')) ?>"
                method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_absensi" class="form-control" required id="ed-id">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="number" name="rfid" class="form-control" required id="ed-rfid" autocomplete="off"
                            style="opacity: 0;">
                        <h2 class="text-center">*Silahkan tempelkan kartu baru pada alat pembaca RFID.</h2>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
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
            <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('presensi') . '/' . bin2hex('delete')) ?>"
                method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" class="form-control" required id="d-id">
                    <center>
                        <h3 id="d-kelas"></h3>
                        <h3 id="d-nama"></h3>
                        <label class="text-danger">Seluruh data yang Presensi siswa tersebut akan terhapus. Hapus
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
    $(function () {
        $('#data-presensi').DataTable({
            // "order": [[3, 'asc']],
            "columnDefs": [
                { "orderable": false, "targets": [1, 4] }
            ]
        });
    });
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

    function add_rfid(id) {
        $('#add-rfid').appendTo('body').modal('show');
        $('#inp-id').val(id);
        setTimeout(function () { $('#inp-rfid').focus() }, 500);
    }
    function edit_rfid(id) {
        $('#edit-rfid').appendTo('body').modal('show');
        $('#ed-id').val(id);
        setTimeout(function () { $('#ed-rfid').focus() }, 500);
    }

    function update(id_p, id_siswa, id_kelas) {
        $('#tbl-data').hide('slow');
        $('#btn-add').hide('slow');
        $('#f-update').show('slow');
        $('#inp-rfid').focus();
        $('#u-id').val(id_p);
        $('#u-nama').val(id_siswa).trigger('change');
        $('#u-kelas').val(id_kelas).trigger('change');
    }

    function batal() {
        $('#f-update').hide('slow');
        $('#btn-add').show('slow');
        $('#tbl-data').show('slow');
    }

    function hapus(id, nama, kelas) {
        $('#d-id').val(id);
        $('#d-nama').text(nama);
        $('#d-kelas').text("KELAS : " + kelas);
        $('#delete-modal').appendTo('body').modal('show');
    }

</script>
<?= $this->endSection() ?>