<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var createExtraContext = $("#createExtraContext");
    var editExtraContext = $("#editExtraContext");
    var deleteExtraContext = $("#deleteExtraContext");

    var createExtraButton = $("#createExtraButton");
    var updateExtraButton = $("#updateExtraButton");
    var deleteExtraButton = $("#deleteExtraButton");

    var extras = $('#extras').DataTable({
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
            var r = $('#extras tfoot tr');
            $('#extras thead').append(r);
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
        ajax: '{!! route('ajax.extras.index') !!}',
        columns: [
            {data: 'id', name: 'id', width: "3%"},
            {data: 'name', name: 'name'}
        ],

        responsive: true,
        select: 'single'
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = extras.rows({selected: true});
        if (selectedRows.count() > 0) {
            var extra_id = selectedRows.data()[0].id;
            $("#editing_extra_id").val(extra_id);

            editExtraContext.show();
            deleteExtraContext.show();
        } else {
            editExtraContext.hide();
            deleteExtraContext.hide();
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
        if ($.contains($("#extrasCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            extras.rows().deselect();
        }
    });

    var EditExtraRightBar = function () {
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
                closeBy: 'edit_extra_rightbar_close',
                toggleBy: 'edit_extra_rightbar_toggle'
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
                _element = KTUtil.getById('edit_extra_rightbar');

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
    EditExtraRightBar.init();

    var CreateExtraRightBar = function () {
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
                closeBy: 'create_extra_rightbar_close',
                toggleBy: 'create_extra_rightbar_toggle'
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
                _element = KTUtil.getById('create_extra_rightbar');

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
    CreateExtraRightBar.init();

    function createExtra() {
        $("#create_extra_rightbar_toggle").click();
    }

    function editExtra() {
        var extra_id = $("#editing_extra_id").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.extras.show') }}',
            data: {
                extra_id: extra_id
            },
            success: function (extra) {
                $("#editing_extra_id").val(extra.id);
                $("#editing_extra_name").val(extra.name);
            },
            error: function (error) {
                console.log(error)
            }
        });

        $("#edit_extra_rightbar_toggle").click();
    }

    function deleteExtra() {
        $("#DeleteExtraModal").modal('show');
    }

    createExtraButton.click(function () {
        var name = $("#creating_extra_name").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.extras.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                name: name
            },
            success: function () {
                toastr.success('Yeni Extra Oluşturuldu');
                $("#create_extra_rightbar_toggle").click();
                extras.search('').columns().search('').ajax.reload().draw();
            },
            error: function () {

            }
        });
    });

    updateExtraButton.click(function () {
        var id = $("#editing_extra_id").val();
        var name = $("#editing_extra_name").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.extras.save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                name: name
            },
            success: function () {
                toastr.success('Başarıyla Güncellendi');
                $("#edit_extra_rightbar_toggle").click();
                extras.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    deleteExtraButton.click(function () {
        var id = $("#editing_extra_id").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.extras.delete') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function () {
                toastr.success('Extra Silindi');
                $("#DeleteExtraModal").modal('hide');
                extras.search('').columns().search('').ajax.reload().draw();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
