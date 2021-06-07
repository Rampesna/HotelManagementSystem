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

    function getDayEndReceipts(id) {
        var list = ``;

        $.ajax({
            async: false,
            type: 'get',
            url: '{{ route('ajax.day-ends.receipts') }}',
            data: {
                id: id
            },
            success: function (receipts) {
                console.log(receipts)
                $.each(receipts, function (index) {
                    list = list +
                        `    <tr>` +
                        `        <td>${receipts[index].id}</td>` +
                        `        <td>${reformatDate(receipts[index].date)}</td>` +
                        `        <td>${receipts[index].direction == 1 ? '<span class="btn btn-pill btn-sm btn-danger" style="font-size: 11px; height: 20px; padding-top: 2px">Gider</span>' : '<span class="btn btn-pill btn-sm btn-success" style="font-size: 11px; height: 20px; padding-top: 2px">Gelir</span>'}</td>` +
                        `        <td>${receipts[index].price.toFixed(2)} TL</td>` +
                        `        <td>${receipts[index].payment_type_id ? receipts[index].payment_type.name : '--'}</td>` +
                        `        <td>${receipts[index].description ?? ''}</td>` +
                        `    </tr>`;
                });
            },
            error: function (error) {
                console.log(error)
            }
        });

        // <span class="btn btn-pill btn-sm btn-" style="font-size: 11px; height: 20px; padding-top: 2px"></span>

        return `` +
            `<table class="table" style="padding-left:50px;">` +
            `<thead>` +
            `    <tr>` +
            `        <th>#</th>` +
            `        <th>Tarih</th>` +
            `        <th>İşlem</th>` +
            `        <th>Tutar</th>` +
            `        <th>Ödeme Türü</th>` +
            `        <th>Açıklama</th>` +
            `    </tr>` +
            `</thead>` +
            `<tbody>` +
            list +
            `</tbody>` +
            `</table>`;
    }

    var dayEnds = $('#dayEnds').DataTable({
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

        order: [
            [
                1,
                "desc"
            ]
        ],

        initComplete: function () {
            var r = $('#dayEnds tfoot tr');
            $('#dayEnds thead').append(r);
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
        ajax: {
            type: 'get',
            url: '{{ route('ajax.day-ends.datatable') }}',
            data: {}
        },
        columns: [
            {data: 'id', name: 'id', className: 'details-control cursor-pointer'},
            {data: 'date', name: 'date', className: 'details-control cursor-pointer'},
            {data: 'user_id', name: 'user_id', className: 'details-control cursor-pointer'},
            {data: 'withdrawn', name: 'withdrawn', className: 'details-control cursor-pointer'},
            {data: 'remaining', name: 'remaining', className: 'details-control cursor-pointer'},
        ],

        responsive: true,
        stateSave: false,
        select: 'single'
    });

    $('#dayEnds tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = dayEnds.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(getDayEndReceipts(row.data().id.replace('#', ''))).show();
            tr.addClass('shown');
        }
    }).on('mousedown', 'tr', function (e) {
        if (e.button === 0) {
            return false;
        } else {
            handOvers.row(this).select();
        }
    });

    function dateReCreator(getDate) {
        var date = new Date(getDate);
        return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}T${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`
    }
</script>
