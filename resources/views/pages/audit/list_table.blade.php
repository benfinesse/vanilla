<div class="col-12 mb-4">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">{{ $group->name }} Record</h5>
            </div>
            <div class="table-responsive">
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