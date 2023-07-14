<?= $this->extend('v_guru/Main') ?>
<?= $this->section('content') ?>
<style>
    .btnFloat {
        position: fixed;
        bottom: 10%;
        right: 10px;
        z-index: 2;
    }
</style>
<?php
$daftar_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
function isSunday($date)
{
    return (date('N', strtotime($date)) > 6);
}
?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card d-print-none">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('edit-presensi')) ?>"
                            method="post" id="f-list"
                            onsubmit="$('#inpNama').val($('#inputps option:selected').text())">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputBulan">Bulan</label>
                                    <select id="inputBulan" class="form-control" name="bulan" required
                                        onchange="$('#f-list').submit()">
                                        <?php for ($j = 0; $j < count($bulan); $j++): ?>
                                            <option value="<?= $j + 1; ?>" <?php if (($sel_bulan - 1) == $j) {
                                                    echo "selected";
                                                } ?>>
                                                <?= $bulan[$j]; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputTahun">Tahun</label>
                                    <select id="inputTahun" class="form-control" name="tahun" required
                                        onchange="$('#f-list').submit()">
                                        <?php foreach ($periode as $per): ?>
                                            <option id="inputTahun" value="<?= $per['tahun_awal'] ?>" <?php if ($sel_tahun == $per['tahun_awal']) {
                                                  echo "selected";
                                              } ?>>
                                                <?= $per['tahun_awal'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputps">Peserta Didik</label>
                                    <select id="inputps" class="form-control" name="ps" required
                                        onchange="$('#f-list').submit()">
                                        <option value="">--Pilih Peserta Didik--</option>
                                        <?php foreach ($siswa as $row): ?>
                                            <option value="<?= $row['id_absensi']; ?>" <?php if ($sel_siswa == $row['id_absensi']) {
                                                  echo "selected";
                                              } ?>>
                                                <?= $row['nama']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="sel_nama" id="inpNama">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card d-print-none">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <label class="font-weight-bold">Keterangan : </label><br>
                            <button class="btn btn-lg btn-dark mb-3 mr-3">Hari Minggu</button>
                            <button class="btn btn-lg btn-light mb-3 mr-3">Belum Absen</button>
                            <button class="btn btn-lg btn-primary mb-3 mr-3">Hadir</button>
                            <button class="btn btn-lg btn-info mb-3 mr-3">Telat</button>
                            <button class="btn btn-lg btn-warning mb-3 mr-3">Ijin</button>
                            <button class="btn btn-lg btn-success mb-3 mr-3">Sakit</button>
                            <button class="btn btn-lg btn-danger mb-3 mr-3">Alpha</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <?php
        if ($sel_nama != ""): ?>
            <div class="card d-print-none">
                <div class="card-body">
                    <div class="row" id="list">
                        <div class="col-md-12">
                            <h4 class="text-center mb-3">
                                <?= $sel_nama . " - " . $daftar_bulan[$sel_bulan - 1] . " " . $sel_tahun ?>
                            </h4>
                        </div>
                        <div class="col-md-12">
                            <?php
                            for ($i = 0; $i < count($rec); $i++):
                                if (isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($i + 1)) == 1):
                                    ?>
                                    <button class="btn btn-lg btn-dark mt-2 mr-2">
                                        <?= "<h6>[" . ($i + 1) . "]</h6>" ?> Minggu
                                    </button>
                                    <?php
                                else:
                                    ?>
                                    <button class="btn btn-lg btn-<?php if ($rec[$i]['absensi'] == "hadir"): echo "primary"; elseif ($rec[$i]['absensi'] == "telat"): echo "info"; elseif ($rec[$i]['absensi'] == "ijin"): echo "warning"; elseif ($rec[$i]['absensi'] == "sakit"): echo "success"; elseif ($rec[$i]['absensi'] == "alpha"):
                                        echo "danger";
                                    else:
                                        echo "light";
                                    endif; ?> mt-2 mr-2"
                                        onclick="update('<?= $sel_tahun . '-' . $sel_bulan . '-' . ($i + 1) ?>','<?= $sel_nama ?>','<?= $rec[$i]['absensi'] ?>')">
                                        <?= "<h6>[" . ($i + 1) . "]</h6> " . $rec[$i]['absensi'] ?>
                                    </button>
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>

                    <div id="f-update" style="display: none;">
                        <form
                            action="<?= base_url('/' . bin2hex('guru') . '/' . bin2hex('aksi-edit-presensi') . '/' . $sel_bulan . '/' . $sel_tahun) ?>"
                            method="post">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <input type="hidden" name="id_absen" id="e-id" readonly>
                                    <div class="form-group col-md-6">
                                        <label for="inputBulan">Tanggal</label>
                                        <input type="text" name="tgl" class="form-control" id="e-tgl" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputBulan">Peserta Didik</label>
                                        <input type="text" class="form-control" id="e-ps" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="d-block">Jenis Absensi</label>
                                        <div class="form-check">
                                            <input class="form-check-input pil" type="radio" name="absensi" id="hadir"
                                                value="hadir">
                                            <label class="form-check-label" for="hadir">
                                                Hadir
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input pil" type="radio" name="absensi" id="hadir_t"
                                                value="telat">
                                            <label class="form-check-label" for="hadir_t">
                                                Hadir (Telat)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input pil" type="radio" name="absensi" id="sakit"
                                                value="sakit">
                                            <label class="form-check-label" for="sakit">
                                                Sakit
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input pil" type="radio" name="absensi" id="ijin"
                                                value="ijin">
                                            <label class="form-check-label" for="ijin">
                                                Ijin
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input pil" type="radio" name="absensi" id="alpha"
                                                value="alpha">
                                            <label class="form-check-label" for="alpha">
                                                Alpha
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" onclick="batal()">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    function update(tgl, nama, presensi) {
        var id = $('#inputps').val();
        $('#e-id').val(id);
        $('#e-tgl').val(tgl);
        $('#e-ps').val(nama);
        if (presensi == "hadir") {
            $('#hadir').prop('checked', true);
        } else if (presensi == "telat") { $('#hadir_t').prop('checked', true); } else if (presensi == "sakit") { $('#sakit').prop('checked', true); } else if (presensi == "ijin") { $('#ijin').prop('checked', true); } else if (presensi == "alpha") { $('#alpha').prop('checked', true); }
        $('#list').hide('slow');
        $('#f-update').show('slow');
    }
    function batal() {
        $('#e-id').val(""); $('.pil').prop('checked', false);
        $('#f-update').hide('slow');
        $('#list').show('slow');
    }
</script>
<?= $this->endSection() ?>