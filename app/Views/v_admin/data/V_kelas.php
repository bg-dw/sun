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
                <?php
                // dd($kelas);
                // echo $kelas[0]->id_kelas;
                ?>
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
                                            <button class="btn btn-warning" data-toggle="tooltip" title="Edit Siswa">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger" data-toggle="tooltip" title="Hapus Siswa">
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
                <form action="<?= base_url('admin/kelas/add') ?>" method="post"
                    onsubmit="return confirm('Simpan data?')">
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
</script>
<?= $this->endSection() ?>