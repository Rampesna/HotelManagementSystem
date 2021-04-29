<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var createRoomContext = $("#createRoomContext");
    var editRoomContext = $("#editRoomContext");
    var deleteRoomContext = $("#deleteRoomContext");

    var createRoomButton = $("#createRoomButton");
    var updateRoomButton = $("#updateRoomButton");
    var deleteRoomButton = $("#deleteRoomButton");

    var rooms = $('#rooms').DataTable({
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
            var r = $('#rooms tfoot tr');
            $('#rooms thead').append(r);
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
        ajax: '{!! route('ajax.rooms.index') !!}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'number', name: 'number'},
            {data: 'price', name: 'price'},
            {data: 'room_type_id', name: 'room_type_id'},
            {data: 'pan_type_id', name: 'pan_type_id'},
            {data: 'person_count', name: 'person_count'}
        ],

        responsive: true,
        select: 'single'
    });

    $('#rooms tbody').on('mousedown', 'tr', function (e) {
        if (e.button === 0) {
            return false;
        } else {
            rooms.row(this).select();
        }
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = rooms.rows({selected: true});
        if (selectedRows.count() > 0) {
            var room_id = selectedRows.data()[0].id;
            $("#editing_room_id").val(room_id);

            editRoomContext.show();
            deleteRoomContext.show();
        } else {
            editRoomContext.hide();
            deleteRoomContext.hide();
        }

        var top = e.pageY - 10;
        var left = e.pageX - 10;

        $("#context-menu").css({
            display: "block",
            top: top,
            left: left
        });

        return false;
    }).on("click", function () {
        $("#context-menu").hide();
    }).on('focusout', function () {
        $("#context-menu").hide();
    });

    $(document).click((e) => {
        if ($.contains($("#roomsCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            rooms.rows().deselect();
        }
    });

    var EditRoomRightBar = function () {
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
                closeBy: 'edit_room_rightbar_close',
                toggleBy: 'edit_room_rightbar_toggle'
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
                _element = KTUtil.getById('edit_room_rightbar');

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
    EditRoomRightBar.init();

    var CreateRoomRightBar = function () {
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
                closeBy: 'create_room_rightbar_close',
                toggleBy: 'create_room_rightbar_toggle'
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
                _element = KTUtil.getById('create_room_rightbar');

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
    CreateRoomRightBar.init();

    function createRoom() {
        $("#create_room_rightbar_toggle").click();
    }

    function editRoom() {
        var room_id = $("#editing_room_id").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.rooms.show') }}',
            data: {
                room_id: room_id
            },
            success: function (room) {
                $("#editing_room_number").val(room.number);
                $("#editing_room_price").val(room.price);
                $("#editing_room_person_count").val(room.person_count);
                $("#editing_room_room_status_id").val(room.room_status_id);
                $("#editing_room_room_type_id").val(room.room_type_id).selectpicker('refresh');
                $("#editing_room_pan_type_id").val(room.pan_type_id).selectpicker('refresh');
            },
            error: function (error) {
                console.log(error)
            }
        });

        $("#edit_room_rightbar_toggle").click();
    }

    function deleteRoom() {
        $("#DeleteRoomModal").modal('show');
    }

    createRoomButton.click(function () {
        var room_status_id = 1;
        var room_type_id = $("#creating_room_room_type_id").val();
        var pan_type_id = $("#creating_room_pan_type_id").val();
        var bad_type_id = 1;
        var number = $("#creating_room_number").val();
        var person_count = $("#creating_room_person_count").val();
        var price = $("#creating_room_price").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.rooms.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                room_status_id: room_status_id,
                room_type_id: room_type_id,
                pan_type_id: pan_type_id,
                bad_type_id: bad_type_id,
                number: number,
                person_count: person_count,
                price: price
            },
            success: function (room) {
                toastr.success('Yeni Oda Oluşturuldu');
                $("#create_room_rightbar_toggle").click();
                rooms.search('').columns().search('').ajax.reload().draw();
            },
            error: function () {

            }
        });
    });

    updateRoomButton.click(function () {
        var id = $("#editing_room_id").val();
        var room_status_id = $("#editing_room_room_status_id").val();
        var room_type_id = $("#editing_room_room_type_id").val();
        var pan_type_id = $("#editing_room_pan_type_id").val();
        var bad_type_id = 1;
        var number = $("#editing_room_number").val();
        var person_count = $("#editing_room_person_count").val();
        var price = $("#editing_room_price").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.rooms.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                room_status_id: room_status_id,
                room_type_id: room_type_id,
                pan_type_id: pan_type_id,
                bad_type_id: bad_type_id,
                number: number,
                person_count: person_count,
                price: price
            },
            success: function (room) {
                toastr.success('Başarıyla Güncellendi');
                $("#edit_room_rightbar_toggle").click();
                rooms.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    deleteRoomButton.click(function () {
        var id = $("#editing_room_id").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.rooms.delete') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function () {
                toastr.success('Oda Silindi');
                $("#DeleteRoomModal").modal('hide');
                rooms.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
