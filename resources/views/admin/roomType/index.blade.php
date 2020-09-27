@extends('admin.layouts.master')

@push('styles')

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('cork/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('cork/assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/custom/css/infobox.css') }}" rel="stylesheet" type="text/css" />

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

    <div class="col-12 layout-spacing">
        <div class="row mb-4 mt-3">
            <div class="col-sm-3 col-12" style="border-right:1px solid;">
                <div class="statbox widget box box-shadow p-3">
                    <h4 class="text-center mb-3">Hotel List</h4>
                    <div class="nav flex-column nav-pills mb-sm-0 mb-3" id="rounded-vertical-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($hotels as $hotel)
                            <a class="nav-link mb-2 {{ $loop->iteration == 1 ? "active" : ""}} mx-auto"
                                id="rounded-vertical-pills-hotel-tab-" data-toggle="pill" href="#rounded-vertical-pills-{{$hotel->id}}"
                                role="tab" aria-controls="rounded-vertical-pills-home" aria-selected="true">
                                {{$hotel->title}}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-sm-9 col-12">
                <div class="statbox widget box box-shadow p-3 room-type-container">
                    <div class="tab-content" id="rounded-vertical-pills-tabContent">
                        @foreach($hotels as $hotel)
                            <div class="tab-pane fade {{ $loop->iteration == 1 ? "show active" : ""}}" id="rounded-vertical-pills-{{$hotel->id}}" role="tabpanel" aria-labelledby="rounded-vertical-pills-home-tab">
                                <h3 class="mb-4">
                                    {{$hotel->title}} - Room Types&nbsp;<i data-feather="home"></i>
                                    <a href="{{ route('admin.roomType.add',$hotel->slug) }}" class="btn btn-success btn-md float-right">Add New</a>
                                </h3>
                                <span><strong>The room type includes information as to the number of beds, price and more. One or more units can be added for each room type.</strong></span>
                                <hr class="divider">

                                @if($hotel->roomTypes->count() > 0)
                                    @foreach($hotel->roomTypes as $roomType)
                                        <div class="card component-card_1">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    titleT
                                                </div>
                                                <div class="card-text">
                                                    check
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-light-warning mb-4" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
                                        <strong>Empty!</strong> No room types have been created for this hotel.
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
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
            var tempDeleteUrl = "";

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
