@extends('layouts.admin')
@section('title', 'Danh sách loại hàng')
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
        var statusGr = JSON.parse('<?php echo json_encode(\App\Helpers\Constants::CATEGORY_STATUS) ?>');
        var parentCat = JSON.parse('<?php echo json_encode($categories) ?>');
    </script>
@endpush
