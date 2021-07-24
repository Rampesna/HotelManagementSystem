<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var CreateButton = $("#CreateButton");
    var UpdateButton = $("#UpdateButton");
    var DeleteButton = $("#DeleteButton");

    var editContexts = $("#editContexts");

    var users = $('#users').DataTable({
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
            var r = $('#users tfoot tr');
            $('#users thead').append(r);
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
        ajax: '{!! route('ajax.user.index') !!}',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'role_id', name: 'role_id'},
            {data: 'suspend', name: 'suspend'},
            {data: 'email', name: 'email'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'identification_number', name: 'identification_number'}
        ],

        responsive: true,
        select: 'single'
    });

    $('#users tbody').on('mousedown', 'tr', function (e) {
        if (e.button === 0) {
            return false;
        } else {
            users.row(this).select();
        }
    });

    $('body').on('contextmenu', function (e) {
        var selectedRows = users.rows({selected: true});
        if (selectedRows.count() > 0) {
            var id = selectedRows.data()[0].id;
            $("#id_edit").val(id);

            editContexts.show();
        } else {
            editContexts.hide();
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
        if ($.contains($("#usersCard").get(0), e.target)) {
        } else {
            $("#context-menu").hide();
            users.rows().deselect();
        }
    });

    function create() {
        $("#CreateModal").modal('show');
    }

    function edit() {
        var id = $("#id_edit").val();

        $.ajax({
            type: 'get',
            url: '{{ route('ajax.user.show') }}',
            data: {
                id: id
            },
            success: function (user) {
                $('#name_edit').val(user.name);
                $('#email_edit').val(user.email);
                $('#phone_number_edit').val(user.phone_number);
                $('#identification_number_edit').val(user.identification_number);
                $('#role_id_edit').val(user.role_id);
                $("#EditModal").modal('show');
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    function drop() {
        $("#DeleteModal").modal('show');
    }

    CreateButton.click(function () {
        var role_id = $('#role_id_create').val();
        var name = $('#name_create').val();
        var email = $('#email_create').val();
        var phone_number = $('#phone_number_create').val();
        var identification_number = $('#identification_number_create').val();
        var password = $('#password_create').val();

        if (name == null || name === '') {
            toastr.warning('Ad Soyad Boş Olamaz!');
        } else if (email == null || email === '') {
            toastr.warning('E-posta Adresi Boş Olamaz!');
        } else if (password == null || password === '') {
            toastr.warning('Şifre Boş Olamaz!');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.user.emailControl') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function (response) {
                    if (response === 'not') {
                        save({
                            _token: '{{ csrf_token() }}',
                            role_id: role_id,
                            name: name,
                            email: email,
                            phone_number: phone_number,
                            identification_number: identification_number,
                            password: password,
                        }, 0);
                    } else {
                        toastr.warning('Bu E-posta Adresi Başka Bir Kullanıcıya Ait!');
                    }
                },
                error: function (error) {
                    toastr.error('E-posta Kontrolü Yapılırken Sistemsel Bir Hata Oluştu!');
                    console.log(error)
                }
            });
        }
    });

    UpdateButton.click(function () {
        var id = $('#id_edit').val();
        var role_id = $('#role_id_edit').val();
        var name = $('#name_edit').val();
        var email = $('#email_edit').val();
        var phone_number = $('#phone_number_edit').val();
        var identification_number = $('#identification_number_edit').val();
        var password = $('#password_edit').val();

        if (name == null || name === '') {
            toastr.warning('Ad Soyad Boş Olamaz!');
        } else if (email == null || email === '') {
            toastr.warning('E-posta Adresi Boş Olamaz!');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.user.emailControl') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email,
                    except_id: id
                },
                success: function (response) {
                    if (response === 'not') {
                        save({
                            _token: '{{ csrf_token() }}',
                            id: id,
                            role_id: role_id,
                            name: name,
                            email: email,
                            phone_number: phone_number,
                            identification_number: identification_number,
                            password: password,
                        }, 1);
                    } else {
                        toastr.warning('Bu E-posta Adresi Başka Bir Kullanıcıya Ait!');
                    }
                },
                error: function (error) {
                    toastr.error('E-posta Kontrolü Yapılırken Sistemsel Bir Hata Oluştu!');
                    console.log(error)
                }
            });
        }
    });

    DeleteButton.click(function () {
        var id = $("#id_edit").val();

        $.ajax({
            type: 'delete',
            url: '{{ route('ajax.user.delete') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function () {
                toastr.success('Kullanıcı Silindi');
                $("#DeleteModal").modal('hide');
                users.ajax.reload();
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    function save(data, direction) {
        $.ajax({
            type: 'post',
            url: '{{ route('ajax.user.save') }}',
            data: data,
            success: function () {
                if (direction === 0) {
                    $('#CreateModal').modal('hide');
                } else {
                    $('#EditModal').modal('hide');
                }
                users.ajax.reload();
            },
            error: function (error) {
                toastr.error('Kaydedilirken Sistemsel Bir Hata Oluştu!');
                console.log(error)
            }
        });
    }
</script>
