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
    })
</script>
