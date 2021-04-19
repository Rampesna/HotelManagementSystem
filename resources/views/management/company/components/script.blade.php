<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var createCompanyContext = $("#createCompanyContext");
    var editCompanyContext = $("#editCompanyContext");
    var deleteCompanyContext = $("#deleteCompanyContext");

    var createCompanyButton = $("#createCompanyButton");
    var updateCompanyButton = $("#updateCompanyButton");
    var deleteCompanyButton = $("#deleteCompanyButton");

    var companies = $('#companies').DataTable({
        language: {
            info: "_TOTAL_ Kayıttan _START_ - _END_ Arasındaki Kayıtlar Gösteriliyor.",
            infoEmpty: "Gösterilecek Hiç Kayıt Yok.",
            loadingRecords: "Kayıtlar Yükleniyor.",
            zeroRecords: "Tablo Boş",
            search: "Arama:",
            infoFiltered: "(Toplam _MAX_ Kayıttan Filtrelenenler)",
            lengthMenu: "Sayfa Başı _MENU_ Kayıt Göster",
            sProcessing: "Yükleniyor...",
            paginate: {
                first: "İlk",
                previous: "Önceki",
                next: "Sonraki",
                last: "Son"
            },
            select: {
                rows: {
                    "_": "%d kayıt seçildi",
                    "0": "",
                    "1": "1 kayıt seçildi"
                }
            },
            buttons: {
                print: {
                    title: 'Yazdır'
                }
            }
        },

        dom: 'rtipl',

        initComplete: function () {
            var r = $('#companies tfoot tr');
            $('#companies thead').append(r);
            this.api().columns().every(function (index) {
                var column = this;
                var input = document.createElement('input');
                input.className = 'form-control';
                $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        },

        processing: true,
        serverSide: true,
        ajax: '{!! route('ajax.companies.index') !!}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'title', name: 'title'},
            {data: 'tax_number', name: 'tax_number'},
            {data: 'custom_discount_percent', name: 'custom_discount_percent'}
        ],

        responsive: true,
        select: 'single'
    });

    $('.percent').on("copy cut paste drop", function () {
        return false;
    }).keyup(function () {
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2)
                val = val.replace(/\.+$/, "");
        }

        if (val > 100) {
            val = 100;
        } else if (val < 0) {
            val = 0;
        }

        $(this).val(val);
    });

    $(".onlyNumber").keypress(function (e) {
        if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = companies.rows({selected: true});
        if (selectedRows.count() > 0) {
            var company_id = selectedRows.data()[0].id;
            $("#editing_company_id").val(company_id);

            editCompanyContext.show();
            deleteCompanyContext.show();
        } else {
            editCompanyContext.hide();
            deleteCompanyContext.hide();
        }

        var top = e.pageY - 10;
        var left = e.pageX - 10;

        $("#context-menu").css({
            display: "block",
            top: top,
            left: left
        });

        return false;
    }).on("click", function () {
        $("#context-menu").hide();
    }).on('focusout', function () {
        $("#context-menu").hide();
    });

    $(document).click((e) => {
        if ($.contains($("#companiesCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            companies.rows().deselect();
        }
    });

    var EditCompanyRightBar = function () {
        // Private properties
        var _element;
        var _offcanvasObject;

        // Private functions
        var _init = function () {
            var header = KTUtil.find(_element, '.offcanvas-header');
            var content = KTUtil.find(_element, '.offcanvas-content');

            _offcanvasObject = new KTOffcanvas(_element, {
                overlay: true,
                baseClass: 'offcanvas',
                placement: 'right',
                closeBy: 'edit_company_rightbar_close',
                toggleBy: 'edit_company_rightbar_toggle'
            });

            KTUtil.scrollInit(content, {
                disableForMobile: true,
                resetHeightOnDestroy: true,
                handleWindowResize: true,
                height: function () {
                    var height = parseInt(KTUtil.getViewPort().height);

                    if (header) {
                        height = height - parseInt(KTUtil.actualHeight(header));
                        height = height - parseInt(KTUtil.css(header, 'marginTop'));
                        height = height - parseInt(KTUtil.css(header, 'marginBottom'));
                    }

                    if (content) {
                        height = height - parseInt(KTUtil.css(content, 'marginTop'));
                        height = height - parseInt(KTUtil.css(content, 'marginBottom'));
                    }

                    height = height - parseInt(KTUtil.css(_element, 'paddingTop'));
                    height = height - parseInt(KTUtil.css(_element, 'paddingBottom'));

                    height = height - 2;

                    return height;
                }
            });
        }

        // Public methods
        return {
            init: function () {
                _element = KTUtil.getById('edit_company_rightbar');

                if (!_element) {
                    return;
                }

                // Initialize
                _init();
            },

            getElement: function () {
                return _element;
            }
        };
    }();
    EditCompanyRightBar.init();

    var CreateCompanyRightBar = function () {
        // Private properties
        var _element;
        var _offcanvasObject;

        // Private functions
        var _init = function () {
            var header = KTUtil.find(_element, '.offcanvas-header');
            var content = KTUtil.find(_element, '.offcanvas-content');

            _offcanvasObject = new KTOffcanvas(_element, {
                overlay: true,
                baseClass: 'offcanvas',
                placement: 'right',
                closeBy: 'create_company_rightbar_close',
                toggleBy: 'create_company_rightbar_toggle'
            });

            KTUtil.scrollInit(content, {
                disableForMobile: true,
                resetHeightOnDestroy: true,
                handleWindowResize: true,
                height: function () {
                    var height = parseInt(KTUtil.getViewPort().height);

                    if (header) {
                        height = height - parseInt(KTUtil.actualHeight(header));
                        height = height - parseInt(KTUtil.css(header, 'marginTop'));
                        height = height - parseInt(KTUtil.css(header, 'marginBottom'));
                    }

                    if (content) {
                        height = height - parseInt(KTUtil.css(content, 'marginTop'));
                        height = height - parseInt(KTUtil.css(content, 'marginBottom'));
                    }

                    height = height - parseInt(KTUtil.css(_element, 'paddingTop'));
                    height = height - parseInt(KTUtil.css(_element, 'paddingBottom'));

                    height = height - 2;

                    return height;
                }
            });
        }

        // Public methods
        return {
            init: function () {
                _element = KTUtil.getById('create_company_rightbar');

                if (!_element) {
                    return;
                }

                // Initialize
                _init();
            },

            getElement: function () {
                return _element;
            }
        };
    }();
    CreateCompanyRightBar.init();

    function createCompany() {
        $("#create_company_rightbar_toggle").click();
    }

    function editCompany() {
        var company_id = $("#editing_company_id").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.companies.show') }}',
            data: {
                company_id: company_id
            },
            success: function (extra) {
                $("#editing_company_id").val(extra.id);
                $("#editing_company_title").val(extra.title);
                $("#editing_company_tax_number").val(extra.tax_number);
                $("#editing_company_custom_discount_percent").val(extra.custom_discount_percent);
            },
            error: function (error) {
                console.log(error)
            }
        });

        $("#edit_company_rightbar_toggle").click();
    }

    function deleteCompany() {
        $("#DeleteCompanyModal").modal('show');
    }

    createCompanyButton.click(function () {
        var title = $("#creating_company_title").val();
        var tax_number = $("#creating_company_tax_number").val();
        var custom_discount_percent = $("#creating_company_custom_discount_percent").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.companies.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                title: title,
                tax_number: tax_number,
                custom_discount_percent: custom_discount_percent
            },
            success: function () {
                toastr.success('Yeni Firma Oluşturuldu');
                $("#create_company_rightbar_toggle").click();
                $("#createCompanyForm").trigger('reset');
                companies.search('').columns().search('').ajax.reload().draw();
            },
            error: function () {

            }
        });
    });

    updateCompanyButton.click(function () {
        var id = $("#editing_company_id").val();
        var title = $("#editing_company_title").val();
        var tax_number = $("#editing_company_tax_number").val();
        var custom_discount_percent = $("#editing_company_custom_discount_percent").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.companies.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                title: title,
                tax_number: tax_number,
                custom_discount_percent: custom_discount_percent
            },
            success: function () {
                toastr.success('Başarıyla Güncellendi');
                $("#edit_company_rightbar_toggle").click();
                companies.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    deleteCompanyButton.click(function () {
        var id = $("#editing_company_id").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.companies.delete') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function () {
                toastr.success('Firma Silindi');
                $("#DeleteCompanyModal").modal('hide');
                companies.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
