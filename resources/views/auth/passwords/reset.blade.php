@extends('auth.layout.app')

@section('content')

    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">New Password</h5>
            <div class="nk-block-des">
                <p>Enter new password for your account.</p>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="default-01">Email</label>
            </div>
            <input type="text" class="form-control form-control-lg  @error('email') is-invalid @enderror" id="default-01" placeholder="Enter your email address" value="{{ old('email') }}" name="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="form-control-wrap">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" placeholder="Enter your password" name="password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">Confirm Password</label>
            </div>
            <div class="form-control-wrap">
                <input type="password" class="form-control form-control-lg " id="password" placeholder="Confirm Password" name="password_confirmation">
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block">Reset Password</button>
        </div>
        <p class="text-center">
            <a href="{{ route('login') }}" class=""><b>Give Login a try!</b></a>
        </p>
    </form>

@endsection
