<table class="table table-tranx table-billing">
    <thead>
    <tr class="tb-tnx-head">
        <th><span class="d-md-inline-block">#</span></th>
        <th><span class="d-md-inline-block">Information</span></th>
        <th><span class="d-md-inline-block">Created</span></th>
        <th><span class="d-md-inline-block">Last Update</span></th>
        <th><span class="d-md-inline-block">Total</span></th>
        <th><span class="d-md-inline-block">Status</span></th>
    </tr><!-- .tb-tnx-head -->
    </thead>
    <tbody>
    @forelse($records as $record)
        <tr class="tb-tnx-item">
            <td>{{ $record->id }}</td>
            <td>{{ $record->user->first_name." created report on ".date("M d, Y", strtotime($record->created_at)) }}</td>
            <td>{{ $record->created_at }}</td>
            <td>{{ $record->updated_at }}</td>
            <td>{{ $record->total }}</td>
            <td>
                <div class="tb-tnx-status">
                    <span class="badge badge-dot badge-warning">{{ $record->stageInfo }}</span>
                </div>
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