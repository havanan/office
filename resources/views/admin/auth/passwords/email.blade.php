
@extends('admin.auth.layouts.auth')
@section('title', 'Khôi phục mật khẩu ')

@section('content')

<div class=" card-box">
    <div class="panel-heading">
        <h3 class="text-center"> Khôi phục mật khẩu </h3>
    </div>

    <div class="panel-body">


        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            @if (session('status'))
                <div class="alert alert-success alert-dismissable" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @error('email')
            <div class="alert alert-danger alert-dismissable" role="alert">
                {{ $message }}
            </div>
            @enderror
            <div class="form-group m-b-0">
                <div class="input-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    <span class="input-group-btn">
									<button type="submit" class="btn btn-pink w-sm waves-effect waves-light">
										Khôi phục
									</button>
								</span>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
