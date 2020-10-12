@extends('admin.layouts.master')

@push('styles')

<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="{{ asset('cork/custom/css/infobox.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('cork/assets/css/forms/switches.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<!--  END CUSTOM STYLE FILE  -->

@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>
                Frequently Asked Questions (FAQ)
            </h3>
        </div>
        {{-- Breadcrumbs section --}}
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Faqs</a></li>
            </ol>
        </nav>
    </div>


@endsection

@section('content')

    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="card component-card_1" style="min-height: 450px;">
            <div class="card-body">
                @if($faqCategories->count() > 0)
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @foreach($faqCategories as $category)
                            <li class="nav-item">
                                <a class="nav-link {{$loop->iteration == 1 ? "active" : ''}}" id="pills-home-tab" data-toggle="pill" href="#pills-{{$category->id}}" role="tab" aria-controls="pills-home" aria-selected="true">
                                    <h5>{{ $category->title }}</h5>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <hr style="border-top: 1px solid #61525261;">
                    <div class="tab-content" id="pills-tabContent">
                        @foreach($faqCategories as $category)
                            <div class="tab-pane fade {{$loop->iteration == 1 ? 'show active' : '' }}" id="pills-{{$category->id}}" role="tabpanel" aria-labelledby="pills-home-tab">
                                @if($category->faqs->count() > 0)
                                    @foreach($category->faqs as $faq)
                                        <div id="accordion">
                                            <div class="card">
                                                <div class="card-header" id="headingOne">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h6 class="mb-0">
                                                            <a style="cursor: pointer" data-toggle="collapse" data-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                                {{$faq->question}}
                                                            </a>
                                                            </h6>
                                                        </div>
                                                        <div class="col-2 text-right">
                                                            <button data-id="{{$faq->id}}" class="editFaq btn btn-warning rounded-circle">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button data-id="{{$faq->id}}" data-toggle="modal" data-target="#deleteFaqModel" class="deleteFaq btn btn-danger  rounded-circle">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="collapse{{$faq->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                    <div class="card-body">
                                                        {{$faq->answer}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-outline-warning alert-arrow-right">
                                        <strong class="text-primary">
                                            No questions created for this category.
                                        </strong>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 text-right">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-success text-right" data-toggle="modal" data-target="#questionModal">
                                <strong>Add Question</strong>
                            </button>
                            <a href="{{ route('admin.faqCategory.edit',$category->slug) }}" type="button" class="btn btn-secondary">
                                Edit
                            </a>
                            <button type="button" data-toggle="modal" data-target="#deleteCategoryModel" data-id="{{$category->id}}" class="btn btn-danger deleteCatButton">
                                Delete
                            </button>
                        </div>

                    </div>
                @else
                    <div class="alert alert-outline-warning alert-arrow-right">
                        <strong class="text-danger">No Faq Categories Created !!</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('admin.faq.addQuestion')
    @include('admin.faq.deleteCategory')
    @include('admin.faq.deleteQuestion')

    <!-- Edit Faq Modal -->
    <div class="modal fade" id="questionEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg edit-faq-modal" role="document">
            <!-- Ajax Data (Edit Form) Loaded Here -->
        </div>
    </div>


    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="card component-card_1">
            <div class="card-body">
                <h4 class="media-heading">

                    @if(isset($editFaqCategory))
                        <span class="media-title">
                            Edit FAQ Criteria
                        </span>
                        <a href="{{ route('admin.faqs')}}" class="float-right  btn btn-md btn-info">Add Faq Category</a>
                    @else
                        <span class="media-title">
                            Create FAQ Criteria
                        </span>
                    @endif
                </h4>
                @if(isset($editFaqCategory))
                    <form class="form-vertical" method="post" action="{{ route('admin.faqCategory.update',$editFaqCategory->slug) }}" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$editFaqCategory->id}}">
                @else
                    <form class="form-vertical" method="post" action="{{ route('admin.faqCategory.store') }}" enctype="multipart/form-data">
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
                        <label class="control-label">Category Title:</label>
                        <input type="text" name="title" value="{{ isset($editFaqCategory)? $editFaqCategory->title : '' }}" class="form-control" placeholder="Faq Category Name">
                        @error('title')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="control-label">Category Description: (Optional)</label>
                        <textarea class="form-control" rows="2" name="description" aria-label="With textarea" placeholder="Brief details about topics covered">{{ isset($editFaqCategory)? $editFaqCategory->description : '' }}</textarea>
                    </div>

                    <div class="form-group mb-4 ">
                        <div class="row">
                            <div class="col-6">
                                <label class="control-label">Status:</label>
                            </div>
                            <div class="col-6">
                            <label class="float-right switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                <input type="checkbox" name="status" {{ isset($editFaqCategory)? ($editFaqCategory->status == 1 ? "checked" : '') : "checked" }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

                    <input type="submit" value="Submit" class="btn btn-primary ml-3 mt-3">
                </form>
            </div>
        </div>
    </div>



@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script>

    <script>
        $('.deleteCatButton').on('click',function(){
            console.log('clicked')
            var cat_id = $(this).attr('data-id');
            $('#deleteCatId').val(cat_id);
        })
    </script>

    <script>
        $('.deleteFaq').on('click',function(){
            var cat_id = $(this).attr('data-id');
            $('#deleteFaqId').val(cat_id);
        })
    </script>

    <script>
        $(document).ready(function(){
            $('.editFaq').click(function(){
                var id = $(this).attr('data-id');
                // AJAX request
                $.ajax({
                    url: '{{route("admin.faq.edit")}}',
                    type: 'get',
                    data: {faq_id: id},
                    success: function(response){
                        // Add response in Modal body
                        $('.edit-faq-modal').html(response);

                        // Display Modal
                        $('#questionEditModal').modal('show');
                    },
                    error: function(data){
                        toastr.error(data.responseText,'Server Error');
                    }
                });
            });
        });
    </script>

@endpush
