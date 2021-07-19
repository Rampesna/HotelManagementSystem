<div class="modal fade" id="GetPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="GetPaymentForm">
                <div class="modal-header">
                    <h5 class="modal-title">Ödeme Al</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="waiting_payment_id">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="paid_date">Ödemenin Alındığı Tarih</label>
                                <input type="datetime-local" class="form-control" id="paid_date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="getPaymentButton">Ödeme Al</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
