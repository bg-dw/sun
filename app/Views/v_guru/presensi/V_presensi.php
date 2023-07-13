<?= $this->extend('v_guru/Main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Presensi Hari Ini
                    <?php if (isset($sel)): ?> - [ Kelas
                        <?= $sel ?> ]
                    <?php endif; ?>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="data">
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
                                        <td class="text-center"><button class="btn btn-sm btn-warning"
                                                onclick="set_absen('<?= $absen[$i]['id_absensi'] ?>','<?= $absen[$i]['nama'] ?>')">Edit</button>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            if ($absen[$i]['absensi'] != ""):
                                                echo strtoupper($absen[$i]['absensi']);
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
                <div id="e-absen" style="display: none;">
                    <form action="<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('set-presensi')) ?>" method="post">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="hidden" name="id_absen" class="form-control" id="e-id">
                            <input type="text" class="form-control" id="e-nama" disabled>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Jenis Absensi</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="absensi" id="hadir" value="hadir"
                                    checked>
                                <label class="form-check-label" for="hadir">
                                    Hadir
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="absensi" id="hadir_t" value="telat">
                                <label class="form-check-label" for="hadir_t">
                                    Hadir (Telat)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="absensi" id="sakit" value="sakit">
                                <label class="form-check-label" for="sakit">
                                    Sakit
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="absensi" id="ijin" value="ijin">
                                <label class="form-check-label" for="ijin">
                                    Ijin
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="absensi" id="alpha" value="alpha">
                                <label class="form-check-label" for="alpha">
                                    Alpha
                                </label>
                            </div>
                        </div>
                        <div class="float-right">
                            <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                            <button class="btn btn-secondary" type="button" onclick="batal_absen()">Batal</button>
                        </div>
                    </form>
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

        //set absen
        function set_absen(id, nama) {
            $('#data').hide("slow");
            $('#e-id').val(id);
            $('#e-nama').val(nama);
            $('#e-absen').show("slow");
        }

        //batal absen
        function batal_absen() {
            $('#e-absen').hide("slow");
            $('#data').show("slow");
        }
    </script>
    <?= $this->endSection() ?>