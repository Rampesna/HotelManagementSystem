<input type="hidden" id="show_reservation_rightbar_toggle">
<div id="show_reservation_rightbar" style="width: 800px" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-content">
        <div class="offcanvas-wrapper mb-5 scroll-pull">
            <div class="row">
                <div class="col-xl-10">
                    <h5>Rezervasyon Detayları</h5>
                </div>
            </div>
            <hr>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Firma: </span>
                </div>
                <div class="col-xl-9">
                    <span id="showReservationCompanySpan">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Müşteri: </span>
                </div>
                <div class="col-xl-9">
                    <span id="showReservationCustomerSpan">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Oda Numarası: </span>
                </div>
                <div class="col-xl-9">
                    <span id="showReservationRoomSpan">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Geliş Tarihi: </span>
                </div>
                <div class="col-xl-9">
                    <span id="showReservationStartDateSpan">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Çıkış Tarihi: </span>
                </div>
                <div class="col-xl-9">
                    <span id="showReservationEndDateSpan">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Durum: </span>
                </div>
                <div class="col-xl-9">
                    <span id="showReservationStatusSpan" class="btn btn-pill btn-sm" style="font-size: 11px; height: 20px; padding-top: 2px">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Oda Türü: </span>
                </div>
                <div class="col-xl-9">
                    <span id="showReservationRoomTypeSpan">--</span>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-xl-3">
                    <span class="font-weight-bold">Pan Türü: </span>
                </div>
                <div class="col-xl-9">
                    <span id="showReservationPanTypeSpan">--</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="offcanvas-wrapper mb-5 scroll-pull">
            <div class="row">
                <div class="col-xl-12">
                    <h5>Misafir Listesi</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <table class="table" id="showReservationCustomers">
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
    </div>
</div>
