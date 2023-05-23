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
                            if (isset($periode) && count($periode) > 0) {
                                foreach ($periode as $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 4%">
                                            <?= $i++; ?>
                                        </td>
                                        <td class="text-center" style="width: 11%">
                                            <button class="btn btn-warning" data-toggle="tooltip" title="Edit Siswa">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger" data-toggle="tooltip" title="Hapus Siswa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <?= $row['tahun_awal'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $row['tahun_akhir'] ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <span
                                                class="badge badge-<?= ($row['status_periode'] == 'aktif') ? 'success' : 'light'; ?>">
                                                <?= strtoupper($row['status_periode']) ?>
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
                <?= csrf_field(); ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tahun Awal</label>
                        <input type="number" class="form-control" value="<?= date('Y') ?>" placeholder="Ex:2023">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Tahun Akhir</label>
                        <input type="number" class="form-control" value="<?= date('Y') + 1 ?>" placeholder="Ex:2024">
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button class="btn btn-secondary" type="button" id="btn-cancel">Batal</button>
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
</script>
<?= $this->endSection() ?>