@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">{{ ucfirst($user->first_name) }}'s Account</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('account.edit', $user->uuid) }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-edit-alt"></em><span><span class="d-none d-sm-inline-block">Edit</span> </span></a></li>
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
                        <h5 class="card-title">{{ $user->first_name }} Details</h5>
                    </div>
                    <p class="text-left">Enter a details to complete.</p>
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="first_name">First Name</label>
                                <input id="first_name" class="form-control" name="first_name" value="{{ ucfirst($user->first_name) }}" required autofocus autocomplete="off" readonly />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input id="last_name" class="form-control" name="last_name" value="{{ ucfirst($user->last_name) }}" required autocomplete="off" readonly />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input id="email" class="form-control" name="email" value="{{ $user->email }}" required autocomplete="off" readonly />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
