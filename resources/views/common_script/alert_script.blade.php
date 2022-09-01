@if (Session::has('success'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{ Session("success") }}',
            showConfirmButton: false,
            timer: 2000,
            color:'black',
            background:'white',
        })
    </script>
@elseif(Session::has('info'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'info',
            title: '{{ Session("info") }}',
            showConfirmButton: false,
            timer: 2000,
            color:'black',
            background:'white',
        })
    </script>
@elseif(Session::has('warning'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: '{{ Session("warning") }}',
            showConfirmButton: false,
            timer: 2000,
            color:'black',
            background:'white',
        })
    </script>
@endif
