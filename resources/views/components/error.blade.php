@error($slot)
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $msg}}',
        });
    </script>
@enderror
