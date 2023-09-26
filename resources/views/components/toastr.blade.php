<script>
    @if(Session::has('success'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        'preventDuplicates': false,
        'showDuration': 2000,
        'hideDuration': 2000,
        'timeOut': 5000,
        'extendedTimeOut': 2000,
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }
    toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        'preventDuplicates': false,
        'showDuration': 2000,
        'hideDuration': 2000,
        'timeOut': 5000,
        'extendedTimeOut': 2000,
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }
    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        'preventDuplicates': false,
        'showDuration': 2000,
        'hideDuration': 2000,
        'timeOut': 5000,
        'extendedTimeOut': 2000,
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        'preventDuplicates': false,
        'showDuration': 2000,
        'hideDuration': 2000,
        'timeOut': 5000,
        'extendedTimeOut': 2000,
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>