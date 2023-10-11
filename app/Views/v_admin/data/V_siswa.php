<?= $this->extend('v_admin/Main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Data Peserta Didik</h4>
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
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    No.
                                </th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">FOTO</th>
                                <th class="text-center">NIS</th>
                                <th class="text-center">NISN</th>
                                <th class="text-center">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (isset($siswa) && count($siswa) > 0) {
                                foreach ($siswa as $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 7%">
                                            <?= $i++; ?>
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <button class="btn btn-warning" data-toggle="tooltip" title="Edit Siswa"
                                                onclick="update_siswa('<?= $row['id_siswa'] ?>','<?= $row['nis'] ?>','<?= $row['nisn'] ?>','<?= $row['nama'] ?>','<?= $row['jk'] ?>','<?= $row['tmp_lahir'] ?>','<?= $row['tgl_lahir'] ?>','<?= $row['alamat_siswa'] ?>','<?= $row['ayah_kandung'] ?>','<?= $row['ibu_kandung'] ?>','<?= $row['p_ayah'] ?>','<?= $row['p_ibu'] ?>','<?= $row['alamat_ortu'] ?>','<?= $row['nama_wali'] ?>','<?= $row['alamat_wali'] ?>')">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger" data-toggle="tooltip" title="Hapus Siswa"
                                                onclick="hapus('<?= $row['id_siswa'] ?>','<?= $row['nama'] ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td class="text-center" style="width: 13%">
                                            <img src="<?= base_url() ?>/public/assets/img/<?php if ($row['pic_siswa']):
                                                  echo "siswa/" . $row['pic_siswa'];
                                              else: ?>default.png<?php endif; ?>"
                                                class="user-img mr-2" alt="" width="100px" data-toggle="tooltip"
                                                title="Klik Untuk Merubah"
                                                onclick="update_foto(this,'<?= $row['id_siswa'] ?>')">
                                        </td>
                                        <td class="text-center" style="width: 13%">
                                            <?= $row['nis'] ?>
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <?= $row['nisn'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nama'] ?>
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
                <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('siswa') . '/' . bin2hex('add')) ?>"
                    method="post" onsubmit="return confirm('Simpan Data?')">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inp-nis">NIS</label>
                            <input type="number" min="0" name="nis" value="0" class="form-control" id="inp-nis"
                                placeholder="1234">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inp-nisn">NISN</label>
                            <input type="number" min="0" name="nisn" value="0" class="form-control" id="inp-nisn"
                                placeholder="1234">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inp-nama">Nama Siswa</label>
                            <input type="text" name="nama" class="form-control" id="inp-nama" placeholder="Midas"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Jenis Kelamin</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="jk" type="radio" id="jk-l" value="L" checked>
                                <label class="form-check-label" for="jk-l">Laki - Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="jk" type="radio" id="jk-p" value="P">
                                <label class="form-check-label" for="jk-p">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inp-tl">Tempat Lahir</label>
                            <input type="text" name="tl" class="form-control" id="inp-tl" placeholder="Situbondo"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inp-tgl">Tanggal Lahir</label>
                            <input type="date" name="tgl" class="form-control" id="inp-tgl" placeholder="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inp-alamat">Alamat Siswa</label>
                            <textarea class="form-control" name="alamat" id="inp-alamat" cols="100%" rows="5"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inp-nb">Nama Bapak</label>
                            <input type="text" name="bapak" class="form-control" id="inp-nb" placeholder="-">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inp-ib">Nama Ibu</label>
                            <input type="text" name="ibu" class="form-control" id="inp-ib" placeholder="-" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inp-pb">Pekerjaan Bapak</label>
                            <input type="text" name="p_bapak" class="form-control" id="inp-pb" placeholder="-">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inp-pi">Pekerjaan Ibu</label>
                            <input type="text" name="p_ibu" class="form-control" id="inp-pi" placeholder="-">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inp-alamat-o">Alamat Orang Tua</label>
                            <textarea class="form-control" name="alamat_o" id="inp-alamat-o" cols="100%" rows="5"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inp-wl">Nama Wali</label>
                            <input type="text" name="wali" class="form-control" id="inp-wl" placeholder="-">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inp-alamat-wl">Alamat Wali</label>
                            <textarea class="form-control" name="alamat_wl" id="inp-alamat-wl" cols="100%"
                                rows="5"></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" id="btn-cancel">Batal</button>
                    </div>
                </form>
            </div>
            <div class="card-body" id="f-update" style="display:none;">
                <form
                    action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('siswa') . '/' . bin2hex('update')) ?>"
                    method="post" onsubmit="return confirm('Simpan Data?')">
                    <div class="form-row">
                        <input type="hidden" min="0" name="id" class="form-control" id="u-inp-id" required>
                        <div class="form-group col-md-6">
                            <label for="u-inp-nis">NIS</label>
                            <input type="number" min="0" name="nis" class="form-control" id="u-inp-nis"
                                placeholder="1234">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="u-inp-nisn">NISN</label>
                            <input type="number" min="0" name="nisn" class="form-control" id="u-inp-nisn"
                                placeholder="1234">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="u-inp-nama">Nama Siswa</label>
                            <input type="text" name="nama" class="form-control" id="u-inp-nama" placeholder="Midas"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Jenis Kelamin</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="jk" type="radio" id="u-jk-l" value="L">
                                <label class="form-check-label" for="u-jk-l">Laki - Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="jk" type="radio" id="u-jk-p" value="P">
                                <label class="form-check-label" for="u-jk-p">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="u-inp-tl">Tempat Lahir</label>
                            <input type="text" name="tl" class="form-control" id="u-inp-tl" placeholder="Situbondo"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="u-inp-tgl">Tanggal Lahir</label>
                            <input type="date" name="tgl" class="form-control" id="u-inp-tgl" placeholder="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="u-inp-alamat">Alamat Siswa</label>
                            <textarea class="form-control" name="alamat" id="u-inp-alamat" cols="100%" rows="5"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="u-inp-nb">Nama Bapak</label>
                            <input type="text" name="bapak" class="form-control" id="u-inp-nb" placeholder="-">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="u-inp-ib">Nama Ibu</label>
                            <input type="text" name="ibu" class="form-control" id="u-inp-ib" placeholder="-" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="u-inp-pb">Pekerjaan Bapak</label>
                            <input type="text" name="p_bapak" class="form-control" id="u-inp-pb" placeholder="-">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="u-inp-pi">Pekerjaan Ibu</label>
                            <input type="text" name="p_ibu" class="form-control" id="u-inp-pi" placeholder="-">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="u-inp-alamat-o">Alamat Orang Tua</label>
                            <textarea class="form-control" name="alamat_o" id="u-inp-alamat-o" cols="100%" rows="5"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="u-inp-wl">Nama Wali</label>
                            <input type="text" name="wali" class="form-control" id="u-inp-wl" placeholder="-">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="u-inp-alamat-wl">Alamat Wali</label>
                            <textarea class="form-control" name="alamat_wl" id="u-inp-alamat-wl" cols="100%"
                                rows="5"></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" onclick="cancel()">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-modal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Peserta Didik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('import') . '/' . bin2hex('siswa')) ?>"
                method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>File Excel Siswa (.xls/.xlsx)</label>
                        <input type="file" name="excel" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Proses</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
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
            <form action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('siswa') . '/' . bin2hex('delete')) ?>"
                method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" class="form-control" required id="d-id">
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" name="nama" class="form-control" disabled id="d-nama">
                    </div><br>
                    <center>
                        <h4>Seluruh data yang berkaitan dengan Siswa diatas akan terhapus. Hapus data?</h4>
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


<div class="modal fade" id="update-foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form
                action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('upload_foto') . '/' . bin2hex('siswa')) ?>"
                method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="u-id-siswa" required>
                <div class="modal-body">
                    <center>
                        <img src="<?= base_url() ?>/public/assets/img/default.png" class="user-img mr-2" alt=""
                            width="200px" id="foto-dinamis">
                    </center>
                    <center>
                        <input type='file' class="form-control" name="foto" id="upload"
                            onchange="document.getElementById('foto-dinamis').src = window.URL.createObjectURL(this.files[0])"
                            required accept="image/*" />
                    </center>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // $(function () {
    // });
    $('#btn-import').click(function () {
        $('#add-modal').appendTo('body').modal('show');
    });
    $('#btn-add').click(function () {
        $('#tbl-data').hide('slow');
        $('#group-btn').hide('slow');
        $('#f-add').show('slow');
    });
    $('#btn-cancel').click(function () {
        $('#f-add').hide('slow');
        $('#group-btn').show('slow');
        $('#tbl-data').show('slow');
    });

    function update_siswa(id, nis, nisn, nama, jk, tmp, tgl, addr, ayah, ibu, p_ayah, p_ibu, addr_ort, wali, addr_wl) {
        $('#tbl-data').hide('slow');
        $('#group-btn').hide('slow');
        $('#f-update').show('slow');
        $('#u-inp-id').val(id);
        $('#u-inp-nis').val(nis);
        $('#u-inp-nisn').val(nis);
        $('#u-inp-nama').val(nama);
        if (jk == 'L') {
            $('#u-jk-l').prop('checked', true);
        } else {
            $('#u-jk-p').prop('checked', true);
        }
        $('#u-inp-tl').val(tmp);
        $('#u-inp-tgl').val(tgl);
        $('#u-inp-alamat').val(addr);
        $('#u-inp-nb').val(ayah);
        $('#u-inp-ib').val(ibu);
        $('#u-inp-pb').val(p_ayah);
        $('#u-inp-pi').val(p_ibu);
        $('#u-inp-alamat-o').val(addr_ort);
        $('#u-inp-wl').val(wali);
        $('#u-inp-alamat-wl').val(addr_wl);
    }

    function cancel() {
        $('#f-update').hide('slow');
        $('#group-btn').show('slow');
        $('#tbl-data').show('slow');
    }

    function hapus(id, nama) {
        $('#d-id').val(id);
        $('#d-nama').val(nama);
        $('#delete-modal').appendTo('body').modal('show');
    }
    function update_foto(e, id) {
        $("#foto-dinamis").attr("src", e.src);
        $("#upload").val("");
        $("#u-id-siswa").val(id);
        $('#update-foto').appendTo('body').modal('show');
    }
</script>
<?= $this->endSection() ?>