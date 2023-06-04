<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Presensi Hari Ini</h4>
            </div>
            <div class="card-body">
                <div class="float-right" role="group" aria-label="Basic example" id="group-btn">
                    <div class="form-inline">
                        <form action="<?= base_url('admin/presensi') ?>" method="post" id="f-kelas">
                            <select class="form-control bg-primary text-white" name="kelas"
                                onchange="$('#f-kelas').submit()">
                                <?php foreach ($kelas as $row): ?>
                                    <option value="<?= $row['kelas'] ?>" <?php if ($sel == $row['kelas']) {
                                          echo "selected";
                                      } ?>>
                                        Kelas
                                        <?= $row['kelas'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="today">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>Nama</th>
                                <th>Jam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($absen as $bar): ?>
                                <tr>
                                    <td class="text-center" width="5%">
                                        <?= $i++ . "."; ?>
                                    </td>
                                    <td>
                                        <?= $bar['nama']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        $first = new DateTime('07:00:59');
                                        $second = new DateTime($bar['jam_absensi']);
                                        ?>
                                        <?php if ($second > $first): ?>
                                            <span class="badge badge-light">
                                                <?= $bar['jam_absensi'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-dark">
                                                <?= $bar['jam_absensi'] ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><a href="#" class="btn btn-primary">Detail</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#today').dataTable({
            "pageLength": 50
        });
    });
</script>
<?= $this->endSection() ?>