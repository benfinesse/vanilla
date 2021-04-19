@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title fw-normal">{{ $role->title }}</h5>
                <p>{{ $role->title }} Users Management</p>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="{{ route('role.index') }}" class="btn btn-white btn-dim btn-outline-primary">
                            <em class="icon ni ni-arrow-left"></em>
                            <span class="d-none d-sm-inline-block">Back</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h6>{{ $role->title }} Members</h6>
                    <div class="card card-bordered">
                        <div class="table-responsive">
                            <table class="table table-tranx table-billing">
                                <thead>
                                <tr class="tb-tnx-head">
                                    <th><span class="d-md-inline-block">Name</span></th>
                                    <th><span class="d-md-inline-block">Action</span></th>
                                </tr><!-- .tb-tnx-head -->
                                </thead>
                                <tbody class="list_items">
                                @forelse($role->users as $member)
                                    <tr class="tb-tnx-item">
                                        <td>
                                            {{ $member->names  }}
                                            <br>
                                            <small>{{ $member->email }}</small>
                                        </td>
                                        <td>
                                            <a href="#" onclick="event.preventDefault(); deleteItem('{{ route('role.remove.member',['uuid'=> $member->uuid, 'role_id'=>$role->uuid] ) }}')" class="ml-4 text-danger">
                                                <em class="icon ni ni-trash-alt" style="font-size: 20px"></em>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="tb-tnx-item">
                                        <td colspan="2" class="text-center">
                                            <b>No Data Yet.</b>
                                            <br>
                                            <small>Click the plus sign under the users list</small>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h6>All Users</h6>
                    <div class="card card-bordered">
                        <div class="table-responsive">
                            <table class="table table-tranx table-billing">
                                <thead>
                                <tr class="tb-tnx-head">
                                    <th><span class="d-md-inline-block">Name</span></th>
                                    <th><span class="d-md-inline-block">Action</span></th>
                                </tr><!-- .tb-tnx-head -->
                                </thead>
                                <tbody class="list_items">
                                @forelse($members as $user)
                                    <tr class="tb-tnx-item">
                                        <td>
                                            {{ $user->names  }}
                                            <br>
                                            <small>{{ $user->email }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('role.add.member', ['uuid'=> $user->uuid, 'role_id'=>$role->uuid]) }}" class="" title="Add">
                                                <em class="icon ni ni-plus-circle" style="font-size: 20px"></em>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="tb-tnx-item">
                                        <td colspan="2" class="text-center">
                                            <b>No Data Yet.</b>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('vendor_js')

@endsection

@section('custom_js')

@endsection
