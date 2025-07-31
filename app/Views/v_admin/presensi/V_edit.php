<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<?php
function isSunday($date)
{
    return (date('N', strtotime($date)) > 6);
}
?>
<div class="row justify-content-center">.
    <div class="col-md-12">
        <div class="card d-print-none card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="pil-by">Berdasarkan</label>
                                <select id="pil-by" class="form-control" onchange="pil_by(this)">
                                    <option value="-">=== Memilih ===</option>
                                    <option value="0">
                                        Tanggal
                                    </option>
                                    <option value="1">
                                        Kelas
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-9" id="c-tanggal" style="display: none;">
                                <?= csrf_field(); ?>
                                <form
                                    action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('update-presensi') . '/' . bin2hex('multiple')) ?>"
                                    method="post" id="f-by-tgl">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="pil-by-date">Tanggal</label>
                                            <input id="pil-by-date" name="inp-tgl" type="text"
                                                class="form-control daterange-weeks">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Presensi</label>
                                            <div class="row">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inp-presensi"
                                                        id="r-hadir" value="hadir" checked onchange="cek_rad()">
                                                    <label class="form-check-label" for="r-hadir">Hadir</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inp-presensi"
                                                        id="r-hapus" value="hapus" onchange="cek_rad()">
                                                    <label class="form-check-label" for="r-hapus">Hapus
                                                        Presensi</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-inline">
                                            <button type="button" class="btn btn-primary" onclick="conf_modal()"
                                                id="btn-submit-tgl">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group col-md-9" id="c-kelas" style="display: none;">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="inputKelas">Kelas</label>
                                        <select id="inputKelas" class="form-control" name="kelas" required>
                                            <?php foreach ($kelas as $row): ?>
                                                <option value="<?= $row['kelas'] ?>" <?php if ($sel_kelas == $row['kelas']) {
                                                      echo "selected";
                                                  } ?>>
                                                    Kelas
                                                    <?= $row['kelas'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputBulan">Bulan</label>
                                        <select id="inputBulan" class="form-control" name="bulan" required>
                                            <?php for ($j = 0; $j < count($bulan); $j++): ?>
                                                <option value="<?= $j + 1; ?>" <?php if (($sel_bulan - 1) == $j) {
                                                        echo "selected";
                                                    } ?>>
                                                    <?= $bulan[$j]; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputTahun">Tahun</label>
                                        <select id="inputTahun" class="form-control" name="tahun" required>
                                            <?php foreach ($periode as $per): ?>
                                                <option id="inputTahun" value="<?= $per['tahun_awal'] ?>" <?php if ($sel_tahun == $per['tahun_awal']) {
                                                      echo "selected";
                                                  } ?>>
                                                    <?= $per['tahun_awal'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-inline">
                                        <button type="button" class="btn btn-primary">Pilih</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row" style="display: none;" id="info-by-tgl">
                            <div class="alert alert-info alert-has-icon">
                                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Info</div>
                                    <b> Pada input tanggal, hanya dapat memilih maksimal 7 hari aktif.</b>
                                    <ul>
                                        <li>Presensi Hadir : Hanya akan merubah data kehadiran (tidak menambahkan data
                                            baru).</li>
                                        <li>Hapus Presensi : Akan menghapus data secara permanen dari database (tidak
                                            dapat dikembalikan).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="tbl_presensi" style="display:none;">
    <div class="col-12">
        <div class="card d-print-none" id="print-halaman" style="color:black;">
            <div class="card-body">
                <div class="float-right" style="margin-right: 20px;">Bulan :
                    <?= $bulan[intval($sel_bulan) - 1] . " " . $sel_tahun; ?>
                </div>
                <div class="table-responsive mt-2">
                    <?php
                    // dd($rec); 
                    ?>
                    <table border="1" width="100%">
                        <tr>
                            <th class="text-center" rowspan="2">NO</th>
                            <th class="text-center" rowspan="2">NAMA SISWA</th>
                            <th class="text-center" rowspan="2">L / P</th>
                            <th class="text-center" colspan="<?= $tot_hari; ?>">TANGGAL</th>
                        </tr>
                        <tr>
                            <?php
                            for ($x = 0; $x < $tot_hari; $x++): ?>
                                <th class="text-center" style="<?php if (isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($x + 1)) == 1) {
                                    echo 'color:red;';
                                } ?>">
                                    <?= $x + 1; ?>
                                </th>
                            <?php endfor; ?>
                        </tr>
                        <?php

                        $i = $sakit = $ijin = $alpha = $tot_sakit = $tot_ijin = $tot_alpha = 0;
                        if ($rec):
                            $h = 0;
                            foreach ($siswa as $row): ?>
                                <tr>
                                    <td class="text-center">
                                        <?= ($i + 1) . "."; ?>
                                    </td>
                                    <td>
                                        &nbsp;
                                        <?= $row["nama"]; ?>
                                    </td>
                                    </td>
                                    <td class="text-center">
                                        &nbsp;
                                        <?= $row["jk"]; ?>
                                    </td>
                                    <?php
                                    $sakit = $ijin = $alpha = 0;
                                    $bar_sakit = $bar_ijin = $bar_alpha = 0;
                                    for ($j = 0; $j < $tot_hari; $j++): ?>
                                        <?php
                                        if ((isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($j + 1)) == 1) && ($h == 0)) { ?>
                                            <!-- hari minggu untuk rowspan -->
                                            <td class="text-center"
                                                style="min-width: 20px;background-color:red;color:white;writing-mode: tb-rl;transform: rotate(-180deg);"
                                                <?php if (isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($j + 1)) == 1) {
                                                    echo 'rowspan="' . count($rec) . '"';
                                                } ?>> MINGGU
                                            </td>
                                            <?php
                                        } elseif ((isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($j + 1)) != 1) && ($h != 0)) { ?>
                                            <!-- presensi untuk record ke-2 dan seterusnya -->
                                            <td class="text-center" style="min-width: 20px;<?php if (isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($j + 1)) == 1) {
                                                echo 'background-color:red;color:white;';
                                            } ?>">
                                                <?php
                                                for ($x = 0; $x < $tot_hari; $x++): ?>
                                                    <?php
                                                    if (isset($rec[$i][$x])):
                                                        if ($rec[$i][$x]["nama"] != ""):
                                                            $cek = array_search(intval($hari[$i][$j]), $libur);//cek hari libur
                                                            if (($cek !== false) && $x === 0)://jika hari libur
                                                                echo "<span class='fas fa-circle'></span>";
                                                            else:
                                                            endif;
                                                            $get_tgl = explode("-", $rec[$i][$x]["tgl"]);
                                                            if (intval($get_tgl[2]) == $hari[$i][$j]):
                                                                $cek = array_search(intval($get_tgl[2]), $libur);//cek hari libur
                                                                if ($cek !== false)://jika hari libur
                                                                    echo "<span class='fas fa-circle'></span>";
                                                                else:
                                                                    if ($rec[$i][$x]["absensi"] == "hadir"):
                                                                        echo "<span class='fas fa-check'></span>";
                                                                    elseif ($rec[$i][$x]["absensi"] == "telat"):
                                                                        echo "<span class='fas fa-times'></span>";
                                                                    elseif ($rec[$i][$x]["absensi"] == "sakit"):
                                                                        $sakit++;
                                                                        echo "<b>S</b>";
                                                                    elseif ($rec[$i][$x]["absensi"] == "ijin"):
                                                                        $ijin++;
                                                                        echo "<b>I</b>";
                                                                    elseif ($rec[$i][$x]["absensi"] == "alpha"):
                                                                        $alpha++;
                                                                        echo "<b>A</b>";
                                                                    endif;
                                                                endif;
                                                            endif;
                                                        endif;
                                                    endif; ?>
                                                    <?php
                                                endfor;
                                                ?>
                                            </td>
                                            <?php
                                        } else {
                                            if (isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($j + 1)) == 0) { ?>
                                                <!-- presensi untuk record ke-1 -->
                                                <td class="text-center" style="min-width: 20px;">
                                                    <?php
                                                    for ($x = 0; $x < $tot_hari; $x++): ?>
                                                        <?php
                                                        if (isset($rec[$i][$x])):
                                                            if ($rec[$i][$x]["nama"] != ""):
                                                                $get_tgl = explode("-", $rec[$i][$x]["tgl"]);
                                                                $cek = array_search(intval($hari[$i][$j]), $libur);//cek hari libur
                                                                if (($cek !== false) && $x === 0)://jika hari libur
                                                                    echo "<span class='fas fa-circle'></span>";
                                                                else:
                                                                endif;
                                                                if (intval($get_tgl[2]) == $hari[$i][$j]):
                                                                    $cek = array_search(intval($get_tgl[2]), $libur);//cek hari libur
                                                                    if ($cek !== false)://jika hari libur
                                                                        echo "<span class='fas fa-circle'></span>";
                                                                    else:
                                                                        if ($rec[$i][$x]["absensi"] == "hadir"):
                                                                            echo "<span class='fas fa-check'></span>";
                                                                        elseif ($rec[$i][$x]["absensi"] == "telat"):
                                                                            echo "<span class='fas fa-times'></span>";
                                                                        elseif ($rec[$i][$x]["absensi"] == "sakit"):
                                                                            $sakit++;
                                                                            echo "<b>S</b>";
                                                                        elseif ($rec[$i][$x]["absensi"] == "ijin"):
                                                                            $ijin++;
                                                                            echo "<b>I</b>";
                                                                        elseif ($rec[$i][$x]["absensi"] == "alpha"):
                                                                            $alpha++;
                                                                            echo "<b>A</b>";
                                                                        endif;
                                                                    endif;
                                                                endif;
                                                            endif;
                                                        endif; ?>
                                                        <?php
                                                    endfor;
                                                    ?>
                                                </td>
                                            <?php }
                                        }
                                    endfor;
                                    $i++;
                                    ?>
                                    <td class="text-center">
                                        <?= $bar_sakit += $sakit; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $bar_ijin += $ijin; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $bar_alpha += $alpha; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $sakit + $ijin + $alpha; ?>
                                    </td>
                                </tr>
                                <?php
                                $tot_sakit += $bar_sakit;
                                $tot_ijin += $bar_ijin;
                                $tot_alpha += $bar_alpha;
                                $h++;
                            endforeach;
                        endif;
                        ?>
                    </table>
                    <input type="hidden" id="inp-pembilang" value="<?= $tot_sakit + $tot_ijin + $tot_alpha; ?>">
                    <input type="hidden" id="inp-siswa" value="<?= $i; ?>">
                </div>
            </div>
        </div>
    </div>
    <button class="btnFloat btn btn-icon btn-lg btn-primary d-print-none" onclick="cetak();" style="display: none;"
        id="btn-print">
        <i class="my-float fas fa-print">Cetak</i>
    </button>
