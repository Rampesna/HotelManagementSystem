<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var createRoomUseTypeContext = $("#createRoomUseTypeContext");
    var editRoomUseTypeContext = $("#editRoomUseTypeContext");
    var deleteRoomUseTypeContext = $("#deleteRoomUseTypeContext");

    var createRoomUseTypeButton = $("#createRoomUseTypeButton");
    var updateRoomUseTypeButton = $("#updateRoomUseTypeButton");
    var deleteRoomUseTypeButton = $("#deleteRoomUseTypeButton");

    var roomUseTypes = $('#roomUseTypes').DataTable({
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
            var r = $('#roomUseTypes tfoot tr');
            $('#roomUseTypes thead').append(r);
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
        ajax: '{!! route('ajax.room-use-types.index') !!}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'name', name: 'name'}
        ],

        responsive: true,
        select: 'single'
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = roomUseTypes.rows({selected: true});
        if (selectedRows.count() > 0) {
            var room_use_type_id = selectedRows.data()[0].id;
            $("#editing_room_use_type_id").val(room_use_type_id);

            editRoomUseTypeContext.show();
            deleteRoomUseTypeContext.show();
        } else {
            editRoomUseTypeContext.hide();
            deleteRoomUseTypeContext.hide();
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
        if ($.contains($("#roomUseTypesCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            roomUseTypes.rows().deselect();
        }
    });

    var EditRoomUseTypeRightBar = function () {
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
                closeBy: 'edit_room_use_type_rightbar_close',
                toggleBy: 'edit_room_use_type_rightbar_toggle'
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
                _element = KTUtil.getById('edit_room_use_type_rightbar');

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
    EditRoomUseTypeRightBar.init();

    var CreateRoomUseTypeRightBar = function () {
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
                closeBy: 'create_room_use_type_rightbar_close',
                toggleBy: 'create_room_use_type_rightbar_toggle'
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
                _element = KTUtil.getById('create_room_use_type_rightbar');

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
    CreateRoomUseTypeRightBar.init();

    function createRoomUseType() {
        $("#create_room_use_type_rightbar_toggle").click();
    }

    function editRoomUseType() {
        var room_use_type_id = $("#editing_room_use_type_id").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.room-use-types.show') }}',
            data: {
                room_use_type_id: room_use_type_id
            },
            success: function (roomUseType) {
                $("#editing_room_use_type_id").val(roomUseType.id);
                $("#editing_room_use_type_name").val(roomUseType.name);
                $("#editing_room_use_type_short").val(roomUseType.short);
            },
            error: function (error) {
                console.log(error)
            }
        });

        $("#edit_room_use_type_rightbar_toggle").click();
    }

    function deleteRoomUseType() {
        $("#DeleteRoomUseTypeModal").modal('show');
    }

    createRoomUseTypeButton.click(function () {
        var name = $("#creating_room_use_type_name").val();
        var short = $("#creating_room_use_type_short").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.room-use-types.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                name: name,
                short: short
            },
            success: function () {
                toastr.success('Yeni Oda Kullanım Türü Oluşturuldu');
                $("#create_room_use_type_rightbar_toggle").click();
                roomUseTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    updateRoomUseTypeButton.click(function () {
        var id = $("#editing_room_use_type_id").val();
        var name = $("#editing_room_use_type_name").val();
        var short = $("#editing_room_use_type_short").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.room-use-types.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                name: name,
                short: short
            },
            success: function () {
                toastr.success('Başarıyla Güncellendi');
                $("#edit_room_use_type_rightbar_toggle").click();
                roomUseTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    deleteRoomUseTypeButton.click(function () {
        var id = $("#editing_room_use_type_id").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.room-use-types.delete') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function () {
                toastr.success('Oda Kullanım Türü Silindi');
                $("#DeleteRoomUseTypeModal").modal('hide');
                roomUseTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
