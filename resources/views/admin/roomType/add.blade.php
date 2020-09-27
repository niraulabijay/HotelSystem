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

        {{ Form::open(['mehthod'=>'post', 'route'=>'admin.roomType.store', 'enctype' => 'multipart/form-data', 'files' => true]) }}

        <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-component-1">
                            <div class="card-body">
                                <div class="form-group mb-4">
                                    <label class="control-label">Room Type Title:</label>
                                    <input type="text" name="title" value="{{ isset($editBrand)? $editBrand->title : '' }}" class="form-control"  placeholder="Brand Name">
                                    @error('title')
                                    <div class="text-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label class="control-label">Quick Description:</label>
                                    <textarea class="form-control" rows="3" name="description" aria-label="With textarea" placeholder="Short Description About the Brand">{{ isset($editBrand)? $editBrand->description : '' }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="card card-component-1">
                            <div class="card-body">
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">No. of Guests</label>
                                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Max no. of Guests (with extra bed)</label>
                                        <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
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
                                        <input type="checkbox" name="status" {{ isset($editBrand)? ($editBrand->status == "Active" ? "checked" : '') : "checked" }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="custom-file-container" data-upload-id="mySecondImage">
                            <label>Upload (Allow Multiple) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                            <label class="custom-file-container__custom-file" >
                                <input type="file" class="custom-file-container__custom-file__custom-file-input" multiple>
                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                            <div class="custom-file-container__image-preview"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right">
                <button type="button" onclick="submit()" class="btn btn-lg btn-success">Submit</button>
            </div>
        </div>
        {{ Form::close() }}

    </div>

@endsection

@push('scripts')

    <script src="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
    <script>
        //Second upload
        var secondUpload = new FileUploadWithPreview('mySecondImage')

    </script>

    <script>
        function submitBrand(){
            alert("Form Submit")
        }
    </script>

@endpush
