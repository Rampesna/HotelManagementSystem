<div class="modal fade" id="SetRoomStatusCollectiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="setRoomStatusForm">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Durum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="set_room_status">Yeni Durum</label>
                                <select id="set_room_status" class="form-control">
                                    @foreach($roomStatuses as $roomStatus)
                                        @if($roomStatus->id != 2)
                                            <option value="{{ $roomStatus->id }}">{{ $roomStatus->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="setRoomStatusCollectiveButton">Güncelle</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
                </div>
            </form>
        </div>
    </div>
</div>
