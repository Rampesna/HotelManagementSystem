<div class="modal fade" id="TransferExtrasAndSafeActivitiesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="TransferExtrasAndSafeActivitiesForm">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer Et</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="transfer_from">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="transfer_to">Transfer Edilecek Oda</label>
                                <select class="form-control selectpicker" id="transfer_to">

                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="transfer_safe_activities">Transfer Edilecek Kalemleri Seçiniz</label>
                                <select class="form-control selectpicker" id="transfer_safe_activities" multiple>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="transferExtrasAndSafeActivitiesButton">Transfer Et</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
