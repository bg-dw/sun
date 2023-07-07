<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Presensi Hari Ini</h4>
                <div class="float-right" role="group" aria-label="Basic example" id="group-btn">
                    <div class="form-inline">
                        <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('presensi')) ?>" method="post"
                            id="f-kelas">
                            <select class="" name="kelas" onchange="$('#f-kelas').submit()">
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
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="today">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($absen)):
                                for ($i = 0; $i < count($absen); $i++): ?>
                                    <tr>
                                        <?php
                                        $first = new DateTime('07:00:59');
                                        $second = new DateTime($absen[$i]['jam']);
                                        ?>
                                        <td class="text-center" width="5%">
                                            <?= $i + 1 . "."; ?>
                                        </td>
                                        <td class="text-center"><button class="btn btn-sm btn-warning">Edit</button></td>
                                        <td class="text-center">
                                            <?php
                                            if ($absen[$i]['absensi'] != ""):
                                                if ($second > $first): ?>
                                                    <?= "TELAT"; ?>
                                                <?php else: ?>
                                                    <?= strtoupper($absen[$i]['absensi']); ?>
                                                    <?php
                                                endif;
                                            else:
                                                echo "-";
                                            endif; ?>
                                        </td>
                                        <td>
                                            <?= $absen[$i]['nama']; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            if ($absen[$i]['absensi'] != ""):
                                                if ($second > $first): ?>
                                                    <span class="badge badge-light">
                                                        <?= $absen[$i]['jam'] ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-dark">
                                                        <?= $absen[$i]['jam'] ?>
                                                    </span>
                                                    <?php
                                                endif;
                                            else:
                                                echo "-";
                                            endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                endfor;
                            endif; ?>
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