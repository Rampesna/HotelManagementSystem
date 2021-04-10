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
                text: '<i class="fas fa-undo"></i> Yenile',
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
                } else if (index === 4 || index === 6 || index === 7) {
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
        ajax: '{!! route('ajax.safes.reservations') !!}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'status_id', name: 'status_id'},
            {data: 'room_id', name: 'room_id'},
            {data: 'price', name: 'price', orderable: false},
            {data: 'payments', name: 'payments', orderable: false}
        ],

        responsive: true,
        stateSave: true,
        select: 'single'
    });

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

    var getPaidSelector = $("#getPaid");
    var endReservationSelector = $("#endReservation");
    var getPaymentButton = $("#getPaymentButton");

    $('.card').on('contextmenu', function (e) {
        var selectedRows = reservations.rows({selected: true});
        if (selectedRows.count() > 0) {
            var reservation_id = selectedRows.data()[0].id.replace('#', '');
            $("#selected_reservation_id").val(reservation_id);

            reservationAndSafeActivities = null;

            $.ajax({
                async: false,
                type: 'get',
                url: '{{ route('ajax.reservations.debtControl') }}',
                data: {
                    reservation_id: reservation_id
                },
                success: function (response) {
                    reservationAndSafeActivities = response;
                },
                error: function (error) {
                    console.log(error)
                }
            });

            if (reservationAndSafeActivities.reservation.status_id === 5) {
                if ((reservationAndSafeActivities.outgoing - reservationAndSafeActivities.incoming) > 0) {
                    getPaidSelector.show();
                    endReservationSelector.hide();
                } else {
                    getPaidSelector.hide();
                    endReservationSelector.show();
                }

                var top = e.pageY - 10;
                var left = e.pageX - 10;

                $("#context-menu").css({
                    display: "block",
                    top: top,
                    left: left
                });
            } else {
                return false;
            }
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

    getPaymentButton.click(function () {
        var reservation_id = $("#selected_reservation_id").val();
        var payment_type_id = $("#payment_type_id").val();
        var price = $("#price").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.safes.getPayment') }}',
            data: {
                _token: '{{ csrf_token() }}',
                reservation_id: reservation_id,
                payment_type_id: payment_type_id,
                price: price
            },
            success: function (response) {
                toastr.success('Ödeme Başarıyla Alındı');
                $("#GetPaymentModal").modal('hide');
                $("#GetPaymentForm").trigger('reset');
                $('table input').val('');
                reservations.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
