@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Supplier</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('supplier.create') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-file-plus"></em><span><span class="d-none d-sm-inline-block">New</span> Supplier</span></a></li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="card card-bordered">
                @include('pages.supplier.table')
            </div>
        </div>
    </div>

@endsection
