<script>
    $('body').on('contextmenu', function (e) {
        var list = [];

        $(".roomChecker:checked").each(function() {
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
</script>
