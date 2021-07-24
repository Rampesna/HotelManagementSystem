<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:900px;">
        <div class="modal-content" style="margin-top: 15%">
            <div class="modal-header">
                <h5 class="modal-title">Kullanıcıyı Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <input type="hidden" id="id_edit">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="name_edit">Ad Soyad</label>
                            <input type="text" id="name_edit" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="email_edit">E-posta Adresi</label>
                            <input type="text" id="email_edit" class="form-control email-input-mask">
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="phone_number_edit">Telefon Numarası</label>
                            <input type="text" id="phone_number_edit" class="form-control mobile-phone-number">
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="identification_number_edit">Kimlik Numarası</label>
                            <input type="text" id="identification_number_edit" class="form-control" maxlength="11">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="role_id_edit">Kullanıcı Rolü</label>
                            <select class="form-control" id="role_id_edit">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="password_edit">Kullanıcı Şifresi</label>
                            <input type="password" id="password_edit" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="UpdateButton">Güncelle</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>
