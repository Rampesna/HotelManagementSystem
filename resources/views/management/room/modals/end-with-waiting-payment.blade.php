<div class="modal fade" id="EndWithWaitingPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="EndWithWaitingPaymentForm">
                <div class="modal-header">
                    <h5 class="modal-title">Rezervasyonu Sonlandır</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="end_with_waiting_payment_reservation_id">
                    <p>
                        Rezervasyonu bekleyen bakiye ile sonlandırmak istediğinize emin misiniz?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="endWithWaitingPaymentButton">Sonlandır</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
