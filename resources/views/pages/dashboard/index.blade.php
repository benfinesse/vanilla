@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-head-sub"><span>Dashboard</span></div>
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title fw-normal">Hi, {{ $person->names }}</h3>
                <div class="nk-block-des">
                    <p>Welcome to your dashboard.</p>
                </div>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    @include('pages.dashboard.pendings')
    @include('pages.dashboard.quick_links')
    <div class="nk-content-wrap">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title fw-normal">Recent Records</h4>
                    <div class="nk-block-des">
                        <p>Recent Records listed below.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools gx-3">
                        <li><a href="{{ route('record.create') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-file-plus"></em><span><span class="d-none d-sm-inline-block">New</span> Record</span></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Info Ends -->

        <div class="nk-block">
            <div class="card card-bordered">
                @include('pages.records.table')
            </div>
        </div>

        <!-- Page Content Ends -->
    </div>

@endsection
