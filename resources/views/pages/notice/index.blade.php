@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Notifications</h4>
                <p>{{ ucfirst($type) }}</p>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="{{ route('notice.index', ['type'=>'seen']) }}" class="btn btn-white btn-dim btn-outline-primary {{ $type==='seen'?'active':'' }}">
                            <span>Seen</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notice.index', ['type'=>'unread']) }}" class="btn btn-white btn-dim btn-outline-primary {{ $type==='unread'?'active':'' }}">
                            <span>Unread</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notice.index', ['type'=>'all']) }}" class="btn btn-white btn-dim btn-outline-primary {{ $type==='all'?'active':'' }}">
                            <span>All</span>
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
                <table class="table table-tranx table-billing">
                    <thead>
                    <tr class="tb-tnx-head">
                        <th><span class="d-md-inline-block">Title</span></th>
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
                                    {{ $item->title  }}
                                </p>
                                <p class="text-gray"><small>{{ $item->message }}</small></p>

                            </td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>{{ $item->seen?'Seen':'Not Seen' }}</td>
                            <td>
                                <a href="{{ route('open.notice', $item->uuid) }}" class="mr-4 btn btn-sm btn-outline-primary" title="Preview"><em class="icon ni ni-eye-alt mr-2"></em> Preview</a>
                                <a href="#" title="Mark as seen"><em class="icon ni ni-check-circle"></em></a>
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
            {{ $data->links() }}
        </div>
    </div>

@endsection
