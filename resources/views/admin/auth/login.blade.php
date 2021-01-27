@extends('layouts.auth')
@section('title', 'Đăng nhập')
@section('content')
    <div class=" card-box">
        <div class="panel-heading">
            <h3 class="text-center"> Sign In to <strong class="text-custom">Misa Mng</strong></h3>
        </div>
        <div class="panel-body">
            @include('layouts.flash.message')
            <form class="form-horizontal m-t-20" action="{{route('admin.login')}}" method="post">
                @csrf
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                               placeholder="Email" required autofocus>
                        @if($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="password" type="password" class="form-control" name="password"
                               placeholder="Mật khẩu" required>
                        @if($errors->has('password'))
                            <div class="error">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
                            Đăng nhập
                        </button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="{{ route('home') }}" class="text-dark">
                            <img src="{{asset('assets\image\icon\cart.png')}}" alt="cart-icon">
                            <span>Trang bán hàng</span>
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('styles')

@endpush
