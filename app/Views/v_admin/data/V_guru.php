<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 id="card-title">Data Guru</h4>
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

                ?>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    No.
                                </th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Gelar</th>
                                <th class="text-center">Akses</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($guru) && count($guru) > 0) {
                                foreach ($guru as $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 7%">
                                            <?= $i++; ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <button class="btn btn-warning" data-toggle="tooltip" title="Edit Guru"
                                                onclick="edit('<?= $row['id_guru'] ?>','<?= $row['nip'] ?>','<?= $row['nama_guru'] ?>','<?= $row['gelar_guru'] ?>','<?= $row['level_login'] ?>','<?= $row['status_guru'] ?>');">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger" title="Hapus Guru"
                                                onclick="del('<?= $row['id_guru'] ?>','<?= $row['nama_guru'] ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td class="text-center" style="width: 13%">
                                            <?= empty($row['nip']) ? "-" : $row['nip'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nama_guru'] ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <?= $row['gelar_guru'] ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <?= $row['level_login'] ?>
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <button
                                                class="btn btn-<?= ($row['status_guru'] == 'aktif') ? 'success' : 'secondary'; ?>"
                                                onclick="set_act_guru('<?= $row['id_guru'] ?>','<?= $row['status_guru'] ?>')"
                                                data-toggle="tooltip" title="Klik untuk Edit">
                                                <?= strtoupper($row['status_guru']); ?>
                                            </button>
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
                <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('guru') . '/' . bin2hex('add')) ?>"
                    method="post" onsubmit="return confirm('Simpan data?')">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Ex:123">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Ex:Midas" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Gelar</label>
                            <input type="text" name="gelar" class="form-control" placeholder="Ex:S.Pd.">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Akses</label>
                            <select name="akses" class="form-control" required>
                                <option value="GR">Guru</option>
                                <option value="KS">Kepala Sekolah</option>
                                <option value="ADM">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" id="btn-cancel">Batal</button>
                    </div>
                </form>
            </div>
            <div class="card-body" id="f-edit" style="display:none;">
                <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('guru') . '/' . bin2hex('update')) ?>"
                    method="post" onsubmit="return confirm('Simpan data?')">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" id="e-id" required>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Ex:123" id="e-nip">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Ex:Midas" id="e-nama"
                                required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Gelar</label>
                            <input type="text" name="gelar" class="form-control" placeholder="Ex:S.Pd." id="e-gelar">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Akses</label>
                            <select name="akses" class="form-control" required id="e-level">
                                <option value="GR">Guru</option>
                                <option value="KS">Kepala Sekolah</option>
                                <option value="ADM">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" id="btn-cancel-edit">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('guru') . '/' . bin2hex('delete')) ?>"
                    method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" id="h-id" required>
                    <center>
                        <h2 id="h-nama"></h2>
                    </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal update Status Guru -->
<div class="modal fade" id="m-act-guru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Perbaharui Status Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('guru') . '/' . bin2hex('set-status')) ?>"
                method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" required id="inp-u-id-guru">
                    <input type="hidden" name="status" required id="inp-u-status-guru">
                    Perubahan status guru dapat mempengaruhi Login dan Presensi Siswa. " <b id="u-stat"></b> "
                    guru terpilih?
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary" id="btn-submit"></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function up_first(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    $('#btn-import').click(function () {
        $('#add-modal').appendTo('body').modal('show');
    });
    $('#btn-add').click(function () {
        $('#tbl-data').hide('slow');
        $('#group-btn').hide('slow');
        $('#f-add').show('slow');
        $('#card-title').text('Tambah Data Guru');
    });
    $('#btn-cancel').click(function () {
        $('#f-add').hide('slow');
        $('#group-btn').show('slow');
        $('#tbl-data').show('slow');
        $('#card-title').text('Data Guru');
    });

    function edit(id, nip, nama, gelar, level, status) {
        $('#tbl-data').hide('slow');
        $('#group-btn').hide('slow');
        $('#e-id').val(id);
        $('#e-nip').val(nip);
        $('#e-nama').val(nama);
        $('#e-gelar').val(gelar);
        $('#e-level').val(level);
        $('#f-edit').show('slow');
        $('#card-title').text('Update Data Guru');
    }
    $('#btn-cancel-edit').click(function () {
        $('#f-edit').hide('slow');
        $('#group-btn').show('slow');
        $('#tbl-data').show('slow');
        $('#card-title').text('Data Guru');
    });

    function set_act_guru(id, status) {
        let stat = status;
        if (stat === "aktif") {
            stat = "non-aktif"
        } else {
            stat = "aktif"
        }
        $('#inp-u-id-guru').val(id);
        $('#inp-u-status-guru').val(stat);
        $('#btn-submit').text(up_first(stat) + "kan");
        $('#u-stat').text(up_first(stat) + "kan");
        console.log("here");
        $('#m-act-guru').appendTo("body").modal('show');
    }

    function del(id, nama) {
        $('#h-id').val(id);
        $('#h-nama').text(nama);
        $('#modal-delete').appendTo('body').modal('show');
    }
</script>
<?= $this->endSection() ?>