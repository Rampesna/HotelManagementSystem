<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:500px;">
        <div class="modal-content" style="margin-top: 50%">
            <div class="modal-header">
                <h5 class="modal-title">Uyarı!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="deleted_user_id" id="deleted_user_id">
                <p>
                    Kullanıcıyı silmek istediğinizden emin misiniz?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="delete_user">Sil</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>
