@extends('admin.layouts.admin')
@section('title', __('news.category.title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <category-component></category-component>
            <br/>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        var statusGr = JSON.parse('<?php echo json_encode(CATEGORY_STATUS) ?>');
    </script>
@endpush
