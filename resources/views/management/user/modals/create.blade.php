<div class="modal fade" id="CreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:900px;">
        <div class="modal-content" style="margin-top: 15%">
            <div class="modal-header">
                <h5 class="modal-title">Kullanıcı Oluştur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="name_create">Ad Soyad</label>
                            <input type="text" name="name_create" id="name_create" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="email_create">E-posta Adresi</label>
                            <input type="text" name="email_create" id="email_create" class="form-control email-input-mask">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="phone_number_create">Telefon Numarası</label>
                            <input type="text" name="phone_number_create" id="phone_number_create" class="form-control mobile-phone-number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="identification_number_create">Kimlik Numarası</label>
                            <input type="text" name="identification_number_create" id="identification_number_create" class="form-control" maxlength="11">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="password_create">Kullanıcı Şifresi</label>
                            <input type="password" name="password_create" id="password_create" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="activate_type_create">Hesap Aktivasyonu</label>
                            <select id="activate_type_create" name="activate_type_create" class="form-control">
                                <option value="0" selected>Otomatik Aktif Et</option>
                                <option value="1">Mail Aktivasyonu</option>
                                <option value="2">Yönetici Aktivasyonu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="role_id_create">Kullanıcı Rolü</label>
                            <select class="form-control" name="role_id_create" id="role_id_create">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="user_create">Oluştur</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>
