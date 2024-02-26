@if (Session::has('success'))
    Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ Session::get('success') }}',
    });
@endif

@if (Session::has('error'))
    Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: '{{ Session::get('error') }}',
    });
@endif
