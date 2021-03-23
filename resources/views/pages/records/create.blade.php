@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">New Records</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-plus-c"></em><span><span class="d-none d-sm-inline-block">New</span> Dept.</span></a></li>
                    <li><a href="{{ route('record.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span><span class="d-none d-sm-inline-block">Back</span> </span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="nk-content-wrap">

        @if($measures->count() < 1)
            <div class="alert alert-danger">
                <em class="ni ni-alert-c" style="font-size: 15px"></em> Add Measure to continue
            </div>
        @else
            <div class="nk-block">
                @include('pages.records.create_body')
            </div>
        @endif


    </div>

@endsection
