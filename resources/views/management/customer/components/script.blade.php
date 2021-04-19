<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>
    var createCustomerButton = $("#createCustomerButton");
    var updateCustomerButton = $("#updateCustomerButton");

    var createCustomerContext = $("#createCustomerContext");
    var editCustomerContext = $("#editCustomerContext");

    var customers = $('#customers').DataTable({
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
            var r = $('#customers tfoot tr');
            $('#customers thead').append(r);
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
        ajax: '{!! route('ajax.customers.index') !!}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'name', name: 'name'},
            {data: 'surname', name: 'surname'},
            {data: 'title', name: 'title'},
            {data: 'identity_number', name: 'identity_number'},
            {data: 'gender', name: 'gender'}
        ],

        responsive: true,
        select: 'single'
    });

    var CreateCustomerRightBar = function () {
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
                closeBy: 'create_customer_rightbar_close',
                toggleBy: 'create_customer_rightbar_toggle'
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
                _element = KTUtil.getById('create_customer_rightbar');

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
    CreateCustomerRightBar.init();

    var EditCustomerRightBar = function () {
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
                closeBy: 'edit_customer_rightbar_close',
                toggleBy: 'edit_customer_rightbar_toggle'
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
                _element = KTUtil.getById('edit_customer_rightbar');

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
    EditCustomerRightBar.init();

    $(".onlyNumber").keypress(function (e) {
        if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = customers.rows({selected: true});
        if (selectedRows.count() > 0) {
            var customer_id = selectedRows.data()[0].id;
            $("#editing_customer_id").val(customer_id);

            editCustomerContext.show();
        } else {
            editCustomerContext.hide();
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
        if (!$.contains($("#customersCard").get(0), e.target)) {
            $("#context-menu").hide();
            customers.rows().deselect();
        }
    });

    function createCustomer()
    {
        $("#create_customer_rightbar_toggle").click();
    }

    function editCustomer() {
        var customer_id = $("#editing_customer_id").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.customers.edit') }}',
            data: {
                customer_id: customer_id
            },
            success: function (customer) {
                $("#editing_customer_company_id").val(customer.company_id).selectpicker('refresh');
                $("#editing_customer_name").val(customer.name);
                $("#editing_customer_surname").val(customer.surname);
                $("#editing_customer_title").val(customer.title);
                $("#editing_customer_nationality_id").val(customer.nationality_id).selectpicker('refresh');
                $("#editing_customer_gender").val(customer.gender).selectpicker('refresh');
                $("#editing_customer_marriage").val(customer.marriage).selectpicker('refresh');
                $("#editing_customer_identity_type_id").val(customer.identity_type_id).selectpicker('refresh');
                $("#editing_customer_identity_number").val(customer.identity_number);
                $("#editing_customer_identity_expiration_date").val(customer.identity_expiration_date);
                $("#editing_customer_passport_number").val(customer.passport_number);
                $("#editing_customer_birth_date").val(customer.birth_date);
                $("#editing_customer_birth_place").val(customer.birth_place);
                $("#editing_customer_mother_name").val(customer.mother_name);
                $("#editing_customer_father_name").val(customer.father_name);
                $("#edit_customer_rightbar_toggle").click();
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    createCustomerButton.click(function () {
        var company_id = $("#creating_customer_company_id").val();
        var name = $("#creating_customer_name").val();
        var surname = $("#creating_customer_surname").val();
        var title = $("#creating_customer_title").val();
        var nationality_id = $("#creating_customer_nationality_id").val();
        var gender = $("#creating_customer_gender").val();
        var marriage = $("#creating_customer_marriage").val();
        var identity_type_id = $("#creating_customer_identity_type_id").val();
        var identity_expiration_date = $("#creating_customer_identity_expiration_date").val();
        var identity_number = $("#creating_customer_identity_number").val();
        var passport_number = $("#creating_customer_passport_number").val();
        var birth_date = $("#creating_customer_birth_date").val();
        var birth_place = $("#creating_customer_birth_place").val();
        var mother_name = $("#creating_customer_mother_name").val();
        var father_name = $("#creating_customer_father_name").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.customers.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                company_id: company_id,
                name: name,
                surname: surname,
                gender: gender,
                title: title,
                nationality_id: nationality_id,
                marriage: marriage,
                identity_type_id: identity_type_id,
                identity_number: identity_number,
                passport_number: passport_number,
                identity_expiration_date: identity_expiration_date,
                birth_date: birth_date,
                birth_place: birth_place,
                mother_name: mother_name,
                father_name: father_name
            },
            success: function () {
                customers.search('').columns().search('').ajax.reload().draw();
                toastr.success('Müşteri Başarıyla Oluşturuldu');
                $("#createCustomerForm").trigger('reset');
                $("#create_customer_rightbar_toggle").click();
                $("#creating_customer_company_id").selectpicker('refresh');
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    updateCustomerButton.click(function () {
        var id = $("#editing_customer_id").val();
        var company_id = $("#editing_customer_company_id").val();
        var name = $("#editing_customer_name").val();
        var surname = $("#editing_customer_surname").val();
        var title = $("#editing_customer_title").val();
        var nationality_id = $("#editing_customer_nationality_id").val();
        var gender = $("#editing_customer_gender").val();
        var marriage = $("#editing_customer_marriage").val();
        var identity_type_id = $("#editing_customer_identity_type_id").val();
        var identity_expiration_date = $("#editing_customer_identity_expiration_date").val();
        var identity_number = $("#editing_customer_identity_number").val();
        var passport_number = $("#editing_customer_passport_number").val();
        var birth_date = $("#editing_customer_birth_date").val();
        var birth_place = $("#editing_customer_birth_place").val();
        var mother_name = $("#editing_customer_mother_name").val();
        var father_name = $("#editing_customer_father_name").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.customers.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                company_id: company_id,
                id: id,
                name: name,
                surname: surname,
                gender: gender,
                title: title,
                nationality_id: nationality_id,
                marriage: marriage,
                identity_type_id: identity_type_id,
                identity_number: identity_number,
                passport_number: passport_number,
                identity_expiration_date: identity_expiration_date,
                birth_date: birth_date,
                birth_place: birth_place,
                mother_name: mother_name,
                father_name: father_name
            },
            success: function () {
                customers.search('').columns().search('').ajax.reload().draw();
                toastr.success('Başarıyla Güncellendi');
                $("#edit_customer_rightbar_toggle").click();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
