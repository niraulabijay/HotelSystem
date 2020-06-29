@if(session()->has('sweetAlert-success'))
    <script>
        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            padding: '2em'
        });
        toast({
            type: 'success',
            title: "{{ session()->get('sweetAlert-success') }}",
            padding: '2em',
        })
    </script>
@elseif(session()->has('sweetAlert-error'))
    <script>
        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            padding: '2em'
        });
        toast({
            type: 'error',
            title: "{{ session()->get('sweetAlert-error') }}",
            padding: '2em',
        })
    </script>

@endif
