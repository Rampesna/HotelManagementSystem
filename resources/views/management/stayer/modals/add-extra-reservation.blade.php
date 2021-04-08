<div class="modal fade" id="AddExtraReservationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="AddExtraReservationForm">
                <div class="modal-header">
                    <h5 class="modal-title">Ekstra Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="create_extra_extra_id">Ekstrayı Seçiniz</label>
                                <select id="create_extra_extra_id" class="form-control">
                                    @foreach($extras as $extra)
                                        <option value="{{ $extra->id }}">{{ $extra->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="create_extra_price">Ücretini Giriniz</label>
                                <input type="text" class="form-control" id="create_extra_price">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="create_extra_date">Tarih</label>
                                <input type="datetime-local" id="create_extra_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="create_extra_description">Açıklama</label>
                                <textarea id="create_extra_description" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="addExtraReservationButton">Ekle</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
