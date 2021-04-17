<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var createPanTypeContext = $("#createPanTypeContext");
    var editPanTypeContext = $("#editPanTypeContext");
    var deletePanTypeContext = $("#deletePanTypeContext");

    var createPanTypeButton = $("#createPanTypeButton");
    var updatePanTypeButton = $("#updatePanTypeButton");
    var deletePanTypeButton = $("#deletePanTypeButton");

    var panTypes = $('#panTypes').DataTable({
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
            var r = $('#panTypes tfoot tr');
            $('#panTypes thead').append(r);
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
        ajax: '{!! route('ajax.pan-types.index') !!}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'name', name: 'name'}
        ],

        responsive: true,
        select: 'single'
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = panTypes.rows({selected: true});
        if (selectedRows.count() > 0) {
            var pan_type_id = selectedRows.data()[0].id;
            $("#editing_pan_type_id").val(pan_type_id);

            editPanTypeContext.show();
            deletePanTypeContext.show();
        } else {
            editPanTypeContext.hide();
            deletePanTypeContext.hide();
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
        if ($.contains($("#panTypesCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            panTypes.rows().deselect();
        }
    });

    var EditPanTypeRightBar = function () {
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
                closeBy: 'edit_pan_type_rightbar_close',
                toggleBy: 'edit_pan_type_rightbar_toggle'
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
                _element = KTUtil.getById('edit_pan_type_rightbar');

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
    EditPanTypeRightBar.init();

    var CreatePanTypeRightBar = function () {
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
                closeBy: 'create_pan_type_rightbar_close',
                toggleBy: 'create_pan_type_rightbar_toggle'
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
                _element = KTUtil.getById('create_pan_type_rightbar');

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
    CreatePanTypeRightBar.init();

    function createPanType() {
        $("#create_pan_type_rightbar_toggle").click();
    }

    function editPanType() {
        var pan_type_id = $("#editing_pan_type_id").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.pan-types.show') }}',
            data: {
                pan_type_id: pan_type_id
            },
            success: function (panType) {
                $("#editing_pan_type_id").val(panType.id);
                $("#editing_pan_type_name").val(panType.name);
            },
            error: function (error) {
                console.log(error)
            }
        });

        $("#edit_pan_type_rightbar_toggle").click();
    }

    function deletePanType() {
        $("#DeletePanTypeModal").modal('show');
    }

    createPanTypeButton.click(function () {
        var name = $("#creating_pan_type_name").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.pan-types.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                name: name
            },
            success: function () {
                toastr.success('Yeni Pan Türü Oluşturuldu');
                $("#create_pan_type_rightbar_toggle").click();
                panTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function () {

            }
        });
    });

    updatePanTypeButton.click(function () {
        var id = $("#editing_pan_type_id").val();
        var name = $("#editing_pan_type_name").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.rooms.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                name: name
            },
            success: function () {
                toastr.success('Başarıyla Güncellendi');
                $("#edit_pan_type_rightbar_toggle").click();
                panTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    deletePanTypeButton.click(function () {
        var id = $("#editing_pan_type_id").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.pan-types.delete') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function () {
                toastr.success('Pan Türü Silindi');
                $("#DeletePanTypeModal").modal('hide');
                panTypes.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
