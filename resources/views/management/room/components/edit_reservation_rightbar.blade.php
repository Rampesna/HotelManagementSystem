<div id="edit_reservation_rightbar" style="width: 1200px" class="offcanvas offcanvas-right p-10">

    <form id="editReservationForm">
        <input type="hidden" id="editing_reservation_deleting_customer_id">
        <input type="hidden" id="selected_reservation_id">
        <input type="hidden" id="selected_reservation_status_id">
        <input type="hidden" id="selected_reservation_room_id">
        <div class="offcanvas-content">
            <div class="offcanvas-wrapper mb-5 scroll-pull">
                <div class="row">
                    <div class="col-xl-10">
                        <h5>Rezervasyon Düzenle</h5>
                    </div>
                </div>
                <hr>
                <div class="row mt-6">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="company_id_edit">Firma Seçimi</label>
                            <select id="company_id_edit" class="form-control">
                                <optgroup label="">
                                    <option value="" selected>Seçim Yok</option>
                                </optgroup>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="customer_name_edit">Rezervasyonu Yaptıran Müşteri Adı</label>
                            <div class="input-group" id="editReservationCustomerSearchBox">
                                <input type="text" id="customer_name_edit" name="customer_name_edit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="start_date_edit">Geliş Tarihi</label>
                            <input type="datetime-local" class="form-control" id="start_date_edit">
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="end_date_edit">Gidiş Tarihi</label>
                            <input type="datetime-local" class="form-control" id="end_date_edit">
                        </div>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="room_type_id_edit">Oda Tipi</label>
                            <div class="input-group" id="editReservationRoomTypeSearchBox">
                                <select required class="selectpicker form-control" id="room_type_id_edit" data-live-search="true">
                                    @foreach($roomTypes as $roomType)
                                        <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="pan_type_id_edit">Pan Tipi</label>
                            <div class="input-group" id="editReservationPanTypeSearchBox">
                                <select required class="selectpicker form-control" id="pan_type_id_edit" data-live-search="true">
                                    @foreach($panTypes as $panType)
                                        <option value="{{ $panType->id }}">{{ $panType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="room_id_edit">Oda Seçimi</label>
                            <div class="input-group" id="editReservationRoomSearchBox">
                                <select required class="selectpicker form-control" id="room_id_edit" data-live-search="true">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="room_use_type_id_edit">Oda Kullanım Tipi</label>
                            <select id="room_use_type_id_edit" class="form-control">
                                @foreach($roomUseTypes as $roomUseType)
                                    <option value="{{ $roomUseType->id }}">{{ $roomUseType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-9"></div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="price_edit">Oda Ücreti</label>
                            <input type="text" id="price_edit" class="form-control decimal">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label for="description_edit">Ek Notlar</label>
                        <textarea class="form-control" id="description_edit" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="offcanvas-wrapper mb-5 scroll-pull">
                <div class="row">
                    <div class="col-xl-8">
                        <h5>Misafir Listesi
                            <div class="dropdown dropdown-inline">
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ml-2 fa fa-plus-circle text-success cursor-pointer"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-left" style="width: 250px">
                                    <ul class="navi navi-hover">

                                        <li class="navi-item">
                                            <a data-toggle="modal" data-target="#EditReservationCreateCustomerModal" class="navi-link cursor-pointer">
                                                <span class="navi-icon">
                                                    <i class="fa fa-plus-circle"></i>
                                                </span>
                                                <span class="navi-text">Yeni Oluştur</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a data-toggle="modal" data-target="#EditReservationSelectCustomerModal" class="navi-link cursor-pointer">
                                                <span class="navi-icon">
                                                    <i class="fas fa-user-plus"></i>
                                                </span>
                                                <span class="navi-text">Var Olan Müşterilerden Seç</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </h5>
                    </div>
                    <div class="col-xl-4 text-right">
                        <i class="fa fa-trash text-danger cursor-pointer" id="reservationEditCustomersDeleteRowButton"></i>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-12">
                        <table class="table" id="reservationEditCustomers">
                            <thead>
                            <tr>
                                <th>Adı</th>
                                <th>Soyadı</th>
                                <th>Ünvan</th>
                                <th>Uyruk</th>
                                <th>Cinsiyet</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="offcanvas-footer">
                <div class="row">
                    <div class="col-xl-12 text-right">
                        <button type="button" class="btn btn-success" id="updateReservationButton">Güncelle</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
