<div id="edit_pan_type_rightbar" style="width: 800px" class="offcanvas offcanvas-right p-10">
    <form id="editPanTypeForm">
        <input type="hidden" id="edit_pan_type_rightbar_toggle">
        <input type="hidden" id="editing_pan_type_id">
        <div class="offcanvas-content">
            <div class="offcanvas-wrapper mb-5 scroll-pull">
                <div class="row">
                    <div class="col-xl-10">
                        <h5>Pan Türünü Düzenle</h5>
                    </div>
                </div>
                <hr>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Adı: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="editing_pan_type_name">
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="offcanvas-footer">
                <div class="row">
                    <div class="col-xl-12 text-right">
                        <button type="button" class="btn btn-success" id="updatePanTypeButton">Güncelle</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
