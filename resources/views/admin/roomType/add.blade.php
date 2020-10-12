@extends('admin.layouts.master')

@push('styles')

    <link href="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/assets/css/forms/switches.css') }}">
    <link href="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />


@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>{{ $hotel->title }} - Room Type</h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.roomType')}}">Room Type</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')

    <div class="col-12 layout-spacing">

        @if(!isset($editRoomType))
            <!-- Add Submit Form -->
            <form method="post" action="{{ route('admin.roomType.store',$hotel->slug) }}" enctype="multipart/form-data">
            <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
        @else
            <!-- Edit Form -->
            <form method="post" action="{{ route('admin.roomType.update',$editRoomType->slug) }}" enctype="multipart/form-data">
            <input type="hidden" name="room_type" value="{{$editRoomType->id}}">
        @endif
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-component-1">
                                <div class="card-body">
                                    <div class="form-group mb-4">
                                        <label class="control-label">Room Name:</label>
                                        <input type="text" name="title" value="{{ $editRoomType->title ?? '' }}" class="form-control"  placeholder="Room Name">
                                        @error('title')
                                        <div class="text-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="control-label">Quick Description:</label>
                                        <textarea class="form-control" rows="3" name="description" aria-label="With textarea" placeholder="Short Description About the Room">{{ $editRoomType->description ?? '' }}</textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="card card-component-1">
                                <div class="card-body">
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="guests">No. of Guests</label>
                                            <input type="number" name="no_of_guests" value="{{ $editRoomType->no_of_adult ?? 1 }}" class="form-control" id="guests" placeholder="Room Type Occupancy">
                                            @error('no_of_adults')
                                                <div class="text-danger" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="price">Base Price ($)</label>
                                            <input type="text" name="base_price" value="{{ $editRoomType->base_price_format() ?? 0 }}" class="form-control number-only" id="price" placeholder="Starting price of room">
                                            @error('base_price')
                                                <div class="text-danger" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-component-1">
                        <div class="card-body">
                            <div class="form-group mb-4 "">
                                <div class="row p-2" style="background-color: #f5f5f5">
                                    <div class="col-6">
                                        <label class="control-label" style="color:#">Satus:</label>
                                    </div>
                                    <div class="col-6">
                                        <label class="float-right switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                            <input type="checkbox" name="status" {{ isset($editRoomType)? ($editRoomType->status == "Active" ? "checked" : '') : "checked" }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="custom-file-container" data-upload-id="mySecondImage">
                                <label>Feature Image <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                <label class="custom-file-container__custom-file" >
                                    <input type="file" name="feature_image" class="custom-file-container__custom-file__custom-file-input">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                </label>
                                @error('feature_image')
                                    <div class="text-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="custom-file-container__image-preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </div>
            </div>
        </form>

    </div>

@endsection

@push('scripts')

    <script src="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>

    <script>
        //First upload .
        @if(isset($editRoomType) && $editRoomType->hasMedia('feature_image'))
            var importedBaseImage = "{{ isset($editRoomType)? $editRoomType->featureImage()->getUrl() : ''}}"
            var firstUpload = new FileUploadWithPreview('mySecondImage', {
                images: {
                        baseImage: importedBaseImage,
                    },
            })
        @else
            var secondUpload = new FileUploadWithPreview('mySecondImage');
        @endif
        //Second upload


    </script>
    <script>
        $('.number-only').keypress(function(evt){
            return (/^[0-9]*\.?[0-9]*$/).test($(this).val()+evt.key);
        });
    </script>

@endpush
