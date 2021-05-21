<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    var updateUserManagementDepartmentsButton = $("#updateUserManagementDepartmentsButton");

    var table = $('#users').DataTable({
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

        dom: 'frtipl',

        columnDefs: [
            {
                targets: 5,
                width: "5%",
                orderable: false,
                order: false
            },
        ],

        responsive: true
    });
</script>

<script>
    $("#user_create").click(function () {
        var companies = $("#companies_create").val();
        var name = $("#name_create").val();
        var email = $("#email_create").val();
        var phone_number = $("#phone_number_create").val();
        var activate_type = $("#activate_type_create").val();
        var identification_number = $("#identification_number_create").val();
        var role_id = $("#role_id_create").val();
        var password = $("#password_create").val();

        if (name == null || name === '') {
            toastr.warning('Ad Soyad Girilmesi Zorunludur');
        } else if (email == null || email === '') {
            toastr.warning('E-posta Adresi Girilmesi Zorunludur!');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.user.emailControl') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function (response) {
                    if (response === 'exist') {
                        toastr.warning('Bu E-posta Adresi Zaten Sistemde Kayıtlı!');
                    } else {
                        if (activate_type == null || activate_type === '') {
                            toastr.warning('Aktivasyon Türü Seçilmesi Zorunludur!');
                        } else if (role_id == null || role_id === '') {
                            toastr.warning('Kullanıcı Rolü Seçilmesi Zorunludur!');
                        } else if (password == null || password === '') {
                            toastr.warning('Şifre Boş Olamaz');
                        } else if (password.length < 8) {
                            toastr.warning('Şifre En Az 8 Haneli Olmalıdır!');
                        } else {
                            $.ajax({
                                type: 'post',
                                url: '{{ route('management.users.save') }}',
                                dataType: 'json',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    companies: companies,
                                    name: name,
                                    email: email,
                                    phone_number: phone_number,
                                    identification_number: identification_number,
                                    activate_type: activate_type,
                                    role_id: role_id,
                                    password: password,
                                    create: 1
                                },
                                success: function () {
                                    toastr.success('Yeni Kullanıcı Başarıyla Oluşturuldu');
                                    $("#CreateModal").modal('hide');
                                    setTimeout(location.reload(), 1000);
                                },
                                error: function (error) {
                                    console.log(error);
                                    toastr.eror('Sistemsel Bir Hata Oluştu!');
                                }
                            });
                        }
                    }
                },
                error: function () {
                    toastr.warning('E-posta Kontrolü Yapılırken Bir Hata Oluştu!');
                }
            });
        }
    });
</script>

<script>
    $(".edit").click(function () {
        var id = $(this).data('id');
        $("#updated_user_id").val(id);
        $.ajax({
            type: 'get',
            url: '{{ route('management.users.edit') }}',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (user) {
                $("#companies_edit").val(user.companies).selectpicker('refresh');
                $("#name_edit").val(user.name);
            },
            error: function () {

            }
        });
    });
</script>

<script>
    $("#user_update").click(function () {
        var id = $("#updated_user_id").val();
        var companies = $("#companies_edit").val();
        var name = $("#name_edit").val();

        if (id == null || id === '') {
            toastr.warning('Bir Hata Oluştu. Lütfen Sayfayı Yenileyip Tekrar Deneyin.');
        } else if (companies == null || companies === '') {
            toastr.warning('Firma Seçilmesi Zorunludur');
        } else if (name == null || name === '') {
            toastr.warning('Yetkinlik Adı Girilmesi Zorunludur');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('management.users.save') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    companies: companies,
                    name: name
                },
                success: function () {
                    toastr.success('Kullanıcı Başarıyla Güncellendi');
                    $("#EditModal").modal('hide');
                    setTimeout(location.reload(), 1000);
                },
                error: function () {

                }
            });
        }
    });
</script>

<script>
    $(".delete").click(function () {
        var id = $(this).data('id');
        $("#deleted_user_id").val(id);
    });
</script>

<script>
    $("#delete_user").click(function () {
        var id = $("#deleted_user_id").val();
        $.ajax({
            type: 'post',
            url: '{{ route('management.users.delete') }}',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function () {
                table.row($("#row-" + id).closest('tr')).remove().draw();
                toastr.success('Kullanıcı Başarıyla Silindi');
                $("#DeleteModal").modal('hide');
            },
            error: function () {

            }
        });
    });
</script>
