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

    function getHandOverReceipts(reservation) {
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
                        `        <td>${extras[index].direction == 1 ? '<span class="btn btn-pill btn-sm btn-danger" style="font-size: 11px; height: 20px; padding-top: 2px">Gider</span>' : '<span class="btn btn-pill btn-sm btn-success" style="font-size: 11px; height: 20px; padding-top: 2px">Gelir</span>'}</td>` +
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

        // <span class="btn btn-pill btn-sm btn-" style="font-size: 11px; height: 20px; padding-top: 2px"></span>

        return `` +
            `<table id="${reservation.id}" class="table" style="padding-left:50px;">` +
            `<thead>` +
            `    <tr>` +
            `        <th>#</th>` +
            `        <th>İşlem</th>` +
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

    var handOvers = $('#handOvers').DataTable({
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
            var r = $('#handOvers tfoot tr');
            $('#handOvers thead').append(r);
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
            url: '{{ route('ajax.hand-overs.datatable') }}',
            data: {}
        },
        columns: [
            {data: 'id', name: 'id', className: 'details-control cursor-pointer'},
            {data: 'created_at', name: 'created_at', className: 'details-control cursor-pointer'},
            {data: 'from', name: 'from', className: 'details-control cursor-pointer'},
            {data: 'to', name: 'to', className: 'details-control cursor-pointer'},
            {data: 'incoming', name: 'incoming', className: 'details-control cursor-pointer'},
            {data: 'outgoing', name: 'outgoing', className: 'details-control cursor-pointer'},
            {data: 'total', name: 'total', className: 'details-control cursor-pointer'},
        ],

        responsive: true,
        stateSave: false,
        select: 'single'
    });

    $('#handOvers tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = handOvers.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(getHandOverReceipts(row.data())).show();
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
