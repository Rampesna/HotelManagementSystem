<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var createRoomTypeContext = $("#createRoomTypeContext");
    var editRoomTypeContext = $("#editRoomTypeContext");
    var deleteRoomTypeContext = $("#deleteRoomTypeContext");

    var createRoomTypeButton = $("#createRoomTypeButton");
    var updateRoomTypeButton = $("#updateRoomTypeButton");
    var deleteRoomTypeButton = $("#deleteRoomTypeButton");

    var roomTypes = $('#roomTypes').DataTable({
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
            var r = $('#roomTypes tfoot tr');
            $('#roomTypes thead').append(r);
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
        ajax: '{!! route('ajax.room-types.index') !!}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'name', name: 'name'}
        ],

        responsive: true,
        select: 'single'
    });

    $('#roomTypes tbody').on('mousedown', 'tr', function (e) {
        if (e.button === 0) {
            return false;
        } else {
            roomTypes.row(this).select();
        }
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = roomTypes.rows({selected: true});
        if (selectedRows.count() > 0) {
            var room_type_id = selectedRows.data()[0].id;
            $("#editing_room_type_id").val(room_type_id);

            editRoomTypeContext.show();
            deleteRoomTypeContext.show();
        } else {
            editRoomTypeContext.hide();
            deleteRoomTypeContext.hide();
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
        if ($.contains($("#roomTypesCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            roomTypes.rows().deselect();
        }
    });

    var EditRoomTypeRightBar = function () {
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
                closeBy: 'edit_room_type_rightbar_close',
                toggleBy: 'edit_room_type_rightbar_toggle'
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
                _element = KTUtil.getById('edit_room_type_rightbar');

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
    EditRoomTypeRightBar.init();

    var CreateRoomTypeRightBar = function () {
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
                closeBy: 'create_room_type_rightbar_close',
                toggleBy: 'create_room_type_rightbar_toggle'
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
                _element = KTUtil.getById('create_room_type_rightbar');

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
    CreateRoomTypeRightBar.init();

    function createRoomType() {
        $("#create_room_type_rightbar_toggle").click();
    }

    function editRoomType() {
        var room_type_id = $("#editing_room_type_id").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.room-types.show') }}',
            data: {
                room_type_id: room_type_id
            },
            success: function (roomType) {
                $("#editing_room_type_id").val(roomType.id);
                $("#editing_room_type_name").val(roomType.name);
            },
            error: function (error) {
                console.log(error)
            }
        });

        $("#edit_room_type_rightbar_toggle").click();
    }

    function deleteRoomType() {
        $("#DeleteRoomTypeModal").modal('show');
    }

    createRoomTypeButton.click(function () {
        var name = $("#creating_room_type_name").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.room-types.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                name: name
            },
            success: function () {
                toastr.success('Yeni Oda Türü Oluşturuldu');
                $("#create_room_type_rightbar_toggle").click();
                roomTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function () {

            }
        });
    });

    updateRoomTypeButton.click(function () {
        var id = $("#editing_room_type_id").val();
        var name = $("#editing_room_type_name").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.room-types.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                name: name
            },
            success: function (room) {
                toastr.success('Başarıyla Güncellendi');
                $("#edit_room_type_rightbar_toggle").click();
                roomTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    deleteRoomTypeButton.click(function () {
        var id = $("#editing_room_type_id").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.room-types.delete') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function () {
                toastr.success('Oda Türü Silindi');
                $("#DeleteRoomTypeModal").modal('hide');
                roomTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
