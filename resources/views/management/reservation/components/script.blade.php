<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>
    var reservations = $('#reservations').DataTable({
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

        dom: 'frtipl',

        order: [
            [
                0,
                "desc"
            ]
        ],

        responsive: true,
        select: true
    });
</script>

<script>

    var customerSelector = $("#customer_id_create");
    var roomTypeSelector = $("#room_type_id_create");
    var panTypeSelector = $("#pan_type_id_create");

    function approve() {
        var reservationsArray = [];
        var selectedRows = reservations.rows({selected: true});
        $.each(selectedRows.data(), function (index) {
            reservationsArray.push(selectedRows.data()[index][0].replace('#', ''));
        });
        console.log(reservationsArray)
        console.log('Onaylandı')
    }

    function deny() {
        var reservationsArray = [];
        var selectedRows = reservations.rows({selected: true});
        $.each(selectedRows.data(), function (index) {
            reservationsArray.push(selectedRows.data()[index][0].replace('#', ''));
        });
        console.log(reservationsArray)
        console.log('Reddedildi')
    }

    $('.card').on('contextmenu', function (e) {
        var selectedRows = reservations.rows({selected: true});
        if (selectedRows.count() > 0) {
            var top = e.pageY - 10;
            var left = e.pageX - 10;

            $("#context-menu").css({
                display: "block",
                top: top,
                left: left
            });
        }
        return false;
    }).on("click", function () {
        $("#context-menu").hide();
    }).on('focusout', function () {
        $("#context-menu").hide();
    });

    $("#context-menu a").on("click", function () {
        $(this).parent().hide();
    });

    $(document).click((e) => {
        if ($.contains($("#reservationsCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            reservations.rows().deselect();
        }
    });

    customerSelector.on('keypress', function () {
        console.log('pressed');
    });

    var CreateReservationRightBar = function () {
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
                closeBy: 'create_reservation_rightbar_close',
                toggleBy: 'create_reservation_rightbar_toggle'
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
                _element = KTUtil.getById('create_reservation_rightbar');

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
    CreateReservationRightBar.init();

    $(document).on('keyup', '#createReservationCustomerSearchBox .bs-searchbox input', function (e) {
        reloadCustomers($(this).val());
    });

    function reloadCustomers(keyword) {
        if (keyword == null || keyword === '') {
            customerSelector.html('').selectpicker('refresh');
        } else {
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.getCustomersByKeyword') }}',
                data: {
                    keyword: keyword
                },
                success: function (customers) {
                    customerSelector.html('').selectpicker('refresh');
                    $.each(customers, function (index) {
                        customerSelector.append(`<option value="${customers[index].id}">${customers[index].full_name}</option>`);
                    });
                    customerSelector.selectpicker('refresh');
                },
                error: function () {

                }
            });
        }
    }

    $(document).on('keyup', '#createReservationRoomTypeSearchBox .bs-searchbox input', function (e) {
        reloadRoomTypes($(this).val());
    });

    function reloadRoomTypes(keyword) {
        if (keyword == null || keyword === '') {
            roomTypeSelector.html('').selectpicker('refresh');
        } else {
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.getRoomTypesByKeyword') }}',
                data: {
                    keyword: keyword
                },
                success: function (roomTypes) {
                    roomTypeSelector.html('').selectpicker('refresh');
                    $.each(roomTypes, function (index) {
                        roomTypeSelector.append(`<option value="${roomTypes[index].id}">${roomTypes[index].name}</option>`);
                    });
                    roomTypeSelector.selectpicker('refresh');
                },
                error: function () {

                }
            });
        }
    }

    $(document).on('keyup', '#createReservationPanTypeSearchBox .bs-searchbox input', function (e) {
        reloadPanTypes($(this).val());
    });

    function reloadPanTypes(keyword) {
        if (keyword == null || keyword === '') {
            panTypeSelector.html('').selectpicker('refresh');
        } else {
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.getPanTypesByKeyword') }}',
                data: {
                    keyword: keyword
                },
                success: function (roomTypes) {
                    panTypeSelector.html('').selectpicker('refresh');
                    $.each(roomTypes, function (index) {
                        panTypeSelector.append(`<option value="${roomTypes[index].id}">${roomTypes[index].name}</option>`);
                    });
                    panTypeSelector.selectpicker('refresh');
                },
                error: function () {

                }
            });
        }
    }
</script>
