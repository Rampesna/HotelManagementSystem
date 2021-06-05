<div class="modal fade" id="EditReservationCreateCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="editReservationCreateCustomerForm">
                <div class="modal-header">
                    <h5 class="modal-title">Misafir Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_name">Ad *</label>
                                <input type="text" id="edit_reservation_customer_create_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_surname">Soyad *</label>
                                <input type="text" id="edit_reservation_customer_create_surname" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_phone_number">Telefon Numarası *</label>
                                <input type="text" id="edit_reservation_customer_create_phone_number" class="form-control mobile-phone-number">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_gender">Cinsiyet *</label>
                                <select class="form-control" id="edit_reservation_customer_create_gender">
                                    <option value="1">Erkek</option>
                                    <option value="0">Kadın</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_title">Ünvan</label>
                                <input type="text" class="form-control" id="edit_reservation_customer_create_title">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_nationality_id">Uyruk *</label>
                                <select class="form-control" id="edit_reservation_customer_create_nationality_id">
                                    @foreach($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_marriage">Evlilik Durumu</label>
                                <select id="edit_reservation_customer_create_marriage" class="form-control">
                                    <option value="1">Evli</option>
                                    <option value="0">Bekar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_identity_type_id">Kimlik Türü *</label>
                                <select id="edit_reservation_customer_create_identity_type_id" class="form-control">
                                    @foreach($identityTypes as $identityType)
                                        <option value="{{ $identityType->id }}">{{ $identityType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_identity_number">Kimlik Numarası *</label>
                                <input type="text" class="form-control" id="edit_reservation_customer_create_identity_number" maxlength="11">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_identity_expiration_date">Kimlik Geçerlilik Tarihi</label>
                                <input type="date" id="edit_reservation_customer_create_identity_expiration_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_birth_date">Doğum Tarihi</label>
                                <input type="date" class="form-control" id="edit_reservation_customer_create_birth_date">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_birth_place">Doğum Yeri</label>
                                <input type="text" class="form-control" id="edit_reservation_customer_create_birth_place">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_mother_name">Anne Adı</label>
                                <input type="text" class="form-control" id="edit_reservation_customer_create_mother_name">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="edit_reservation_customer_create_father_name">Baba Adı</label>
                                <input type="text" class="form-control" id="edit_reservation_customer_create_father_name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="editReservationCreateCustomerButton">Oluştur</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
