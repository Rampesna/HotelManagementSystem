<div id="create_room_rightbar" style="width: 800px" class="offcanvas offcanvas-right p-10">
    <form id="createRoomForm">
        <input type="hidden" id="create_room_rightbar_toggle">
        <div class="offcanvas-content">
            <div class="offcanvas-wrapper mb-5 scroll-pull">
                <div class="row">
                    <div class="col-xl-10">
                        <h5>Oda Oluştur</h5>
                    </div>
                </div>
                <hr>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Oda Numarası: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_room_number">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Oda Ücreti: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_room_price">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Kişi Sayısı: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_room_person_count">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Oda Türü: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <select class="form-control" id="creating_room_room_type_id">
                                @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Pan Türü: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <select class="form-control" id="creating_room_pan_type_id">
                                @foreach($panTypes as $panType)
                                    <option value="{{ $panType->id }}">{{ $panType->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="offcanvas-footer">
                <div class="row">
                    <div class="col-xl-12 text-right">
                        <button type="button" class="btn btn-success" id="createRoomButton">Oluştur</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
