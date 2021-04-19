<script src="{{ asset('assets/bundles/fullcalendarscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/fullcalendar/locale/tr.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var showReservationCompanySpan = $("#showReservationCompanySpan");
    var showReservationCustomerSpan = $("#showReservationCustomerSpan");
    var showReservationRoomSpan = $("#showReservationRoomSpan");
    var showReservationStartDateSpan = $("#showReservationStartDateSpan");
    var showReservationEndDateSpan = $("#showReservationEndDateSpan");
    var showReservationStatusSpan = $("#showReservationStatusSpan");
    var showReservationRoomTypeSpan = $("#showReservationRoomTypeSpan");
    var showReservationPanTypeSpan = $("#showReservationPanTypeSpan");

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

    function reformatDateForCalendar(date) {
        var formattedDate = new Date(date);
        return formattedDate.getFullYear() + '-' +
            String(formattedDate.getMonth() + 1).padStart(2, '0') + '-' +
            String(formattedDate.getDate()).padStart(2, '0') + 'T' +
            String(formattedDate.getHours()).padStart(2, '0') + ':' +
            String(formattedDate.getMinutes()).padStart(2, '0') + ':00';
    }

    var reservationsCalendar = $('#reservationsCalendar').fullCalendar({
        defaultView: 'month',
        lang: {
            month: 'Ay'
        },
        header: {
            left: 'month, agendaWeek, listMonth, _prev, _next, today',
            center: '',
            right: 'title',
        },
        contentHeight: 'auto',
        defaultDate: '{{ date('Y-m-d') }}',
        editable: false,
        eventLimit: false,
        nowIndicator: true,
        displayEventTime: false,
        customButtons: {
            _next: {
                text: 'İleri',
                click: function () {
                    reservationsCalendar.fullCalendar('next');
                }
            },
            _prev: {
                text: 'Geri',
                click: function () {
                    reservationsCalendar.fullCalendar('prev');
                }
            }
        },

        dayClick: function (date, jsEvent, view) {

        },

        eventClick: function (calEvent, jsEvent, view) {
            $.ajax({
                type: 'get',
                url: '{{ route('ajax.reservations.edit') }}',
                data: {
                    reservation_id: calEvent.reservation_id
                },
                success: function (reservation) {
                    console.log(reservation)

                    showReservationCompanySpan.html(reservation.company ? reservation.company.title : '--');
                    showReservationCustomerSpan.html(reservation.customer_name);
                    showReservationRoomSpan.html(reservation.room.number);
                    showReservationStartDateSpan.html(reformatDate(reservation.start_date));
                    showReservationEndDateSpan.html(reformatDate(reservation.end_date));
                    showReservationStatusSpan.removeClass().addClass('btn btn-pill btn-sm btn-' + reservation.status.color).html(reservation.status.name);
                    showReservationRoomTypeSpan.html(reservation.room_type.name);
                    showReservationPanTypeSpan.html(reservation.pan_type.name);
                    showReservationCustomers.clear().draw();
                    $.each(reservation.customers, function (index) {
                        showReservationCustomers.row.add([
                            reservation.customers[index].name,
                            reservation.customers[index].surname,
                            reservation.customers[index].title,
                            reservation.customers[index].nationality.name,
                            reservation.customers[index].gender === 1 ? 'Erkek' : 'Kadın'
                        ]);
                    });
                    showReservationCustomers.draw();
                },
                error: function (error) {
                    console.log(error)
                }
            });
            $("#show_reservation_rightbar_toggle").click();
        },

        events: function(start, end, timezone, callback) {
            $.ajax({
                url: '{{ route('ajax.reservations.calendar') }}',
                dataType: 'json',
                data: {
                    start_date: start.format(),
                    end_date: end.format()
                },
                success: function(reservations) {
                    var events = [];

                    $.each(reservations, function (index) {
                        events.push({
                            _id: reservations[index].id,
                            id: reservations[index].id,
                            type: 'reservation',
                            title: `${reservations[index].customer_name} - ${reservations[index].room.number}`,
                            start: reformatDateForCalendar(reservations[index].start_date),
                            end: reformatDateForCalendar(reservations[index].end_date),
                            url: 'javascript:void(0)',
                            className: `fc-event-light fc-event-solid-${reservations[index].status.color}`,
                            reservation_id: reservations[index].id,

                        });
                    });
                    callback(events);
                }
            });
        }

        {{--events: [--}}
        {{--        @foreach($reservations as $reservation)--}}
        {{--    {--}}
        {{--        _id: '{{ $reservation->id }}',--}}
        {{--        id: '{{ $reservation->id }}',--}}
        {{--        type: 'reservation',--}}
        {{--        title: '{{ $reservation->customer_name }} - {{ $reservation->room->number }}',--}}
        {{--        start: '{{ strftime("%Y-%m-%dT%H:%M:%S",strtotime($reservation->start_date)) }}',--}}
        {{--        end: '{{ strftime("%Y-%m-%dT%H:%M:%S",strtotime($reservation->end_date)) }}',--}}
        {{--        url: 'javascript:void(0);',--}}
        {{--        className: 'fc-event-light fc-event-solid-{{ $reservation->status->color }}',--}}
        {{--        reservation_id: '{{ $reservation->id }}'--}}
        {{--    },--}}
        {{--        @endforeach--}}
        {{--]--}}
    });

    var showReservationCustomers = $('#showReservationCustomers').DataTable({
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

    var ShowReservationRightBar = function () {
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
                closeBy: 'show_reservation_rightbar_close',
                toggleBy: 'show_reservation_rightbar_toggle'
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
                _element = KTUtil.getById('show_reservation_rightbar');

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
    ShowReservationRightBar.init();
</script>
