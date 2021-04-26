<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>
    var receipts = $('#receipts').DataTable({
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
            var r = $('#receipts tfoot tr');
            $('#receipts thead').append(r);
            this.api().columns().every(function (index) {
                var column = this;
                var input = document.createElement('input');
                if (index === 0 || index === 1) {
                    input = null;
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    return;
                } else if (index === 2) {
                    input = document.createElement('select');
                    var option = document.createElement("option");
                    option.setAttribute("value", 2);
                    option.innerHTML = "Tümü";
                    input.appendChild(option);

                    option = document.createElement("option");
                    option.setAttribute("value", 1);
                    option.innerHTML = "Gelir";
                    input.appendChild(option);

                    option = document.createElement("option");
                    option.setAttribute("value", 0);
                    option.innerHTML = "Gider";
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

        createdRow: function (row, data, index) {
            $('td', row).eq(2).addClass('text-center'); // 6 is index of column
        },

        processing: true,
        serverSide: true,
        ajax: '{!! route('ajax.receipts.index') !!}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'date', name: 'date', width: "12%"},
            {data: 'direction', name: 'direction', width: "10%"},
            {data: 'price', name: 'price', width: "12%"},
            {data: 'user_id', name: 'user_id', width: "13%"},
            {data: 'description', name: 'description'}
        ],

        responsive: true,
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
</script>
