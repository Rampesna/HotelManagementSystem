<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    function dateReCreator(getDate) {
        var date = new Date(getDate);
        return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}T${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`
    }

    reservationEditCustomersDeleteRowButton = $("#reservationEditCustomersDeleteRowButton");

    reservationEditCustomersDeleteRowButton.hide();

    const months = [
        'Ocak',
        'Şubat',
        'Mart',
        'Nisan',
        'Mayıs',
        'Haziran',
        'Temmuz',
        'Ağustos',
        'Eylül',
        'Ekim',
        'Kasım',
        'Aralık',
    ];

    function reformatDate(date) {
        var formattedDate = new Date(date);
        return String(formattedDate.getDate()).padStart(2, '0') + ' ' +
            months[formattedDate.getMonth()] + ' ' +
            formattedDate.getFullYear() + ', ' +
            String(formattedDate.getHours()).padStart(2, '0') + ':' +
            String(formattedDate.getMinutes()).padStart(2, '0') + ' ';
    }

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

        dom: 'Brtipl',

        order: [
            [
                0,
                "desc"
            ]
        ],

        buttons: [
            {
                extend: 'collection',
                text: '<i class="fa fa-download"></i> Dışa Aktar',
                buttons: [
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf"></i> PDF İndir'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Excel İndir'
                    }
                ]
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Yazdır'
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-columns"></i> Sütunlar'
            },
            {
                text: '<i class="fas fa-undo"></i> Sıfırla',
                action: function (e, dt, node, config) {
                    $('input').val('');
                    reservations.search('').columns().search('').ajax.reload().draw();
                }
            }
        ],

        initComplete: function () {
            var r = $('#reservations tfoot tr');
            $('#reservations thead').append(r);
            this.api().columns().every(function (index) {
                var column = this;
                var input = document.createElement('input');
                if (index === 2 || index === 3) {
                    input.setAttribute("type", "datetime-local");
                } else if (index === 4) {
                    input = document.createElement('select');

                    var option0 = document.createElement("option");
                    var option1 = document.createElement("option");
                    var option2 = document.createElement("option");
                    var option3 = document.createElement("option");
                    option0.setAttribute("value", 0);
                    option1.setAttribute("value", 1);
                    option2.setAttribute("value", 2);
                    option3.setAttribute("value", 3);
                    option0.innerHTML = "Tümü";
                    option1.innerHTML = "Beklemede";
                    option2.innerHTML = "Onaylandı";
                    option3.innerHTML = "İptal Edildi";
                    input.appendChild(option0);
                    input.appendChild(option1);
                    input.appendChild(option2);
                    input.appendChild(option3);
                }
                input.className = 'form-control';
                $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        },

        processing: true,
        serverSide: true,
        ajax: '{!! route('ajax.reservations.index') !!}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'status_id', name: 'status_id'},
            {data: 'room_type_id', name: 'room_type_id'},
            {data: 'pan_type_id', name: 'pan_type_id'},
            {data: 'room_id', name: 'room_id'},
            {data: 'price', name: 'price'}
        ],

        responsive: true,
        stateSave: true,
        colReorder: true,
        select: true
    });

    var reservationCustomers = $('#reservationCustomers').DataTable({
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

        dom: 'rt',

        responsive: true,
        select: 'single'
    });

    var reservationEditCustomers = $('#reservationEditCustomers').DataTable({
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

        dom: 'rt',

        responsive: true,
        select: 'single'
    });

</script>

<script>

    var createReservationButton = $("#createReservationButton");
    var editReservationCreateCustomerButton = $("#editReservationCreateCustomerButton");
    var updateReservationButton = $("#updateReservationButton");
    var createCustomerButton = $("#createCustomerButton");
    var editReservationContext = $("#editReservationContext");

    var roomTypeSelector = $("#room_type_id_create");
    var panTypeSelector = $("#pan_type_id_create");
    var roomSelector = $("#room_id_create");

    var roomTypeEditSelector = $("#room_type_id_edit");
    var panTypeEditSelector = $("#pan_type_id_edit");
    var roomEditSelector = $("#room_id_edit");

    function setWaiting() {
        var reservationsArray = [];
        var selectedRows = reservations.rows({selected: true});

        $.each(selectedRows.data(), function (index) {
            reservationsArray.push(selectedRows.data()[index]['id'].replace('#', ''));
        });

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.reservations.setStatus') }}',
            data: {
                _token: '{{ csrf_token() }}',
                reservations: reservationsArray,
                status_id: 1
            },
            success: function (response) {
                if (response === 'Tamamlandı') {
                    $.each(selectedRows.data(), function (index) {
                        $("#reservation_" + selectedRows.data()[index]['id'].replace('#', '') + "_status").removeClass().addClass('btn btn-pill btn-sm btn-success').html('Onaylandı');
                    });
                    reservations.rows().invalidate().draw();
                } else {
                    toastr.error('Bir Hata Oluştu!');
                    console.log(response)
                }
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    function approve() {
        var reservationsArray = [];
        var selectedRows = reservations.rows({selected: true});

        $.each(selectedRows.data(), function (index) {
            reservationsArray.push(selectedRows.data()[index]['id'].replace('#', ''));
        });

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.reservations.setStatus') }}',
            data: {
                _token: '{{ csrf_token() }}',
                reservations: reservationsArray,
                status_id: 2
            },
            success: function (response) {
                if (response === 'Tamamlandı') {
                    $.each(selectedRows.data(), function (index) {
                        $("#reservation_" + selectedRows.data()[index]['id'].replace('#', '') + "_status").removeClass().addClass('btn btn-pill btn-sm btn-success').html('Onaylandı');
                    });
                    reservations.rows().invalidate().draw();
                } else {
                    toastr.error('Bir Hata Oluştu!');
                    console.log(response)
                }
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    function deny() {
        var reservationsArray = [];
        var selectedRows = reservations.rows({selected: true});

        $.each(selectedRows.data(), function (index) {
            reservationsArray.push(selectedRows.data()[index]['id'].replace('#', ''));
        });

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.reservations.setStatus') }}',
            data: {
                _token: '{{ csrf_token() }}',
                reservations: reservationsArray,
                status_id: 3
            },
            success: function (response) {
                if (response === 'Tamamlandı') {
                    $.each(selectedRows.data(), function (index) {
                        $("#reservation_" + selectedRows.data()[index]['id'].replace('#', '') + "_status").removeClass().addClass('btn btn-pill btn-sm btn-danger').html('İptal Edildi');
                    });
                    reservations.rows().invalidate().draw();
                } else {
                    toastr.error('Bir Hata Oluştu!');
                    console.log(response)
                }
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    $('.card').on('contextmenu', function (e) {
        var selectedRows = reservations.rows({selected: true});
        if (selectedRows.count() > 0) {

            if (selectedRows.count() > 1) {
                $("#editable-context-menu").hide();
            } else {
                $("#editing_reservation_id").val(selectedRows.data()[0].id.replace('#', ''));
                $("#editable-context-menu").show();
            }

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

    var EditReservationRightBar = function () {
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
                closeBy: 'edit_reservation_rightbar_close',
                toggleBy: 'edit_reservation_rightbar_toggle'
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
                _element = KTUtil.getById('edit_reservation_rightbar');

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
    EditReservationRightBar.init();

    $(document).on('keyup', '#createReservationRoomTypeSearchBox .bs-searchbox input', function (e) {
        reloadRoomTypes($(this).val());
    });

    function reloadRoomTypes(keyword) {
        if (keyword == null || keyword === '') {
            roomTypeSelector.html('').selectpicker('refresh');
        } else {
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.room-types.getRoomTypesByKeyword') }}',
                data: {
                    keyword: keyword
                },
                success: function (roomTypes) {
                    roomTypeSelector.html('').selectpicker('refresh');
                    roomTypeSelector.append(`<option selected hidden disabled></option>`);
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
                url: '{{ route('ajax.pan-types.getPanTypesByKeyword') }}',
                data: {
                    keyword: keyword
                },
                success: function (panTypes) {
                    panTypeSelector.html('').selectpicker('refresh');
                    panTypeSelector.append(`<option selected hidden disabled></option>`);
                    $.each(panTypes, function (index) {
                        panTypeSelector.append(`<option value="${panTypes[index].id}">${panTypes[index].name}</option>`);
                    });
                    panTypeSelector.selectpicker('refresh');
                },
                error: function () {

                }
            });
        }
    }

    function getRooms() {
        var room_type_id = roomTypeSelector.val();
        var pan_type_id = panTypeSelector.val();

        if (room_type_id != null && pan_type_id != null) {
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.rooms.getRoomsByPanTypeAndRoomType') }}',
                data: {
                    room_type_id: room_type_id,
                    pan_type_id: pan_type_id
                },
                success: function (rooms) {
                    roomSelector.html('').selectpicker('refresh');
                    roomSelector.append(`<option selected hidden disabled></option>`);
                    $.each(rooms, function (index) {
                        roomSelector.append(`<option value="${rooms[index].id}">${rooms[index].number}</option>`);
                    });
                    roomSelector.selectpicker('refresh');
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    }

    function getRoomsEdit(id) {
        var room_type_id = roomTypeEditSelector.val();
        var pan_type_id = panTypeEditSelector.val();

        if (room_type_id != null && pan_type_id != null) {
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.rooms.getRoomsByPanTypeAndRoomType') }}',
                data: {
                    room_type_id: room_type_id,
                    pan_type_id: pan_type_id
                },
                success: function (rooms) {
                    roomEditSelector.html('').selectpicker('refresh');
                    $.each(rooms, function (index) {
                        roomEditSelector.append(`<option ${rooms[index].id === id ? 'selected' : null} value="${rooms[index].id}">${rooms[index].number}</option>`);
                    });
                    roomEditSelector.selectpicker('refresh');
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    }

    roomTypeSelector.on('change', function () {
        getRooms();
    });

    panTypeSelector.on('change', function () {
        getRooms();
    });

    createReservationButton.click(function () {
        var customer_name = $("#customer_name_create").val();
        var start_date = $("#start_date_create").val();
        var end_date = $("#end_date_create").val();
        var room_type_id = $("#room_type_id_create").val();
        var pan_type_id = $("#pan_type_id_create").val();
        var room_id = $("#room_id_create").val();
        var room_use_type_id = $("#room_use_type_id_create").val();
        var price = $("#price_create").val();

        if (customer_name == null || customer_name === '') {
            toastr.warning('Rezervasyonu Yaptıran Müşteri Adını Giriniz!');
        } else if (start_date == null || start_date === '') {
            toastr.warning('Geliş Tarihini Seçmediniz!');
        } else if (end_date == null || end_date === '') {
            toastr.warning('Gidiş Tarihini Seçmediniz!');
        } else if (room_type_id == null || room_type_id === '') {
            toastr.warning('Oda Tipini Seçmediniz!');
        } else if (pan_type_id == null || pan_type_id === '') {
            toastr.warning('Pan Tipini Seçmediniz!');
        } else if (room_id == null || room_id === '') {
            toastr.warning('Oda Seçimi Yapmadınız!');
        } else if (room_use_type_id == null || room_use_type_id === '') {
            toastr.warning('Oda Kullanım Tipini Seçmediniz!');
        } else {
            customerList = reservationCustomers.rows().data();
            customerListArray = [];

            $.each(customerList, function (index) {
                customerListArray.push(customerList[index]['DT_RowId'].replace('customer_id_', ''));
            });

            var data = {
                _token: '{{ csrf_token() }}',
                customer_name: customer_name,
                start_date: start_date,
                end_date: end_date,
                room_type_id: room_type_id,
                pan_type_id: pan_type_id,
                room_id: room_id,
                room_use_type_id: room_use_type_id,
                price: price,
                status_id: 1,
                customers: customerListArray
            }

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.reservations.save') }}',
                data: data,
                success: function (reservation) {
                    var newReservation = $.parseHTML(`` +
                        `<tr id="row_id_${reservation.id}">` +
                        `<td>#${reservation.id}</td>` +
                        `<td>${reservation.customer_name}</td>` +
                        `<td data-sort="${reservation.start_date}">${reformatDate(reservation.start_date)}</td>` +
                        `<td data-sort="${reservation.end_date}">${reformatDate(reservation.end_date)}</td>` +
                        `<td><span id="reservation_${reservation.id}_status" class="btn btn-pill btn-sm btn-${reservation.status.color}" style="font-size: 11px; height: 20px; padding-top: 2px">${reservation.status.name}</span></td>` +
                        `<td>${reservation.room_type.name}</td>` +
                        `<td>${reservation.pan_type.name}</td>` +
                        `<td>${reservation.room.number}</td>` +
                        `<td>${reservation.price}</td>` +
                        `</tr>` +
                        ``)[0];

                    reservations.row.add(newReservation);
                    reservations.draw(false);
                    $("#createReservationForm").trigger('reset');
                    $("#customer_id_create").html('').selectpicker('refresh');
                    $("#room_type_id_create").html('').selectpicker('refresh');
                    $("#pan_type_id_create").html('').selectpicker('refresh');
                    $("#room_id_create").html('').selectpicker('refresh');
                    $("#create_reservation_rightbar_toggle").click();
                    reservationCustomers.clear().draw();
                    toastr.success('Yeni Rezervazyon Başarıyla Oluşturuldu');
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });

    updateReservationButton.click(function () {
        var reservation_id = $("#editing_reservation_id").val();
        var customer_name = $("#customer_name_edit").val();
        var start_date = $("#start_date_edit").val();
        var end_date = $("#end_date_edit").val();
        var room_type_id = $("#room_type_id_edit").val();
        var pan_type_id = $("#pan_type_id_edit").val();
        var room_id = $("#room_id_edit").val();
        var room_use_type_id = $("#room_use_type_id_edit").val();
        var status_id = $("#editing_reservation_status_id").val();

        if (reservation_id === '' || reservation_id == null) {
            toastr.error('Reservasyon Seçiminde Hata Oluştu. Sayfayı Yenilemeyi Deneyin');
        } else if (customer_name == null || customer_name === '') {
            toastr.warning('Rezervasyonu Yaptıran Müşteri Adını Giriniz!');
        } else if (start_date == null || start_date === '') {
            toastr.warning('Geliş Tarihini Seçmediniz!');
        } else if (end_date == null || end_date === '') {
            toastr.warning('Gidiş Tarihini Seçmediniz!');
        } else if (room_type_id == null || room_type_id === '') {
            toastr.warning('Oda Tipini Seçmediniz!');
        } else if (pan_type_id == null || pan_type_id === '') {
            toastr.warning('Pan Tipini Seçmediniz!');
        } else if (room_id == null || room_id === '') {
            toastr.warning('Oda Seçimi Yapmadınız!');
        } else if (room_use_type_id == null || room_use_type_id === '') {
            toastr.warning('Oda Kullanım Tipini Seçmediniz!');
        } else {
            customerList = reservationEditCustomers.rows().data();
            customerListArray = [];

            $.each(customerList, function (index) {
                customerListArray.push(customerList[index]['DT_RowId'].replace('customer_id_', ''));
            });

            var data = {
                _token: '{{ csrf_token() }}',
                reservation_id: reservation_id,
                customer_name: customer_name,
                start_date: start_date,
                end_date: end_date,
                room_type_id: room_type_id,
                pan_type_id: pan_type_id,
                room_id: room_id,
                room_use_type_id: room_use_type_id,
                status_id: status_id,
                customers: customerListArray
            }

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.reservations.save') }}',
                data: data,
                success: function (reservation) {
                    reservations.row('#row_id_' + reservation_id).remove().draw();
                    var newReservation = $.parseHTML(`` +
                        `<tr id="row_id_${reservation.id}">` +
                        `<td>#${reservation.id}</td>` +
                        `<td>${reservation.customer_name}</td>` +
                        `<td data-sort="${reservation.start_date}">${reformatDate(reservation.start_date)}</td>` +
                        `<td data-sort="${reservation.end_date}">${reformatDate(reservation.end_date)}</td>` +
                        `<td><span id="reservation_${reservation.id}_status" class="btn btn-pill btn-sm btn-${reservation.status.color}" style="font-size: 11px; height: 20px; padding-top: 2px">${reservation.status.name}</span></td>` +
                        `<td>${reservation.room_type.name}</td>` +
                        `<td>${reservation.pan_type.name}</td>` +
                        `<td>${reservation.room.number}</td>` +
                        `<td>${reservation.price}</td>` +
                        `</tr>` +
                        ``)[0];
                    reservations.row.add(newReservation);
                    reservations.draw(false);
                    $("#createReservationForm").trigger('reset');
                    $("#customer_id_create").html('').selectpicker('refresh');
                    $("#room_type_id_create").html('').selectpicker('refresh');
                    $("#pan_type_id_create").html('').selectpicker('refresh');
                    $("#room_id_create").html('').selectpicker('refresh');
                    $("#edit_reservation_rightbar_toggle").click();
                    toastr.success('Rezervazyon Başarıyla Güncellendi');
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });

    createCustomerButton.click(function () {
        var name = $("#customer_create_name").val();
        var surname = $("#customer_create_surname").val();
        var gender = $("#customer_create_gender").val();
        var title = $("#customer_create_title").val();
        var nationality_id = $("#customer_create_nationality_id").val();
        var marriage = $("#customer_create_marriage").val();
        var identity_type_id = $("#customer_create_identity_type_id").val();
        var identity_number = $("#customer_create_identity_number").val();
        var identity_expiration_date = $("#customer_create_identity_expiration_date").val();
        var birth_date = $("#customer_create_birth_date").val();
        var birth_place = $("#customer_create_birth_place").val();
        var mother_name = $("#customer_create_mother_name").val();
        var father_name = $("#customer_create_father_name").val();

        if (name === '' || name == null) {
            toastr.warning('Ad Boş Olamaz');
        } else if (surname === '' || surname == null) {
            toastr.warning('Soyad Boş Olamaz');
        } else if (gender === '' || gender == null) {
            toastr.warning('Cinsiyet Seçmediniz!');
        } else if (nationality_id === '' || nationality_id == null) {
            toastr.warning('Uyruk Seçmediniz!');
        } else if (identity_type_id === '' || identity_type_id == null) {
            toastr.warning('Kimlik Türü Seçmediniz!');
        } else if (identity_number === '' || identity_number == null) {
            toastr.warning('Kimlik Numarası Olamaz');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.customers.create') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    surname: surname,
                    gender: gender,
                    title: title,
                    nationality_id: nationality_id,
                    marriage: marriage,
                    identity_type_id: identity_type_id,
                    identity_number: identity_number,
                    identity_expiration_date: identity_expiration_date,
                    birth_date: birth_date,
                    birth_place: birth_place,
                    mother_name: mother_name,
                    father_name: father_name
                },
                success: function (customer) {
                    var newCustomer = $.parseHTML(`` +
                        `<tr id="customer_id_${customer.id}">` +
                        `<td>${customer.name}</td>` +
                        `<td>${customer.surname}</td>` +
                        `<td>${customer.title ?? ''}</td>` +
                        `<td>${customer.nationality.name}</td>` +
                        `<td>${customer.gender === 1 ? 'Erkek' : 'Kadın'}</td>` +
                        `</tr>` +
                        ``)[0];

                    reservationCustomers.row.add(newCustomer);
                    reservationCustomers.draw(false);

                    $("#createCustomerForm").trigger('reset');
                    $("#CreateCustomerModal").modal('hide');
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });

    editReservationCreateCustomerButton.click(function () {
        var name = $("#edit_reservation_customer_create_name").val();
        var surname = $("#edit_reservation_customer_create_surname").val();
        var gender = $("#edit_reservation_customer_create_gender").val();
        var title = $("#edit_reservation_customer_create_title").val();
        var nationality_id = $("#edit_reservation_customer_create_nationality_id").val();
        var marriage = $("#edit_reservation_customer_create_marriage").val();
        var identity_type_id = $("#edit_reservation_customer_create_identity_type_id").val();
        var identity_number = $("#edit_reservation_customer_create_identity_number").val();
        var identity_expiration_date = $("#edit_reservation_customer_create_identity_expiration_date").val();
        var birth_date = $("#edit_reservation_customer_create_birth_date").val();
        var birth_place = $("#edit_reservation_customer_create_birth_place").val();
        var mother_name = $("#edit_reservation_customer_create_mother_name").val();
        var father_name = $("#edit_reservation_customer_create_father_name").val();

        if (name === '' || name == null) {
            toastr.warning('Ad Boş Olamaz');
        } else if (surname === '' || surname == null) {
            toastr.warning('Soyad Boş Olamaz');
        } else if (gender === '' || gender == null) {
            toastr.warning('Cinsiyet Seçmediniz!');
        } else if (nationality_id === '' || nationality_id == null) {
            toastr.warning('Uyruk Seçmediniz!');
        } else if (identity_type_id === '' || identity_type_id == null) {
            toastr.warning('Kimlik Türü Seçmediniz!');
        } else if (identity_number === '' || identity_number == null) {
            toastr.warning('Kimlik Numarası Olamaz');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.customers.create') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    surname: surname,
                    gender: gender,
                    title: title,
                    nationality_id: nationality_id,
                    marriage: marriage,
                    identity_type_id: identity_type_id,
                    identity_number: identity_number,
                    identity_expiration_date: identity_expiration_date,
                    birth_date: birth_date,
                    birth_place: birth_place,
                    mother_name: mother_name,
                    father_name: father_name
                },
                success: function (customer) {
                    var newCustomer = $.parseHTML(`` +
                        `<tr id="customer_id_${customer.id}">` +
                        `<td>${customer.name}</td>` +
                        `<td>${customer.surname}</td>` +
                        `<td>${customer.title ?? ''}</td>` +
                        `<td>${customer.nationality.name}</td>` +
                        `<td>${customer.gender === 1 ? 'Erkek' : 'Kadın'}</td>` +
                        `</tr>` +
                        ``)[0];

                    reservationEditCustomers.row.add(newCustomer);
                    reservationEditCustomers.draw(false);

                    $("#editReservationCreateCustomerForm").trigger('reset');
                    $("#EditReservationCreateCustomerModal").modal('hide');
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });

    editReservationContext.click(function () {
        var reservation_id = $("#editing_reservation_id").val();
        $("#edit_reservation_rightbar_toggle").click();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.reservations.edit') }}',
            data: {
                reservation_id: reservation_id
            },
            success: function (reservation) {
                $("#customer_name_edit").val(reservation.customer_name);
                $("#start_date_edit").val(dateReCreator(reservation.start_date));
                $("#end_date_edit").val(dateReCreator(reservation.end_date));
                $("#editing_reservation_status_id").val(reservation.status_id);

                roomTypeEditSelector.empty();
                roomTypeEditSelector.append(`<option selected value="${reservation.room_type.id}">${reservation.room_type.name}</option>`).selectpicker('refresh');

                panTypeEditSelector.empty();
                panTypeEditSelector.append(`<option selected value="${reservation.pan_type.id}">${reservation.pan_type.name}</option>`).selectpicker('refresh');

                getRoomsEdit(reservation.room_id);

                $("#room_use_type_id_edit").val(reservation.use_type_id).selectpicker('refresh');

                reservationEditCustomers.clear().draw();
                $.each(reservation.customers, function (index) {
                    var customer = $.parseHTML(`` +
                        `<tr id="customer_id_${reservation.customers[index].id}">` +
                        `<td>${reservation.customers[index].name}</td>` +
                        `<td>${reservation.customers[index].surname}</td>` +
                        `<td>${reservation.customers[index].title ?? ''}</td>` +
                        `<td>${reservation.customers[index].nationality.name}</td>` +
                        `<td>${reservation.customers[index].gender === 1 ? 'Erkek' : 'Kadın'}</td>` +
                        `</tr>` +
                        ``)[0];

                    reservationEditCustomers.row.add(customer);
                    reservationEditCustomers.draw(false);
                });
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    reservationEditCustomers.on('select deselect', function (e, dt, type, indexes) {
        var selectedRows = reservationEditCustomers.rows({selected: true});
        if (selectedRows.count() > 0) {
            reservationEditCustomersDeleteRowButton.show();
            if (type === 'row') {
                var data = reservationEditCustomers.rows(indexes).data()[0]['DT_RowId'].replace('customer_id_','');
                $("#editing_reservation_deleting_customer_id").val(data);
            }
        } else {
            reservationEditCustomersDeleteRowButton.hide();
            $("#editing_reservation_deleting_customer_id").val(null);
        }
    });

    reservationEditCustomersDeleteRowButton.click(function () {
        var customer_id = $("#editing_reservation_deleting_customer_id").val();
        reservationEditCustomers.row('#customer_id_' + customer_id).remove().draw();
    });
</script>
