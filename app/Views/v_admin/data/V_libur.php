<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="card-title">Hari Libur Nasional</h4>
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
                                <th class="text-center">Tanggal Libur</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($libur) && count($libur) > 0):
                                foreach ($libur as $row):
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 5%">
                                            <?= $i++ . "."; ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Libur"
                                                onclick="update_libur('<?= $row['id_libur'] ?>','<?= date('d/m/Y', strtotime($row['tgl_awal'])) . ' - ' . date('d/m/Y', strtotime($row['tgl_akhir'])); ?>','<?= $row['ket_libur'] ?>')">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus Libur"
                                                onclick="hapus('<?= $row['id_libur'] ?>','<?= date('d M Y', strtotime($row['tgl_awal'])) . ' - ' . date('d M Y', strtotime($row['tgl_akhir'])); ?>','<?= $row['ket_libur'] ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td class="text-center" style="width:20%;">
                                            <?php if ($row['tgl_awal'] == $row['tgl_akhir']): ?>
                                                <span class="badge badge-secondary">
                                                    <?= date("d M Y", strtotime($row['tgl_awal'])) ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">
                                                    <?= date("d M Y", strtotime($row['tgl_awal'])) . " - " . date("d M Y", strtotime($row['tgl_akhir'])); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="" style="width: 65%">
                                            <?= $row['ket_libur'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body" id="f-add" style="display:none;">
                <?= csrf_field(); ?>
                <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('add-libur')) ?>" method="post"
                    onsubmit="return cek_isi()">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="tgl">Tanggal Libur (bulan/hari/tahun)</label>
                            <input type="text" class="form-control daterange-cus" name="tgl" value=""
                                placeholder="Ex:<?= date('Y') ?>" id="tgl" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="ket">Keterangan</label>
                            <textarea id="ket" name="ket" class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" id="btn-cancel">Batal</button>
                    </div>
                </form>
            </div>
            <div class="card-body" id="f-update" style="display:none;">
                <?= csrf_field(); ?>
                <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('update-libur')) ?>" method="post">
                    <input type="hidden" name="id" id="u-id" required>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="u-tgl">Tanggal Libur (bulan/hari/tahun)</label>
                            <input type="text" class="form-control daterange-cus" name="tgl" value=""
                                placeholder="Ex:<?= date('Y') ?>" id="u-tgl" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="u-ket">Keterangan</label>
                            <textarea id="u-ket" name="ket" class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" onclick="batal()">Batal</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="delete-modal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('delete-libur')) ?>"
                        method="post">
                        <div class="modal-body">
                            <input type="hidden" name="id" class="form-control" required id="d-id">
                            <center>
                                <h3 id="d-tgl"></h3>
                                <h3 id="d-ket"></h3>
                            </center>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="submit" class="btn btn-primary">Ya</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.daterange-cus').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rabu', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                firstDay: 0
            },
            drops: 'down',
            opens: 'right',
            autoApply: false,
        });
    });
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

    function batal() {
        $('#f-update').hide('slow');
        $('#btn-add').show('slow');
        $('#tbl-data').show('slow');
    }
    function set_date(date, options, separator) {
        var temp_date = date.split("/");
        if (options != "m/d/y") {
            return temp_date[0] + "/" + temp_date[1] + "/" + temp_date[2];
        }
        return temp_date[1] + "/" + temp_date[0] + "/" + temp_date[2];
    }

    //update libur
    function update_libur(id, tgl, ket) {
        $('#u-id').val(id);
        $('#u-tgl').val(tgl);
        $('#u-ket').text(ket);
        $('#tbl-data').hide('slow');
        $('#btn-add').hide('slow');
        $('#f-update').show('slow');
        var x = tgl.split(" - ");
        $('#u-tgl').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rabu', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                autoApply: false,
                firstDay: 0
            },
            drops: 'down',
            opens: 'right',
            startDate: set_date(x[0], "m/d/y", "/"),
            endDate: set_date(x[1], "m/d/y", "/")
        });
    }

    function hapus(id, tgl, ket) {
        $('#d-id').val(id);
        $('#d-tgl').text(tgl);
        $('#d-ket').text(ket);
        $('#delete-modal').appendTo('body').modal('show');
    }
</script>
<?= $this->endSection() ?>