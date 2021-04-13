<script>
    $('body').on('contextmenu', function (e) {
        var list = [];

        $(".roomChecker:checked").each(function () {
            list.push($(this).data('id'));
        });

        if (list.length > 0) {
            var top = e.pageY - 10;
            var left = e.pageX - 10;

            $("#context-menu").css({
                display: "block",
                top: top,
                left: left
            });

            console.log(list)
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

    $(document).delegate('.roomStatusSelector', 'click', function () {
        room_id = $(this).data('id');
        status_id = $(this).data('status-id');

        var list = $(this).parent().parent().find('.dropdown_icon_selector');

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.rooms.setRoomStatus') }}',
            data: {
                _token: '{{ csrf_token() }}',
                room_id: room_id,
                status_id: status_id
            },
            success: function (room) {
                console.log(room)
                $("#room_span_id_" + room.id).removeClass().addClass('btn btn-pill btn-sm btn-' + room.status.color).html(room.status.name);

                $.each(list, function (index) {
                    $(this).removeClass();
                    if (status_id == (index + 1)) {
                        $(this).addClass('dropdown_icon_selector fa fa-check-circle text-success');
                    } else {
                        $(this).addClass(' dropdown_icon_selector fa fa-check-circle ');
                    }
                });
            },
            error: function () {

            }
        });
    });

    function openAddExtraModal()
    {
        $("#AddExtraReservationModal").modal('show');
    }

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
                url: '{{ route('ajax.extras.create') }}',
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
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });
</script>
