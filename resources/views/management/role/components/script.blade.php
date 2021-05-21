<script>
    $("#role_create").click(function () {
        var name = $("#name_create").val();
        var description = $("#description_create").val();

        if (name == null || name === '') {
            toastr.warning('Rol Adı Girilmesi Zorunludur');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('setting.roles.store') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    description: description
                },
                success: function () {
                    toastr.success('Yeni Rol Başarıyla Oluşturuldu');
                    $("#CreateModal").modal('hide');
                    setTimeout(location.reload(), 1000);
                },
                error: function () {

                }
            });
        }
    });
</script>

<script>
    $(".edit").click(function () {
        var id = $(this).data('id');
        $("#updated_role_id").val(id);
        $.ajax({
            type: 'get',
            url: '{{ route('setting.roles.edit') }}',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (role) {
                $("#name_edit").val(role.name);
                $("#description_edit").val(role.description);
            },
            error: function () {

            }
        });
    });
</script>

<script>
    $("#role_update").click(function () {
        var id = $("#updated_role_id").val();
        var name = $("#name_edit").val();
        var description = $("#description_edit").val();

        if (id == null || id === '') {
            toastr.warning('Bir Hata Oluştu. Lütfen Sayfayı Yenileyip Tekrar Deneyin.');
        } else if (name == null || name === '') {
            toastr.warning('Rol Adı Girilmesi Zorunludur');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('setting.roles.update') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    name: name,
                    description: description
                },
                success: function () {
                    toastr.success('Rol Başarıyla Güncellendi');
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
        $("#deleted_role_id").val(id);
    });
</script>

<script>
    $("#delete_role").click(function () {
        var id = $("#deleted_role_id").val();
        $.ajax({
            type: 'post',
            url: '{{ route('setting.roles.delete') }}',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function (response) {
                $("#row-" + id).remove();
                toastr.success('Rol Başarıyla Silindi');
                $("#DeleteModal").modal('hide');
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>

<script>

    $(".permissionUpdate").click(function () {
        var role_id = $(this).data('role-id');
        var permissions = $("#" + role_id + "_permissions").val();

        $.ajax({
            type: 'post',
            url: '{{ route('ajax.role.permissionsUpdate') }}',
            data: {
                _token: '{{ csrf_token() }}',
                role_id: role_id,
                permissions: permissions
            },
            success: function () {
                toastr.success('Rol Yetkileri Başarıyla Güncellendi');
            },
            error: function (error) {
                console.log(error);
                toastr.success('Sistemsel Bir Hata Oluştu!');
            }
        });
    });

</script>
