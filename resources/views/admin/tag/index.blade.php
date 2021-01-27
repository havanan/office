@extends('admin.layouts.admin')
@section('title', __('news.tag.title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <tag-component></tag-component>
            <br/>
        </div>
    </div>
@endsection


@push('scripts')

@endpush
