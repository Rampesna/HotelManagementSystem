<div id="create_reservation_rightbar" style="width: 1200px" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7">

    </div>
    <div class="offcanvas-content">
        <div class="offcanvas-wrapper mb-5 scroll-pull">
            <div class="row">
                <div class="col-xl-10">
                    <h5>Yeni Rezervasyon Oluştur</h5>
                </div>
            </div>
            <hr>
            <div class="row mt-6">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="customer_id_create">Müşteri Seçiniz</label>
                        <div class="input-group" id="createReservationCustomerSearchBox">
                            <select required class="selectpicker form-control" id="customer_id_create" data-live-search="true">

                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="start_date_create">Geliş Tarihi</label>
                        <input type="datetime-local" class="form-control" id="start_date_create">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="end_date_create">Gidiş Tarihi</label>
                        <input type="datetime-local" class="form-control" id="end_date_create">
                    </div>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="room_type_id_create">Oda Tipi</label>
                        <div class="input-group" id="createReservationRoomTypeSearchBox">
                            <select required class="selectpicker form-control" id="room_type_id_create" data-live-search="true">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="pan_type_id_create">Pan Tipi</label>
                        <div class="input-group" id="createReservationPanTypeSearchBox">
                            <select required class="selectpicker form-control" id="pan_type_id_create" data-live-search="true">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="room_id_create">Oda Seçimi</label>
                        <div class="input-group" id="createReservationRoomSearchBox">
                            <select required class="selectpicker form-control" id="room_id_create" data-live-search="true">

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="offcanvas-footer">
            <div class="row">
                <div class="col-xl-12 text-right">
                    <button type="button" class="btn btn-success" id="createReservationButton">Oluştur</button>
                </div>
            </div>
        </div>
    </div>
</div>
