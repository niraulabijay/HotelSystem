@if(session()->has('sweetAlert-success'))
    <script>
        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            padding: '2em',
            background: 'rgba(54, 226, 75, 0.75)',
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
            padding: '2em',

            background: 'rgba(222, 72, 72, 0.75)',
        });
        toast({
            type: 'error',
            title: "<span style='color:white;'>{{ session()->get('sweetAlert-error') }}<span>",
            padding: '2em',
        })
    </script>

@endif
