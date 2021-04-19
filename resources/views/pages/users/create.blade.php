@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">New User Account</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('account.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span><span class="d-none d-sm-inline-block">Back</span> </span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="nk-content-wrap">
        <div class="nk-block">
            @include('layouts.notice')
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Create New User</h5>
                    </div>
                    <form action="{{ route('account.store') }}" method="post">
                        @csrf
                        <p class="text-left">Enter a details to complete.</p>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="first_name">First Name</label>
                                    <input id="first_name" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="last_name">Last Name</label>
                                    <input id="last_name" class="form-control" name="last_name" value="{{ old('last_name') }}" required autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input id="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="email">Role</label>
                                    <div class="form-control-wrap ">
                                        <div class="form-control-select">
                                            <select name="role_id" class="form-control" id="process" required="required">
                                                <option selected disabled value="">Select Option</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->uuid }}">{{ $role->title }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Create Account</label>
                                    <div class="form-control-wrap ">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection
