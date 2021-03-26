<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

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
            { data: 'id', name: 'id' },
            { data: 'customer_id', name: 'customer_id' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'status_id', name: 'status_id' },
            { data: 'room_type_id', name: 'room_type_id' },
            { data: 'pan_type_id', name: 'pan_type_id' },
            { data: 'room_id', name: 'room_id' },
            { data: 'price', name: 'price' }
        ],

        responsive: true,
        stateSave: true,
        colReorder: true,
        select: true
    });
</script>

<script>

    var createReservationButton = $("#createReservationButton");

    var customerSelector = $("#customer_id_create");
    var roomTypeSelector = $("#room_type_id_create");
    var panTypeSelector = $("#pan_type_id_create");
    var roomSelector = $("#room_id_create");

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
                url: '{{ route('ajax.customers.getCustomersByKeyword') }}',
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

    roomTypeSelector.on('change', function () {
        getRooms();
    });

    panTypeSelector.on('change', function () {
        getRooms();
    });

    createReservationButton.click(function () {
        var customer_id = $("#customer_id_create").val();
        var start_date = $("#start_date_create").val();
        var end_date = $("#end_date_create").val();
        var room_type_id = $("#room_type_id_create").val();
        var pan_type_id = $("#pan_type_id_create").val();
        var room_id = $("#room_id_create").val();
        var room_use_type_id = $("#room_use_type_id_create").val();
        var price = $("#price_create").val();

        if (customer_id == null || customer_id === '') {
            toastr.warning('Müşteri Seçimi Yapmadınız!');
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
            var data = {
                _token: '{{ csrf_token() }}',
                customer_type: 'App\\Models\\Customer',
                customer_id: customer_id,
                start_date: start_date,
                end_date: end_date,
                room_type_id: room_type_id,
                pan_type_id: pan_type_id,
                room_id: room_id,
                room_use_type_id: room_use_type_id,
                price: price,
                status_id: 1
            }

            $.ajax({
                type: 'post',
                url: '{{ route('ajax.reservations.create') }}',
                data: data,
                success: function (reservation) {

                    console.log(reservation.start_date.toString())
                    console.log(reservation.end_date.toString())

                    var newReservation = $.parseHTML(`` +
                        `<tr id="row_id_${reservation.id}">` +
                        `<td>#${reservation.id}</td>` +
                        `<td>${reservation.customer.full_name}</td>` +
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
                    toastr.success('Yeni Rezervazyon Vaşarıyla Oluşturuldu');
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });
</script>
