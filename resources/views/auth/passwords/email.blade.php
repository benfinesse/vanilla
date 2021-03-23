@extends('auth.layout.app')

@section('content')

    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Forgot Password</h5>
            <div class="nk-block-des">
                <p>Enter email registered to begin password reset.</p>
            </div>
        </div>
    </div><!-- .nk-block-head -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
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
            <button class="btn btn-lg btn-primary btn-block">Send Password Reset Link</button>
        </div>
        <p class="text-center">
            <a href="{{ route('login') }}" class=""><b>Try Login</b></a>
        </p>
    </form>

@endsection
