<div class="table-responsive">
    <table class="table table-tranx table-billing">
        <thead>
        <tr class="tb-tnx-head">
            <th><span class="d-md-inline-block">Name</span></th>
            <th><span class="d-md-inline-block">Office Stage</span></th>
            <th><span class="d-md-inline-block">Created By</span></th>
            <th><span class="d-md-inline-block">Created At</span></th>
            <th><span class="d-md-inline-block">Action</span></th>
        </tr><!-- .tb-tnx-head -->
        </thead>
        <tbody>
        @forelse($data as $item)
            <tr class="tb-tnx-item">
                <td>{{ $item->name  }}</td>
                <td>{{ $item->stages->count() }}</td>
                <td>{{ $item->user->names }}</td>
                <td>{{ $item->created_at->diffForHumans() }}</td>
                <td>
                    <a href="#">
                        <em class="icon ni ni-edit mr-2" style="font-size: 20px"></em>
                    </a>
                    <a href="{{ route('process.list', $item->uuid) }}">
                        <em class="icon ni ni-setting-alt" style="font-size: 20px"></em>
                    </a>
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