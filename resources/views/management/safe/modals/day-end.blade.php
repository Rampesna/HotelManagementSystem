<div class="modal fade" id="DayEndModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="DayEndForm">
                <div class="modal-header">
                    <h5 class="modal-title">Gün Sonu Yap</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="dayEndSafeTotal">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="day_end_datetime">Gün Sonu Yapılacak Tarih</label>
                                <input type="datetime-local" id="day_end_datetime" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12" id="dayEndWaitingReceiptsForDayEnd">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-12">
                            <span class="font-weight-bolder">GÜN SONU YAPILABİLECEK TOPLAM MİKTAR: </span>
                            <span id="totalDayEnd">--</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="withdrawn">Çekilecek Tutar</label>
                                <input type="text" id="withdrawn" class="form-control decimal">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="remaining">Kasada Kalacak Tutar</label>
                                <input type="text" id="remaining" class="form-control decimal" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="DayEndButton">Gün Sonu Yap</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
