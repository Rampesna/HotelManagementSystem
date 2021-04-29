<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>
    var editReservationCreateCustomerButton = $("#editReservationCreateCustomerButton");
    var updateReservationButton = $("#updateReservationButton");
    var editReservationSelectCustomerButton = $("#editReservationSelectCustomerButton");
    var roomTypeSelector = $("#room_type_id_create");
    var panTypeSelector = $("#pan_type_id_create");
    var roomSelector = $("#room_id_create");
    var roomTypeEditSelector = $("#room_type_id_edit");
    var panTypeEditSelector = $("#pan_type_id_edit");
    var roomEditSelector = $("#room_id_edit");
    var reservationEditCustomersDeleteRowButton = $("#reservationEditCustomersDeleteRowButton");
    var addExtraReservationButton = $("#addExtraReservationButton");
    var startDateEditSelector = $("#start_date_edit");
    var endDateEditSelector = $("#end_date_edit");

    var reservationEditContext = $("#reservationEditContext");

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

    $('.decimal').on("copy cut paste drop", function () {
        return false;
    }).keyup(function () {
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2)
                val = val.replace(/\.+$/, "");
        }
        $(this).val(val);
    });

    function reformatDate(date) {
        var formattedDate = new Date(date);
        return String(formattedDate.getDate()).padStart(2, '0') + ' ' +
            months[formattedDate.getMonth()] + ' ' +
            formattedDate.getFullYear() + ', ' +
            String(formattedDate.getHours()).padStart(2, '0') + ':' +
            String(formattedDate.getMinutes()).padStart(2, '0') + ' ';
    }

    function getReservationExtras(reservation) {
        var reservation_id = reservation.id.replace('#', '');

        var extrasList = ``;

        $.ajax({
            async: false,
            type: 'get',
            url: '{{ route('ajax.safe-activities.getByReservationId') }}',
            data: {
                reservation_id: reservation_id
            },
            success: function (extras) {
                $.each(extras, function (index) {
                    extrasList = extrasList +
                        `    <tr>` +
                        `        <td>${extras[index].id}</td>` +
                        `        <td>${extras[index].extra ? extras[index].extra.name : 'Oda Ücreti'}</td>` +
                        `        <td>${extras[index].description ?? ''}</td>` +
                        `        <td>${extras[index].date ? reformatDate(extras[index].date) : ''}</td>` +
                        `        <td>${parseFloat(extras[index].price).toFixed(2)} TL</td>` +
                        `    </tr>`;
                });
            },
            error: function (error) {
                console.log(error)
            }
        });

        return `` +
            `<table id="${reservation.id}" class="table" style="padding-left:50px;">` +
            `<thead>` +
            `    <tr>` +
            `        <th>#</th>` +
            `        <th>Ekstra</th>` +
            `        <th>Detaylar</th>` +
            `        <th>Tarih</th>` +
            `        <th>Ücret</th>` +
            `    </tr>` +
            `</thead>` +
            `<tbody>` +
            extrasList +
            `</tbody>` +
            `</table>`;
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
                1,
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
                text: '<i class="fas fa-undo"></i> Yenile',
                action: function (e, dt, node, config) {
                    $('table input').val('');
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
                if (index === 3 || index === 4) {
                    input.setAttribute("type", "datetime-local");
                } else if (index === 0 || index === 5) {
                    input = null;
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    return;
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
        ajax: '{!! route('ajax.stayers.reservations') !!}',
        columns: [
            {data: 'id', name: 'id', className: 'details-control cursor-pointer'},
            {data: 'customer_name', name: 'customer_name', className: 'details-control cursor-pointer'},
            {data: 'start_date', name: 'start_date', className: 'details-control cursor-pointer'},
            {data: 'end_date', name: 'end_date', className: 'details-control cursor-pointer'},
            {data: 'status_id', name: 'status_id', className: 'details-control cursor-pointer'},
            {data: 'room_type_id', name: 'room_type_id', className: 'details-control cursor-pointer'},
            {data: 'pan_type_id', name: 'pan_type_id', className: 'details-control cursor-pointer'},
            {data: 'room_id', name: 'room_id', className: 'details-control cursor-pointer'},
            {data: 'price', name: 'price', className: 'details-control cursor-pointer'}
        ],

        responsive: true,
        stateSave: true,
        select: 'single'
    });

    $('#reservations tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = reservations.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(getReservationExtras(row.data())).show();
            tr.addClass('shown');
        }
    }).on('mousedown', 'tr', function (e) {
        if (e.button === 0) {
            return false;
        } else {
            reservations.row(this).select();
        }
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

    var editReservationSelectCustomerTable = $('#editReservationSelectCustomerTable').DataTable({
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

        dom: 'rtp',

        initComplete: function () {
            var r = $('#editReservationSelectCustomerTable tfoot tr');
            $('#editReservationSelectCustomerTable thead').append(r);
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

    $('.card').on('contextmenu', function (e) {
        var selectedRows = reservations.rows({selected: true});
        if (selectedRows.count() > 0) {
            var reservation_id = selectedRows.data()[0].id.replace('#', '');
            $("#selected_reservation_id").val(reservation_id);

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

    $(document).click((e) => {
        if ($.contains($("#reservationsCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            reservations.rows().deselect();
        }
    });

    function dateReCreator(getDate) {
        var date = new Date(getDate);
        return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}T${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`
    }

    function setStatus(status) {
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
                status_id: status
            },
            success: function (response) {
                if (response === 'Tamamlandı') {
                    selectedRows.remove().draw();
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

    function getRooms(id, reservation_id) {
        var room_type_id = roomTypeEditSelector.val();
        var pan_type_id = panTypeEditSelector.val();
        var start_date = startDateEditSelector.val();
        var end_date = endDateEditSelector.val();

        if (room_type_id != null && pan_type_id != null) {
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.rooms.getRoomsByParameters') }}',
                data: {
                    room_type_id: room_type_id,
                    pan_type_id: pan_type_id,
                    start_date: start_date,
                    end_date: end_date,
                    reservation_id: reservation_id
                },
                success: function (rooms) {
                    roomEditSelector.html('').selectpicker('refresh');
                    roomEditSelector.append(`<option selected hidden disabled></option>`);
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

    roomTypeEditSelector.on('change', function () {
        getRooms($("#selected_reservation_room_id").val(), $("#selected_reservation_id").val());
    });

    panTypeEditSelector.on('change', function () {
        getRooms($("#selected_reservation_room_id").val(), $("#selected_reservation_id").val());
    });

    startDateEditSelector.on('change', function () {
        getRooms($("#selected_reservation_room_id").val(), $("#selected_reservation_id").val());
    });

    endDateEditSelector.on('change', function () {
        getRooms($("#selected_reservation_room_id").val(), $("#selected_reservation_id").val());
    });

    updateReservationButton.click(function () {
        var reservation_id = $("#selected_reservation_id").val();
        var company_id = $("#company_id_edit").val();
        var customer_name = $("#customer_name_edit").val();
        var start_date = $("#start_date_edit").val();
        var end_date = $("#end_date_edit").val();
        var room_type_id = $("#room_type_id_edit").val();
        var pan_type_id = $("#pan_type_id_edit").val();
        var room_id = $("#room_id_edit").val();
        var room_use_type_id = $("#room_use_type_id_edit").val();
        var status_id = $("#selected_reservation_status_id").val();

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
                company_id: company_id,
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
                    reservations.search('').columns().search('').ajax.reload().draw();
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
                url: '{{ route('ajax.customers.save') }}',
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

    reservationEditContext.click(function () {
        var reservation_id = $("#selected_reservation_id").val();
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
                $("#selected_reservation_status_id").val(reservation.status_id);
                $("#selected_reservation_room_id").val(reservation.room_id);
                $("#company_id_edit").val(reservation.company_id).selectpicker('refresh');

                roomTypeEditSelector.val(reservation.room_type.id).selectpicker('refresh');
                panTypeEditSelector.val(reservation.pan_type.id).selectpicker('refresh');

                getRooms(reservation.room_id, reservation.id);

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
                var data = reservationEditCustomers.rows(indexes).data()[0]['DT_RowId'].replace('customer_id_', '');
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

    editReservationSelectCustomerTable.on('select deselect', function (e, dt, type, indexes) {
        var selectedRows = editReservationSelectCustomerTable.rows({selected: true});
        if (selectedRows.count() > 0) {
            editReservationSelectCustomerButton.show();
            if (type === 'row') {
                var data = editReservationSelectCustomerTable.rows(indexes).data()[0]['id'];
                $("#edit_reservation_selected_customer_id").val(data);
            }
        } else {
            editReservationSelectCustomerButton.hide();
            $("#edit_reservation_selected_customer_id").val(null);
        }
    });

    editReservationSelectCustomerButton.click(function () {
        var customer_id = $("#edit_reservation_selected_customer_id").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.customers.edit') }}',
            data: {
                customer_id: customer_id
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

                $("#EditReservationSelectCustomerModal").modal('hide');
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    addExtraReservationButton.click(function () {
        var safe_id = 1;
        var reservation_id = $("#selected_reservation_id").val();
        var extra_id = $("#create_extra_extra_id").val();
        var direction = 1;
        var price = $("#create_extra_price").val();
        var description = $("#create_extra_description").val();
        var date = $("#create_extra_date").val();

        if (reservation_id === '' || reservation_id == null) {
            toastr.error('Rezervasyon Seçiminde Hata Oluştu. Sayfayı Yenilemeyi Deneyin!');
        } else if (extra_id === '' || extra_id == null) {
            toastr.warning('Ekstra Seçimi Yapmadınız!');
        } else if (price === '' || price == null) {
            toastr.warning('Ücret Girmediniz!');
        } else if (date === '' || date == null) {
            toastr.warning('Tarih Seçmediniz!');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.safe-activities.create') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    safe_id: safe_id,
                    reservation_id: reservation_id,
                    extra_id: extra_id,
                    direction: direction,
                    price: price,
                    description: description,
                    date: date
                },
                success: function (safeActivity) {
                    toastr.success('Ekstra Başarıyla Eklendi');
                    $("#AddExtraReservationModal").modal('hide');

                    $('table input').val('');
                    reservations.search('').columns().search('').ajax.reload().draw();
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });
</script>
