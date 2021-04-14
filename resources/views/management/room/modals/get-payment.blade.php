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
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="payment_type_id">Ödeme Türü</label>
                                <select id="payment_type_id" class="form-control">
                                    @foreach($paymentTypes as $paymentType)
                                        <option value="{{ $paymentType->id }}">{{ $paymentType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="price">Alınan Miktar</label>
                                <input id="price" type="text" class="form-control decimal">
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
