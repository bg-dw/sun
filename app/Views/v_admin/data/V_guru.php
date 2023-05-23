<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="card-title">Data Guru</h4>
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
                <?php
                // dd($guru);
                ?>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    No.
                                </th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Gelar</th>
                                <th class="text-center">Akses</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($guru) && count($guru) > 0) {
                                foreach ($guru as $row) {
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
                                            <?= empty($row['nip']) ? "-" : $row['nip'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nama_guru'] ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <?= $row['gelar_guru'] ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <?= $row['level_login'] ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <span
                                                class="badge badge-<?= ($row['status_guru'] == 'aktif') ? 'success' : 'light'; ?>">
                                                <?= strtoupper($row['status_guru']) ?>
                                            </span>
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
                <form action="<?= base_url('admin/guru/add') ?>" method="post"
                    onsubmit="return confirm('Simpan data?')">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Ex:123">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Ex:Midas" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Gelar</label>
                            <input type="text" name="gelar" class="form-control" placeholder="Ex:S.Pd.">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Akses</label>
                            <select name="akses" class="form-control" required>
                                <option value="GR">Guru</option>
                                <option value="KS">Kepala Sekolah</option>
                                <option value="ADM">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" id="btn-cancel">Batal</button>
                    </div>
                </form>
            </div>
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
        $('#card-title').text('Tambah Data Guru');
    });
    $('#btn-cancel').click(function () {
        $('#f-add').hide('slow');
        $('#group-btn').show('slow');
        $('#tbl-data').show('slow');
        $('#card-title').text('Data Guru');
    });
</script>
<?= $this->endSection() ?>