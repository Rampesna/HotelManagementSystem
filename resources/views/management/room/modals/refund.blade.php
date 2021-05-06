<div class="modal fade" id="RefundModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="RefundForm">
                <div class="modal-header">
                    <h5 class="modal-title">Geri Ödeme (İade)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="refund_reservation_id">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="refund_price">İade Edilecek Tutar</label>
                                <input type="text" class="form-control decimal" id="refund_price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="refundButton">İade Et</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
