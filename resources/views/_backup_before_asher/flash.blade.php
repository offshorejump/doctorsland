@if (session()->has('message'))

<script type="text/javascript">
    $(document).ready(function() {
        sa_alert('{{ session('message.title') }}', '{{ session('message.message') }}', '{{ session('message.level') }}');
    });
</script>

@endif

@if (session()->has('message_overlay'))

<script type="text/javascript">
    $(document).ready(function() {
        sa_alert('{{ session('message_overlay.title') }}', '{{ session('message_overlay.message') }}', '{{ session('message_overlay.level') }}', 1);
    });
</script>

@endif
