@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Users</h4>
                <p>{{ ucfirst($type) }}</p>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="{{ route('account.index', ['type'=>'all']) }}" class="btn btn-white btn-dim btn-outline-primary {{ $type==='all'?'active':'' }}">
                            <span>All</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('account.index', ['type'=>'active']) }}" class="btn btn-white btn-dim btn-outline-primary {{ $type==='active'?'active':'' }}">
                            <span>Active</span>
                        </a>`
                    </li>
                    <li>
                        <a href="{{ route('account.index', ['type'=>'inactive']) }}" class="btn btn-white btn-dim btn-outline-primary {{ $type==='inactive'?'active':'' }}">
                            <span>Inactive</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('account.create') }}" class="btn btn-white btn-dim btn-outline-primary">
                            <em class="icon ni ni-plus mr-2"></em> <span>New Account</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="card card-bordered">
                <div class="table-responsive">
                    <table class="table table-tranx table-billing">
                        <thead>
                        <tr class="tb-tnx-head">
                            <th><span class="d-md-inline-block">Name <small>(email)</small></span></th>
                            <th><span class="d-md-inline-block">Created</span></th>
                            <th><span class="d-md-inline-block">Status</span></th>
                            <th><span class="d-md-inline-block">Action</span></th>
                        </tr><!-- .tb-tnx-head -->
                        </thead>
                        <tbody>
                        @forelse($data as $item)
                            <tr class="tb-tnx-item">
                                <td>
                                    <p class="mb-0">
                                        {{ $item->names  }}
                                    </p>
                                    <p class="text-gray"><small>{{ $item->email }}</small></p>

                                </td>
                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                <td>{{ $item->active?'Active':'Inactive' }}</td>
                                <td>
                                    <a href="{{ route('account.edit', $item->uuid) }}" class="mr-4 btn btn-sm btn-outline-primary" title="Preview">
                                        <em class="icon ni ni-eye-alt mr-2"></em> Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="tb-tnx-item">
                                <td colspan="6" class="text-center">
                                    <b>No Data Yet.</b>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $data->links() }}
        </div>
    </div>

@endsection
