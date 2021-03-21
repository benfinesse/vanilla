@extends('auth.layout.app')

@section('content')

    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Sign-In</h5>
            <div class="nk-block-des">
                <p>Enter credentials to continue.</p>
            </div>
        </div>
    </div><!-- .nk-block-head -->
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="default-01">Email</label>
            </div>
            <input type="text" class="form-control form-control-lg  @error('email') is-invalid @enderror" id="default-01" placeholder="Enter your email address">

            @error('email')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div><!-- .foem-group -->
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">Password</label>
                <a class="link link-primary link-sm" tabindex="-1" href="{{ "#" }}">Forgot password?</a>
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
        </div><!-- .foem-group -->
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block">Sign in</button>
        </div>
    </form><!-- form -->

@endsection
