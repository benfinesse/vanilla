@extends('auth.layout.app')

@section('content')
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Complete Account</h5>
            <div class="nk-block-des">
                <p>Create new credentials to continue with the role:
                    <br>
                    <b>{{ $role->title }}</b>.
                </p>
            </div>
            @include('layouts.notice')
        </div>
    </div>
    <form method="POST" action="{{ route('complete.account', ['t'=>$user->token, 'r'=>$role->uuid]) }}">
        @csrf

        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="">First Name</label>
            </div>
            <input type="text" class="form-control form-control-lg" placeholder="First Name" value="{{ $user->first_name }}" readonly>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="">Last Name</label>
            </div>
            <input type="text" class="form-control form-control-lg" placeholder="Last Name" value="{{ $user->last_name }}" readonly>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="">Email</label>
            </div>
            <input type="text" class="form-control form-control-lg" placeholder="Email" value="{{ $user->email }}" readonly>
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
                <label class="form-label" for="default-01">Confirm Password</label>
            </div>
            <input type="password" class="form-control form-control-lg " id="default-01" placeholder="Confirm Password" name="confirm_password">

        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block">Complete Account</button>
        </div>
    </form>

@endsection
