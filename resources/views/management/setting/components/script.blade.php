<script>
    var setNight = $("#setNight");

    setNight.click(function () {
        $.ajax({
            type: 'post',
            url: '{{ route('ajax.setting.setNight') }}',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                toastr.success('Bugünkü Oda Ücretleri Başarıyla Yansıtıldı!');
            },
            error: function (error) {
                toastr.error('Sistemsel Bir Sorun Oluştu. Sistem Yöneticisi İle İletişime Geçin.');
                console.log(error);
            }
        });
    });
</script>
