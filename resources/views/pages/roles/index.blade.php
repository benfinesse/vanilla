@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Roles</h4>

            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="{{ route('role.create') }}" class="btn btn-white btn-dim btn-outline-primary">
                            <em class="icon ni ni-plus mr-2"></em> <span>New Role</span>
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
                            <th><span class="d-md-inline-block">Name </span></th>
                            <th><span class="d-md-inline-block">Users </span></th>
                            <th><span class="d-md-inline-block">Status </span></th>
                            <th><span class="d-md-inline-block">Action </span></th>
                        </tr><!-- .tb-tnx-head -->
                        </thead>
                        <tbody>
                        @forelse($data as $item)
                            <tr class="tb-tnx-item">
                                <td>
                                    {{ $item->title  }}
                                </td>
                                <td>{{ $item->userCount }}</td>
                                <td>{{ $item->active?'Active':'Inactive' }}</td>
                                <td>
                                    <a href="{{ route('role.show', $item->uuid) }}" class="mr-4" title="Edit"><em class="icon ni ni-edit-alt mr-2"></em> </a>
                                    <a href="{{ route('role.manage', $item->uuid) }}" class="mr-4" title="Manage"><em class="icon ni ni-account-setting-alt"></em></a>
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
