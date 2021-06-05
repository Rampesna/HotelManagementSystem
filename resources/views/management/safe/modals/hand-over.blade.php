<div class="modal fade" id="HandOverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="HandOverForm">
                <div class="modal-header">
                    <h5 class="modal-title">Kasayı Devret</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12" id="dayEndWaitingReceiptsForHandOver">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-12">
                            <span class="font-weight-bolder">TOPLAM DEVREDİLECEK MİKTAR: </span>
                            <span id="totalHandOver">TOPLAM DEVREDİLECEK MİKTAR: </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="user_id">Devredilecek Kişi</label>
                                <select id="user_id" class="form-control">
                                    <optgroup label="">
                                        <option value="">Seçim Yapılmadı</option>
                                    </optgroup>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="HandOverButton">Devret</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
