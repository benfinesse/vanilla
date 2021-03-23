@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title fw-normal">{{ $process->name }}</h5>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-file-plus"></em><span><span class="d-none d-sm-inline-block">New</span> Office Stage</span></a></li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="card card-bordered">
                <table class="table table-tranx table-billing">
                    <thead>
                    <tr class="tb-tnx-head">
                        <th><span class="d-md-inline-block">Name</span></th>
                        <th><span class="d-md-inline-block">Members</span></th>
                        <th><span class="d-md-inline-block">Created At</span></th>
                        <th><span class="d-md-inline-block">Action</span></th>
                    </tr><!-- .tb-tnx-head -->
                    </thead>
                    <tbody>
                    @forelse($data as $item)
                        <tr class="tb-tnx-item">
                            <td>{{ $item->name  }}</td>
                            <td>{{ $item->members->count() }}</td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="#">
                                    <em class="icon ni ni-edit mr-2" style="font-size: 20px"></em>
                                </a>
                                <a href="#">
                                    <em class="icon ni ni-setting-alt" style="font-size: 20px"></em>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="tb-tnx-item">
                            <td colspan="4" class="text-center">
                                <b>No Data Yet.</b>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
