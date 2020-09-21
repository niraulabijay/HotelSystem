@extends('admin.layouts.master')

@push('styles')

@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>Room Types</h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Room Types</a></li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')

    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="card component-card_1">
            <div class="card-body">
                <h4 class="media-heading">Hotels:</h4>
                <ul class="hotel-list">
                    @foreach($hotels as $hotel)
                        <li>
                        <button class="hotel-item" id="{{ $hotel->id }}">{{ $hotel->title }}</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="card component-card_1">
            <div class="card-body">
                <div class="romm-types-container">

                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')

    <script>
        $(document).ready(function(){
            var id = parseInt($('.hotel-item').get(0).id);
            console.log(id);
            var tempDeleteUrl = "{{ route('admin.ajaxRoomTypes', ':id') }}";
            tempDeleteUrl = tempDeleteUrl.replace(':id', id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: tempDeleteUrl,
                beforeSend: function (data) {
                    $(this).attr("disabled", true);

                },
                success: function (data) {

                    if(data.status == 'success'){

                        $('#edu-data-table').DataTable().ajax.reload();
                    }
                },
                error: function (err) {
                    if (err.status == 422) {
                        $(this).attr("disabled", false);
                    }
                },
                complete: function () {
                    $(this).attr("disabled", false);
                }
            });
        });
    </script>

@endpush
