@extends('admin.layouts.master')

@push('styles')

@endpush

@section('header')

    <div class="page-header">
        <div class="page-title">
            <h3>Page Header</h3>
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

@section('contents')

@endsection

@push('scripts')

@endpush
