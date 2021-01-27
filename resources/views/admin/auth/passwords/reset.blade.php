@extends('admin.auth.layouts.auth')
@section('title', 'Khôi phục mật khẩu')

@section('content')
    <div class=" card-box">
        <div class="panel-heading">
            <h3 class="text-center"> Khôi phục <strong class="text-custom">Mật khẩu</strong></h3>
        </div>

        <div class="panel-body">
            <form method="POST" action="{{ route('password.update') }}" class="form-horizontal m-t-20">
                @csrf
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required>
                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        @error('password')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
                            Lưu
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
