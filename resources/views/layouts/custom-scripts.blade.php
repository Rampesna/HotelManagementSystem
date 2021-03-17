<script>
    @if(session()->has('type') && session()->has('data'))
    toastr.{{ session()->get('type') }}("{{ session()->get('data') }}");
    @endif
</script>

<script>

    function getTimesheets () {

    }

    // setInterval(getTimesheets(), 5000);
</script>
