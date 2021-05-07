<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var getPaymentButton = $("#getPaymentButton");

    var waitingPayments = $('#waitingPayments').DataTable({
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
            var r = $('#waitingPayments tfoot tr');
            $('#waitingPayments thead').append(r);
            this.api().columns().every(function (index) {
                var column = this;
                var input = document.createElement('input');
                if (index === 0 || index === 3) {
                    input = null;
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    return;
                } else if (index === 4 || index === 5 || index === 6) {
                    input.setAttribute("type", "datetime-local");
                } else if (index === 2) {
                    input = document.createElement('select');
                    var option = document.createElement("option");
                    option.setAttribute("value", 2);
                    option.innerHTML = "Tümü";
                    input.appendChild(option);

                    option = document.createElement("option");
                    option.setAttribute("value", 1);
                    option.innerHTML = "Ödendi";
                    input.appendChild(option);

                    option = document.createElement("option");
                    option.setAttribute("value", 0);
                    option.innerHTML = "Bekliyor";
                    input.appendChild(option);
                }
                input.className = 'form-control';
                $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        },

        order: [
            [0, "desc"]
        ],

        // createdRow: function (row, data, index) {
        //     $('td', row).eq(2).addClass('text-center'); // 6 is index of column
        // },

        processing: true,
        serverSide: true,
        ajax: '{{ route('ajax.waiting-payments.index') }}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'customer_name', name: 'customer_name', width: "15%"},
            {data: 'paid', name: 'paid', width: "7%"},
            {data: 'price', name: 'price', width: "10%"},
            {data: 'paid_date', name: 'paid_date', width: "15%"},
            {data: 'user_id', name: 'user_id', width: "10%"},
            {data: 'start_date', name: 'start_date', width: "15%"},
            {data: 'end_date', name: 'end_date', width: "15%"}
        ],

        responsive: true,
        select: 'single'
    });

    function getPayment() {
        $("#GetPaymentModal").modal('show');
    }

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

    $('#waitingPayments tbody').on('mousedown', 'tr', function (e) {
        if (e.button === 0) {
            return false;
        } else {
            waitingPayments.row(this).select();
        }
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = waitingPayments.rows({selected: true});
        if (selectedRows.count() > 0) {
            if (selectedRows.data()[0].is_paid == 0) {
                $("#waiting_payment_id").val(selectedRows.data()[0].id);

                var top = e.pageY - 10;
                var left = e.pageX - 10;

                $("#context-menu").css({
                    display: "block",
                    top: top,
                    left: left
                });
            }
        }
        return false;
    }).on("click", function () {
        $("#context-menu").hide();
    }).on('focusout', function () {
        $("#context-menu").hide();
    });

    $(document).click((e) => {
        if ($.contains($("#waitingPaymentsCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            waitingPayments.rows().deselect();
        }
    });

    getPaymentButton.click(function () {
        var waiting_payment_id = $("#waiting_payment_id").val();
        var paid_date = $("#paid_date").val();

        if (waiting_payment_id == null || waiting_payment_id === '') {
            toastr.error('Ödeme Seçiminde Sistemsel Bir Hata Oluştu!');
        } else if (paid_date == null || paid_date === '') {
            toastr.warning('Ödeme Tarihini Seçmediniz!');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.waiting-payments.getPayment') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    waiting_payment_id: waiting_payment_id,
                    paid_date: paid_date
                },
                success: function (response) {
                    $("#GetPaymentModal").modal('hide');
                    $("#GetPaymentForm").trigger('reset');
                    waitingPayments.search('').columns().search('').ajax.reload().draw();
                    toastr.success('Ödeme Başarıyla Alındı');
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });
</script>
