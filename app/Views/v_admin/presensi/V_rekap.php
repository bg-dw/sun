<?= $this->extend('v_admin/Main') ?>
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
function isSunday($date)
{
    return (date('N', strtotime($date)) > 6);
}
// dd($guru);
?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card d-print-none">
            <div class="card-body">
                <div class="row" style="margin-bottom: -25px;">
                    <div class="col-md-7">
                        <div class="">
                            <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('rekap-presensi')) ?>"
                                method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
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
                                    <div class="form-group col-md-3">
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
                                    <div class="form-group col-md-3">
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
                                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Hari Efektif</label>
                                <input type="number" min="1" max="32" class="form-control" value="1" name=""
                                    onchange="set_day();" id="inp-hari">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Tanggal Tutup Absen <i>( Bulan/Hari/Tahun )</i></label>
                                <input type="date" class="form-control" name="" onchange="set_date(this)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card" id="print-halaman" style="color:black;">
            <div class="card-body">
                <div class="float-right" style="margin-right: 20px;">Bulan :
                    <?= $bulan[intval($sel_bulan) - 1] . " " . $sel_tahun; ?>
                </div>
                <div class="table-responsive mt-2">
                    <table border="1" width="100%">
                        <tr>
                            <th class="text-center" rowspan="2">NO</th>
                            <th class="text-center" rowspan="2">NAMA SISWA</th>
                            <th class="text-center" rowspan="2">L / P</th>
                            <th class="text-center" colspan="<?= $tot_hari; ?>">TANGGAL</th>
                            <th class="text-center" colspan="4">TANGGAL</th>
                        </tr>
                        <tr>
                            <?php
                            for ($x = 0; $x < $tot_hari; $x++): ?>
                                <th class="text-center" style="<?php if (isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($x + 1)) == 1) {
                                    echo 'background-color:red;color:white;';
                                } ?>">
                                    <?= $x + 1; ?>
                                </th>
                            <?php endfor; ?>
                            <th class="text-center">S</th>
                            <th class="text-center">I</th>
                            <th class="text-center">A</th>
                            <th class="text-center">JML</th>
                        </tr>
                        <?php
                        // dd($rec);
                        $i = $sakit = $ijin = $alpha = $tot_sakit = $tot_ijin = $tot_alpha = 0;
                        if ($rec):
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
                                        <td class="text-center" style="min-width: 20px;<?php if (isSunday($sel_tahun . "-" . $sel_bulan . "-" . ($j + 1)) == 1) {
                                            echo 'background-color:red;color:white;';
                                        } ?>">
                                            <?php
                                            for ($x = 0; $x < $tot_hari; $x++): ?>
                                                <?php
                                                if (isset($rec[$i][$x])):
                                                    $get_tgl = explode("-", $rec[$i][$x]["tgl"]);
                                                    if (intval($get_tgl[2]) == $hari[$i][$j]):
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
                                                endif; ?>
                                                <?php
                                            endfor;
                                            ?>
                                        </td>
                                        <?php
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
                            endforeach;
                        endif;
                        ?>
                        <tr>
                            <td class="text-right" colspan="<?= $tot_hari + 3; ?>">JUMLAH ABSEN &nbsp;</td>
                            <td class="text-center" style="min-width: 15px;">
                                <?= $tot_sakit; ?>
                            </td>
                            <td class="text-center" style="min-width: 15px;">
                                <?= $tot_ijin; ?>
                            </td>
                            <td class="text-center" style="min-width: 15px;">
                                <?= $tot_alpha; ?>
                            </td>
                            <td class="text-center" style="min-width: 15px;">
                                <?= $tot_sakit + $tot_ijin + $tot_alpha; ?>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="inp-pembilang" value="<?= $sakit + $ijin + $alpha; ?>">
                    <input type="hidden" id="inp-siswa" value="<?= $i; ?>">
                    <table style="margin-left: 20%;margin-top: 20px;">
                        <tr>
                            <td>Absen ditutup pada tanggal, </td>
                            <td></td>
                            <td id="tgl_absen"></td>
                        </tr>
                    </table>
                    <table style="margin-left: 20%;margin-top: 10px;">
                        <tr>
                            <td rowspan="2">Prosentase</td>
                            <td></td>
                            <td rowspan="2"> =</td>
                            <td style="border-bottom: 1px solid;text-align: center;" width="90px" id="v-alpha">
                            </td>
                            <td rowspan="2">&nbsp x 100 = </td>
                            <td rowspan="2" id="v-hasil">&nbsp;</td>
                            <td rowspan="2">%</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center" id="v-pembagi">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="font-weight: bold;">
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center"><span class='fas fa-check'></span></td>
                            <td>&nbsp;:</td>
                            <td>Hadir</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center"><span class='fas fa-times'></span></td>
                            <td>&nbsp;:</td>
                            <td>Telat</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center">S</td>
                            <td>&nbsp;:</td>
                            <td>Sakit</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center">I</td>
                            <td>&nbsp;:</td>
                            <td>Izin</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center">A</td>
                            <td>&nbsp;:</td>
                            <td>Alpha</td>
                        </tr>
                    </table>
                    <table style="margin-left: 35%;">
                        <tr>
                            <td>Mengetahui</td>
                            <td></td>
                        </tr>
                        <tr valign="top">
                            <td height="100px;">Kepala Sekolah</td>
                            <td>Guru Kelas
                                <?= $sel_kelas ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="350px">
                                <u>
                                    <?= $kepsek['nama_guru'] . ", " . $kepsek['gelar_guru'] ?>
                                </u>
                            </td>
                            <td>
                                <u>
                                    <?= $guru['nama_guru'] . ", " . $guru['gelar_guru'] ?>
                                </u>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                NIP.
                                <?= $kepsek['nip'] ?>
                            </td>
                            <td>
                                NIP.
                                <?= $guru['nip'] ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <button class="btnFloat btn btn-icon btn-lg btn-primary d-print-none" onclick="cetak();" style="display: none;"
        id="btn-print">
        <i class="my-float fas fa-print">Cetak</i>
    </button>
