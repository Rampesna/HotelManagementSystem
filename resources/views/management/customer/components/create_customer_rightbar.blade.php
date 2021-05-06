<div id="create_customer_rightbar" style="width: 800px" class="offcanvas offcanvas-right p-10">
    <form id="createCustomerForm">
        <input type="hidden" id="create_customer_rightbar_toggle">
        <input type="hidden" id="creating_customer_id">
        <div class="offcanvas-content">
            <div class="offcanvas-wrapper mb-5 scroll-pull">
                <div class="row">
                    <div class="col-xl-10">
                        <h5>Müşteri Bilgilerini Düzenle</h5>
                    </div>
                </div>
                <hr>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Firma: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <select class="form-control" id="creating_customer_company_id">
                                <option selected hidden disabled></option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->title }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Ad: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_customer_name">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Soyad: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_customer_surname">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Ünvan: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_customer_title">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Telefon Numarası: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control mobile-phone-number" id="creating_customer_phone_number">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">E-posta Adresi: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control email-input-mask" id="creating_customer_email">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Uyruk: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <select class="form-control" id="creating_customer_nationality_id">
                                @foreach($nationalities as $nationality)
                                    <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Cinsiyet: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <select class="form-control" id="creating_customer_gender">
                                <option value="1">Erkek</option>
                                <option value="0">Kadın</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Evlilik Durumu: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <select class="form-control" id="creating_customer_marriage">
                                <option value="1">Evli</option>
                                <option value="0">Bekar</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Kimlik Türü: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <select class="form-control" id="creating_customer_identity_type_id">
                                @foreach($identityTypes as $identityType)
                                    <option value="{{ $identityType->id }}">{{ $identityType->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Kimlik Numarası: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" maxlength="11" class="form-control onlyNumber" pattern="[0-9]*" id="creating_customer_identity_number">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Kimlik Geçerlilik Tarihi: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="date" class="form-control" id="creating_customer_identity_expiration_date">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Pasaport Numarası: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_customer_passport_number">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Doğum Tarihi: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="date" class="form-control" id="creating_customer_birth_date">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Doğum Yeri: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_customer_birth_place">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Anne Adı: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_customer_mother_name">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Baba Adı: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_customer_father_name">
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="offcanvas-footer">
                <div class="row">
                    <div class="col-xl-12 text-right">
                        <button type="button" class="btn btn-success" id="createCustomerButton">Oluştur</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
