@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title fw-normal">{{ $process->name }}</h5>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="{{ route('process.index') }}" class="btn btn-white btn-dim btn-outline-primary">
                            <em class="icon ni ni-arrow-left"></em>
                            <span class="d-none d-sm-inline-block">Back</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('process.stage.create', $process->uuid) }}" class="btn btn-white btn-dim btn-outline-primary">
                            <em class="icon ni ni-plus"></em>
                            <span class="d-none d-sm-inline-block">New Office</span>
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
                        <th><span class="d-md-inline-block">Name</span></th>
                        <th><span class="d-md-inline-block">Members</span></th>
                        <th><span class="d-md-inline-block">Created At</span></th>
                        <th><span class="d-md-inline-block">Action</span></th>
                    </tr><!-- .tb-tnx-head -->
                    </thead>
                    <tbody class="list_items">
                    @forelse($data as $item)
                        <tr class="tb-tnx-item">
                            <td>{{ $item->name  }}</td>
                            <td>{{ $item->members->count() }}</td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('process.item.manage', $item->uuid) }}" class="" title="Manage">
                                    <em class="icon ni ni-account-setting" style="font-size: 20px"></em>
                                </a>

                                <a href="{{ route('process.item.direction',['uuid'=>$item->uuid, 'dir'=>'down']) }}" class="ml-4" title="Move Down">
                                    <em class="icon ni ni-arrow-down" style="font-size: 20px"></em>
                                </a>
                                <a href="{{ route('process.item.direction',['uuid'=>$item->uuid, 'dir'=>'up']) }}" title="Move Up">
                                    <em class="icon ni ni-arrow-up" style="font-size: 20px"></em>
                                </a>

                                <a href="#" onclick="event.preventDefault(); deleteItem('{{ route('office.pop', $item->uuid) }}')" class="ml-4 text-danger">
                                    <em class="icon ni ni-trash-alt" style="font-size: 20px"></em>
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

@section('vendor_js')

@endsection

@section('custom_js')

@endsection