</div>
<script>
    function set_day() {
        set_val();
    }
    function set_date(e) {
        $('#btn-print').show();
        let tgl = e.value.split("-");
        $("#tgl_absen").text(tgl[2] + " - " + tgl[1] + " - " + tgl[0]);
        set_val();
    }

    function set_val() {
        var pembilang = $('#inp-pembilang').val();
        var hari = $('#inp-hari').val();
        var siswa = $('#inp-siswa').val();
        console.log(pembilang);
        console.log(hari);
        console.log(siswa);
        $('#v-alpha').text(pembilang);
        $('#v-pembagi').text(hari + " x " + siswa);
        $('#v-hasil').text(((pembilang / (hari * siswa)) * 100).toFixed(1));
    }
    function cetak() {
        var myWindow = window.open('', '', 'width=1366,height=768');
        myWindow.document.write('<html><head>');
        myWindow.document.write('<link href="<?= base_url() ?>/public/assets/css/app.min.css" rel="stylesheet" />');
        myWindow.document.write('<link href="<?= base_url() ?>/public/assets/css/style.css" rel="stylesheet" />');
        myWindow.document.write('<link href="<?= base_url() ?>/public/assets/css/components.css" rel="stylesheet" />');
        myWindow.document.write('</head><body style="background-color:white;color:black;">');
        myWindow.document.write('<style>');
        myWindow.document.write('@media print {@page {size: A3 landscape;max-height:100%; max-width:100%}body{margin:0px;width:100%;height:100%; font-size: 12pt; scale(.90,.90);}}');
        myWindow.document.write('</style>');
        myWindow.document.write($('#print-halaman').html());
        myWindow.document.write('</body>');
        myWindow.document.write('</html>');

        // myWindow.document.close();

        setTimeout(function () {
            myWindow.print();
            // myWindow.close();
        }, 500);

    }
</script>
<?= $this->endSection() ?>