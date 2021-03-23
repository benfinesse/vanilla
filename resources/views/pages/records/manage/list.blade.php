@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Records</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('record.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span><span class="d-none d-sm-inline-block">Back</span> </span></a></li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    <div class="nk-content-wrap">
        <div class="nk-block">
            <p>Record submission on process: <b>{{ $record->process->name }}</b></p>
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Department Records</h5>
                        @if($record->ready)
                            <a href="{{ route('record.manage', $record->uuid) }}" class="btn btn-primary">
                                <em class="icon ni ni-send mr-2" style="font-size: 15px" ></em>
                                Submit Record
                            </a>
                        @endif

                        <a href="{{ route('record.manage', $record->uuid) }}" class="btn btn-primary">New Record</a>
                    </div>
                    <table class="table table-tranx table-billing">
                        <thead>
                        <tr class="tb-tnx-head">
                            <th><span class="d-md-inline-block">Department</span></th>
                            <th><span class="d-md-inline-block">Created</span></th>
                            <th><span class="d-md-inline-block">Total</span></th>
                            <th><span class="d-md-inline-block">Action</span></th>
                        </tr><!-- .tb-tnx-head -->
                        </thead>
                        <tbody>
                        @forelse($data as $record_group)
                            <tr class="tb-tnx-item">
                                <td>{{ $record_group->group->name }}</td>
                                <td>{{ date('F d, Y', strtotime($record_group->created_at)) }}</td>
                                <td>{{ $record_group->total }}</td>
                                <td>

                                    @if($record->status==="edited")
                                        <a href="#" title="List Records">
                                            <em class="icon ni ni-edit-alt" style="font-size: 20px"></em>
                                        </a>
                                        <a href="#" title="Add Department Records">
                                            <em class="icon ni ni-trash-alt" style="font-size: 20px"></em>
                                        </a>
                                    @else
                                        @if($record->status==="completed")
                                            <b> Closed </b>
                                        @else
                                            <b> Pending Response </b>
                                        @endif
                                    @endif

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
    </div>

@endsection
