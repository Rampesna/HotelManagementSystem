<div class="modal fade" id="DiscountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="DiscountForm">
                <div class="modal-header">
                    <h5 class="modal-title">İndirim Uygula</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="discount_reservation_id">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="discount_price">İndirim Yapılacak Tutar</label>
                                <input type="text" class="form-control decimal" id="discount_price">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="discount_description">İndirim Açıklaması</label>
                                <textarea id="discount_description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="discountButton">İndirim Uygula</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
