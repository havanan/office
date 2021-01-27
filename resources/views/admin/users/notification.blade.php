@extends('admin.layouts.admin')
@section('title', __('user.notification.title'))
@section('content')
<div class="container">
    <div class="row">
        <notification-component></notification-component>
    </div>
</div>
@endsection
