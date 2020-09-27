@extends('admin.layouts.master')

@push('styles')

<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="{{ asset('cork/custom/css/infobox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('cork/assets/css/forms/switches.css') }}">
<!--  END CUSTOM STYLE FILE  -->

@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>Hotel Brands</h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Components</a></li>
                <li class="breadcrumb-item active" aria-current="page">UI Kit</li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')

    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="card component-card_1">
            <div class="card-body">
                @if($brands->isNotEmpty())

                    <div class="row">
                        @foreach($brands as $brand)
                            <div class="col-md-6">
                                <div class="infobox-2">
                                    <div class="info-icon">
                                        <img src="@if($brand->hasMedia('brand_logo')){{ asset($brand->logo()->getUrl('logo-thumb')) }} @endif" alt="">
                                    </div>
                                    <h5 class="info-heading">{{$brand->title}}</h5>
                                    <p class="info-text">{{ $brand->description }}</p>
                                    <a class="info-link" href="#">
                                        <button type="button" class="btn btn-primary">Settings</button>
                                        <a href="{{ route('admin.brands.edit',$brand->id)}}" class="btn btn-secondary">Edit</a>
                                        <button type="button" class="btn btn-danger" data-target="#deleteContent{{$brand->id}}" data-toggle="modal">
                                            Delete
                                        </button>
                                        @include('admin.brand.delete')
                                    </a>
                                </div>
                                
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="col-md-12">
                        <span class="badge badge-warning">No Brands Added.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="card component-card_1">
            <div class="card-body">
                <h4 class="media-heading">
                    @if(isset($editBrand))
                        <span class="media-title">
                            Edit Brand
                        </span>
                        <a href="{{ route('admin.brands')}}" class="float-right  btn btn-sm btn-primary">Add Brand</a>
                    @else
                        <span class="media-title">
                            Add Brand
                        </span>
                    @endif
                </h4>
                @if(isset($editBrand))
                    <form class="form-vertical" method="post" action="{{ route('admin.brands.edit',$brand->id) }}" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$editBrand->id}}">
                @else
                    <form class="form-vertical" method="post" action="{{ route('admin.brands.add') }}" enctype="multipart/form-data">
                @endif

                @csrf

                    @if(session()->has('message-success'))
                    <div class="alert alert-success">
                        {{ session()->get('message-success') }}
                    </div>
                    @elseif(session()->has('message-danger'))
                    <div class="alert alert-danger">
                        {{ session()->get('message-danger') }}
                    </div>
                    @endif
                    <div class="form-group mb-4">
                        <label class="control-label">Brand Name:</label>
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

                    <div class="form-group mb-4 ">
                        <div class="row">
                            <div class="col-6">
                                <label class="control-label">Satus:</label>
                            </div>
                            <div class="col-6">
                            <label class="float-right switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                <input type="checkbox" name="status" {{ isset($editBrand)? ($editBrand->status == "Active" ? "checked" : '') : "checked" }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="custom-file-container" data-upload-id="myFirstImage">
                        <label>Upload Logo <a href="javascript:void(0)" class="custom-file-container__image-clear float-right" title="Clear Image"><span class="badge badge-danger">Discard</span></a></label>
                        <label class="custom-file-container__custom-file" >
                            <input type="file" name="logo" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                        </label>
                        @error('logo')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="custom-file-container__image-preview"></div>
                    </div>

                    <input type="submit" value="Submit" class="btn btn-primary ml-3 mt-3">
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="{{ asset('cork/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>

    <script>
        //First upload .
        @if(isset($editBrand) && $editBrand->hasMedia('brand_logo'))
            var importedBaseImage = "{{ isset($editBrand)? $editBrand->logo()->getUrl() : ''}}"
            var firstUpload = new FileUploadWithPreview('myFirstImage', {
                images: {
                        baseImage: importedBaseImage,
                    },
            })
        @else
            var firstUpload = new FileUploadWithPreview('myFirstImage')
        @endif
    </script>


@endpush
