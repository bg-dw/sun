<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Peserta Didik</h4>
                <div class="card-header-action" role="group" aria-label="Basic example" id="group-btn">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-modal">
                        <i class="fas fa-file-import"></i> Import
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-add">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
            <div class="card-body" id="tbl-data">
                <?php
                // dd($siswa);
                ?>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    No.
                                </th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">NIS</th>
                                <th class="text-center">NISN</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">RFID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($siswa) && count($siswa) > 0) {
                                foreach ($siswa as $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 7%">
                                            <?= $i++; ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <button class="btn btn-warning" data-toggle="tooltip" title="Edit Siswa">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger" data-toggle="tooltip" title="Hapus Siswa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td class="text-center" style="width: 13%">
                                            <?= $row['nis'] ?>
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <?= $row['nisn'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nama'] ?>
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <?php if ($row['rfid']): ?>
                                                <button class="btn btn-icon btn-info" data-toggle="tooltip" title="
                                            <?= $row['rfid'] ?>">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-icon btn-outline-primary" data-toggle="tooltip"
                                                    title="Tambah RFID" onclick="add_rfid('<?= $row['id_siswa'] ?>')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button class="btn btn-icon btn-outline-warning" data-toggle="tooltip"
                                                title="Edit RFID">
                                                <i class="far fa-edit"></i>
                                            </button>
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
                <div class="form-group">
                    <label>Default Input Text</label>
                    <input type="text" class="form-control">
                </div>
                <div class="text-right">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button class="btn btn-secondary" type="button" id="btn-cancel">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-modal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Peserta Didik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/import/siswa') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>File Excel Siswa (.xls/.xlsx)</label>
                        <input type="file" name="excel" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Proses</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="add-rfid" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah RFID</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/add/rfid') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor RFID</label>
                        <input type="text" name="rfid" class="form-control" required id="inp-rfid" style="opacity: 0;">
                        <label for=""><i>*Silahkan tempelkan kartu pada alat pembaca RFID.</i></label>
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

<script>
    // $(function () {
    // });
    $('#add-modal').appendTo('body').modal('show');
    $('#btn-add').click(function () {
        $('#tbl-data').hide('slow');
        $('#group-btn').hide('slow');
        $('#f-add').show('slow');
    });
    $('#btn-cancel').click(function () {
        $('#f-add').hide('slow');
        $('#group-btn').show('slow');
        $('#tbl-data').show('slow');
    });

    function add_rfid(id) {
        $('#add-rfid').appendTo('body').modal('show');
        setTimeout(function () { $('#inp-rfid').focus() }, 200);
    }
</script>
<?= $this->endSection() ?>