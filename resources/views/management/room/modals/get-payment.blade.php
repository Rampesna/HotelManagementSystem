<div class="modal fade" id="GetPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" id="checkoutRepeater">
            <form id="GetPaymentForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ödeme Al<i class="fa fa-plus-circle text-success cursor-pointer ml-5" data-repeater-create></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div data-repeater-list="checkouts">
                        <div class="row checkoutRepeaterList" data-repeater-item>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label for="payment_type_id">Ödeme Türü</label>
                                    <select id="payment_type_id" name="payment_type_id" class="form-control paymentTypeSelector" required>
                                        @foreach($paymentTypes as $paymentType)
                                            <option value="{{ $paymentType->id }}">{{ $paymentType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label for="price">Alınan Miktar</label>
                                    <input id="price" name="price" type="text" class="form-control decimal priceSelector" required>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="form-group">
                                    <label for="description">Açıklama</label>
                                    <input id="description" name="description" type="text" class="form-control descriptionSelector" required>
                                </div>
                            </div>
                            <div class="col-xl-1">
                                <i class="fa fa-times-circle text-danger cursor-pointer mt-11" data-repeater-delete></i>
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
