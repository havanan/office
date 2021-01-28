@extends('layouts.admin')
@section('title', __('setting.title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
                <config-component></config-component>
            <br/>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
@endpush
