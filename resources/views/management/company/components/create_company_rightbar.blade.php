<div id="create_company_rightbar" style="width: 800px" class="offcanvas offcanvas-right p-10">
    <form id="createCompanyForm">
        <input type="hidden" id="create_company_rightbar_toggle">
        <input type="hidden" id="creating_company_id">
        <div class="offcanvas-content">
            <div class="offcanvas-wrapper mb-5 scroll-pull">
                <div class="row">
                    <div class="col-xl-10">
                        <h5>Firma Oluştur</h5>
                    </div>
                </div>
                <hr>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Adı: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control" id="creating_company_title">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">Vergi Numarası: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control onlyNumber" maxlength="11" id="creating_company_tax_number">
                        </label>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-xl-3 mt-2">
                        <span class="font-weight-bold">İndirim Yüzdesi: </span>
                    </div>
                    <div class="col-xl-9">
                        <label style="width: 100%">
                            <input type="text" class="form-control percent" id="creating_company_custom_discount_percent">
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="offcanvas-footer">
                <div class="row">
                    <div class="col-xl-12 text-right">
                        <button type="button" class="btn btn-success" id="createCompanyButton">Oluştur</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
