<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="card-title">Anggota Rombel <?= $pil_kelas ?></h4>
                <div class="card-header-action" role="group" aria-label="Basic example">
                    <?php if ($pil_tingkat == 1): ?>
                        <button type="button" class="btn btn-primary"
                            onclick="location.href='<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('data-presensi')) ?>'">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-primary" id="btn-add">
                            <i class="fas fa-plus"></i> Anggota Rombel
                        </button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-secondary" id="btn-cancel"
                        style="display:none;">Kembali</button>
                </div>
            </div>
            <div class="card-body" id="tbl-data">
                <?php
                // dd($siswa_lama);
                ?>
                <div class="table-responsive">
                    <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('data-siswa-kelas')) ?>"
                        method="post" id="f-pil-kelas">
                        <div class="col-md-3 mb-2">
                            <select name="id_kelas" class="form-control warning" id=""
                                onchange="$('#f-pil-kelas').submit()">
                                <?php foreach ($kelas as $row): ?>
                                    <option value="<?= $row['id_kelas']; ?>" <?php if ($row['id_kelas'] === $pil_id) {
                                          echo "selected";
                                      } ?>>Kelas <?= $row['kelas']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    No.
                                </th>
                                <th class="text-center">NISN</th>
                                <th class="text-center">ROMBEL</th>
                                <th class="text-center">NAMA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($siswa) && count($siswa) > 0) {
                                foreach ($siswa as $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 7%">
                                            <?= $i++ . "."; ?>
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <?= $row['nisn'] ?>
                                        </td>
                                        <td class="text-center" style="width: 13%">
                                            <?= $row['kelas'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nama'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body" id="f-add" style="display:none;">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-icon icon-right btn-danger pull-right" id="btn-pindahkan">Pindahkan
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            <h5>Rombel Saat Ini</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-icon icon-left btn-success" id="btn-naik-kelas">
                                <i class="fas fa-arrow-left"></i> Naik Kelas
                            </button>
                            <h5 class="pull-right">Rombel Lama</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="width: 100%;" id="t-rombel-baru">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 3%">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup1"
                                                    data-checkbox-role="dad" class="custom-control-input"
                                                    id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">*</label>
                                            </div>
                                        </th>
                                        <th class="text-center" style="width: 65%">NAMA</th>
                                        <th class="text-center" style="width: 15%">NISN</th>
                                        <th class="text-center" style="width: 17%">ROMBEL BARU</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">
                                    <?php $i = 1;
                                    if (isset($siswa) && count($siswa) > 0) {
                                        foreach ($siswa as $row) {
                                            ?>
                                            <tr id="row1-<?= $i ?>">
                                                <td class="text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup1" name="id_siswa_baru[]"
                                                            class="custom-control-input" id="cb1-<?= $i; ?>"
                                                            value="<?= $row['id_siswa']; ?>">
                                                        <label for="cb1-<?= $i; ?>" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?= $row['nama'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $row['nisn'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $row['kelas'] ?>
                                                    <input type="hidden" id="id-kelas-baru-<?= $i; ?>"
                                                        value="<?= $row['id_kelas'] ?>">
                                                </td>
                                            </tr>
                                            <?php $i++;
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-dark" style="width: 100%;"
                                id="t-rombel-lama">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 3%;color: white;">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup2"
                                                    data-checkbox-role="dad" class="custom-control-input"
                                                    name="id_siswa" id="checkbox-all-2">
                                                <label for="checkbox-all-2" class="custom-control-label">*</label>
                                            </div>
                                        </th>
                                        <th class="text-center" style="width: 65%;color: white;">NAMA</th>
                                        <th class="text-center" style="width: 15%;color: white;">NISN</th>
                                        <th class="text-center" style="width: 17%;color: white;">ROMBEL LAMA</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody2">
                                    <?php
                                    if (isset($siswa_lama) && count($siswa_lama) > 0) {
                                        foreach ($siswa_lama as $row) {
                                            $tr_id = rand();
                                            ?>
                                            <tr id="row2-<?= $tr_id; ?>">
                                                <td class="text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup2"
                                                            class="custom-control-input" name="id_siswa_lama[]"
                                                            id="cb2-<?= $tr_id; ?>" value="<?= $row['id_siswa']; ?>">
                                                        <label for="cb2-<?= $tr_id; ?>"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?= $row['nama'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $row['nisn'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $row['kelas'] ?>
                                                    <input type="hidden" name="id_kelas_lama[]"
                                                        id="id-kelas-lama-<?= $tr_id; ?>" value="<?= $row['id_kelas'] ?>">
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btn-add').click(function () {
        $('#tbl-data').hide('slow');
        $('#btn-add').hide();
        $('#f-add').show('slow');
        $('#btn-cancel').show('slow');
        $('#btn-cancel').show('slow');
    });
    $('#btn-cancel').click(function () {
        $('#f-add').hide('slow');
        $('#btn-cancel').hide();
        $('#btn-add').show('slow');
        $('#tbl-data').show('slow');
    });

    tr_def = $("table#t-rombel-lama tr:eq(1)");//mengambil tr/array ke 1
    var kelas_lama = tr_def.find("td:eq(3)").text();//mengambil kolom array ke 3

    $('#btn-naik-kelas').click(function () {
        var kelas = $('#card-title').text().split(" ");
        var id = new Array();//id_siswa
        var row = new Array();
        var pil = $('input[name="id_siswa_lama[]"]:checked').each(function () {
            id_inp = $(this).attr('id').split("-");
            id_kel_lama = $('#id-kelas-lama-' + id_inp[1]).val();
            tr = $("table#t-rombel-lama tr#row2-" + id_inp[1]);
            val = tr.find("td:eq(0)");
            nama = tr.find("td:eq(1)").text();
            nisn = tr.find("td:eq(2)").text();
            kel_lama = tr.find("td:eq(3)").text();
            srt = tr.attr('srt');
            id.push($(this).val());

            //remove row from table
            $("table#t-rombel-lama tr#row2-" + id_inp[1]).remove();
            //make a new row
            html = '<tr id="row1-' + id_inp[1] + '"><td class="text-center"><div class="custom-checkbox custom-control"><input type="checkbox" data-checkboxes="mygroup1"class="custom-control-input" name="id_siswa_baru[]" id="cb1-' + id_inp[1] + '"  value="' + $(this).val() + '"><label for="cb1-' + id_inp[1] + '"class="custom-control-label">&nbsp;</label></div></td><td>' + nama + '</td><td class="text-center">' + nisn + '</td><td class="text-center">' + kelas[2] + '<input type="hidden" id="id-kelas-baru-' + id_inp[1] + '"value="' + id_kel_lama + '"></td></tr>';
            row.push($(html)); //create row
        });

        if (id.length > 0) {
            $.ajax({
                url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('update-siswa-kelas')); ?>",
                type: 'post',
                data: {
                    id_siswa: id,
                    id_kelas: <?= $pil_id; ?>
                },
                success: function (result) {
                    let data = JSON.parse(result);

                    $('#t-rombel-baru').append(row);
                    sortTable($('#t-rombel-baru'), 'asc');
                    $('#checkbox-all-2').prop('checked', false);
                    notif('Berhasil update data!', 'suc');
                    console.log(data);
                },
                error: function (data) {
                    notif("Gagal Memindahkan Siswa!", 'err');
                    console.log(data);
                }
            });
        }
    });

    let id_kel_baru = "";
    let rec = new Array();
    let id_siswa_baru = new Array();
    let row_baru = new Array();

    $('#btn-pindahkan').click(function () {
        var pil2 = $('input[name="id_siswa_baru[]"]:checked').each(function () {
            id_inp = $(this).attr('id').split("-");
            id_kel_baru = tr_def.find('input[name="id_kelas_lama[]"]').val();//mengambil baris pertama(bukan header table) pada table Rombel Lama
            tr2 = $("table#t-rombel-baru tr#row1-" + id_inp[1]);
            val = tr2.find("td:eq(0)");
            nama = tr2.find("td:eq(1)").text();
            nisn = tr2.find("td:eq(2)").text();
            id_siswa_baru.push($(this).val());
            rec.push(id_inp[1]);
            // console.log(id_kel_baru);

            //make a new row
            html = '<tr id="row2-' + id_inp[1] + '"><td class="text-center"><div class="custom-checkbox custom-control"><input type="checkbox" data-checkboxes="mygroup2"class="custom-control-input" name="id_siswa_lama[]" id="cb2-' + id_inp[1] + '"  value="id_siswa"><label for="cb2-' + id_inp[1] + '"class="custom-control-label">&nbsp;</label></div></td><td>' + nama + '</td><td class="text-center">' + nisn + '</td><td class="text-center">' + kelas_lama + '<input type="hidden" id="id-kelas-lama-' + id_inp[1] + '"value="' + id_kel_baru + '</td></tr>';
            row_baru.push($(html)); //create row
        });

        if (!id_kel_baru) {//jika tidak ditemukan daftar siswa pada tabel rombel lama
            $.ajax({
                url: "<?= base_url('/' . bin2hex('admin/get_kelas')); ?>",
                type: 'post',
                data: {
                    id_kelas: <?= $pil_id; ?>
                },
                success: function (result) {
                    let data = JSON.parse(result);
                    kelas_lama = data.kelas;
                    id_kel_baru = data.id_kelas;
                    send_data(id_siswa_baru, id_kel_baru);
                },
                error: function (data) {
                    notif("Kelas lama tidak ditemukan!", 'err');
                    console.log(data);
                }
            });
        } else {
            send_data(id_siswa_baru, id_kel_baru);
        }

    });

    function send_data(id_siswa_baru, id_kel_baru) {
        if (id_kel_baru && id_siswa_baru) {
            $.ajax({
                url: "<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('update-siswa-kelas')); ?>",
                type: 'post',
                data: {
                    id_siswa: id_siswa_baru,
                    id_kelas: id_kel_baru
                },
                success: function (result) {
                    if (result) {
                        let data = JSON.parse(result);
                        for (let i = 0; i < rec.length; i++) {
                            //remove row from table
                            $("table#t-rombel-baru tr#row1-" + rec[i]).remove();

                        }
                        $('#t-rombel-lama').append(row_baru);
                        sortTable($('#t-rombel-lama'), 'asc');
                        $('#checkbox-all').prop('checked', false);
                        notif('Berhasil update data!', 'suc');
                        console.log(data);
                    }
                },
                error: function (data) {
                    notif("Gagal Memindahkan Siswa!", 'err');
                    console.log(data);
                }
            });
        } else {
            notif("Gagal Memindahkan Siswa!", 'err');
        }
    }

    function sortTable(table, order) {
        var asc = order === 'asc',
            tbody = table.find('tbody');

        tbody.find('tr').sort(function (a, b) {
            if (asc) {
                return $('td:nth-child(2)', a).text().localeCompare($('td:nth-child(2)', b).text());
            } else {
                return $('td:nth-child(2)', b).text().localeCompare($('td:nth-child(2)', a).text());
            }
        }).appendTo(table);
    }
</script>
<?= $this->endSection() ?>