</div>
<!-- Modal update presensi by tanggal -->
<div class="modal fade" id="m-uby-tgl-h" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Perbaharui Data Presensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" required id="inp-u-status">
                Tindakan ini akan
                <b><u>MEMPERBAHARUI</u></b> data presensi pada tanggal yang telah anda pilih.
                Simpan data?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" onclick="submit_form()">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="m-uby-tgl-d" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Presensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" required id="inp-u-status">
                Tindakan ini akan
                <b><u>MENGHAPUS</u></b> data presensi dari Basis Data pada taggal yang telah anda pilih.
                Hapus data?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-danger" onclick="submit_form()">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<script>
    function pil_by(e) {
        $('#info-by-tgl').hide();
        if (e.value == 0) {
            $('#c-kelas').hide();
            $('#tbl_presensi').hide();
            $('#c-tanggal').show("slow");
            $('#info-by-tgl').show("slow");
        } else if (e.value == 1) {
            $('#c-tanggal').hide();
            $('#c-kelas').show("slow");
            $('#tbl_presensi').show("slow");
        } else {
            $('#tbl_presensi').hide();
            $('#c-tanggal').hide();
            $('#c-kelas').hide();
        }
    }
    function cek_rad() {
        var rad = $("input[type='radio'][name='inp-presensi']:checked").val();
        if (rad == "hadir") {
            $("#btn-submit-tgl").attr('class', 'btn btn-primary');
            $("#btn-submit-tgl").html('Simpan');
        } else if (rad == "hapus") {
            $("#btn-submit-tgl").attr('class', 'btn btn-danger');
            $("#btn-submit-tgl").html('Hapus');
        }
    }

    function conf_modal() {
        var rad = $("input[type='radio'][name='inp-presensi']:checked").val();
        if (rad == "hadir") {
            $('#m-uby-tgl-h').appendTo('body').modal('show');
            $('#m-uby-tgl-h').modal('show');
        } else if (rad == "hapus") {
            $('#m-uby-tgl-d').appendTo('body').modal('show');
            $('#m-uby-tgl-d').modal('show');
        }
    }

    function submit_form() {
        document.getElementById("f-by-tgl").submit();
    }
</script>
<?= $this->endSection() ?>