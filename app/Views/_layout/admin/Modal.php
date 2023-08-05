<!-- Modal update Status periode -->
<div class="modal fade" id="m-act" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Perbaharui Status Periode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form
                action="<?= base_url('/' . bin2hex('admin') . '/' . bin2hex('data-periode') . '/' . bin2hex('set-status')) ?>"
                method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" required id="inp-u-status">
                    Perubahan status periode, Harus dilakukan ketika tahun ajaran sebelumnya telah berakhir. "Aktifkan"
                    periode terpilih?
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Aktifkan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>