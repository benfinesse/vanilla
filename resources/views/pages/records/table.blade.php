<table class="table table-tranx table-billing">
    <thead>
    <tr class="tb-tnx-head">
        <th><span class="d-md-inline-block">#</span></th>
        <th><span class="d-md-inline-block">Information</span></th>
        <th><span class="d-md-inline-block">Created</span></th>
        <th><span class="d-md-inline-block">Last Update</span></th>
        <th><span class="d-md-inline-block">Status</span></th>
        <th><span class="d-md-inline-block">Action</span></th>
    </tr><!-- .tb-tnx-head -->
    </thead>
    <tbody>
    @forelse($records as $record)
        <tr class="tb-tnx-item">
            <td>{{ $record->id }}</td>
            <td>{{ $record->title }}</td>
            <td>{{ date('F d, Y', strtotime($record->created_at)) }}</td>
            <td>{{ date('F d, Y', strtotime($record->updated_at)) }}</td>
            <td>
                <div class="tb-tnx-status">
                    <span class="badge badge-dot badge-{{ $record->statusColor }}">{{ $record->status }}</span>
                </div>
            </td>
            <td>
                <a href="{{ route('record.list', $record->uuid) }}" title="List Records" class="mr-2">
                    <em class="icon ni ni-setting-alt" style="font-size: 20px"></em>
                </a>
                @if($record->status==="edited")
                    <a href="{{ route('record.manage', $record->uuid) }}" title="Add Department Records" class="mr-2">
                        <em class="icon ni ni-plus-c" style="font-size: 20px"></em>
                    </a>
                    @if($record->ready)
                        <a href="#" title="Start Process" >
                            <em class="icon ni ni-send" style="font-size: 20px"></em>
                        </a>
                    @endif

                @else
                    @if($record->status==="completed")
                        <b> - </b>
                    @else
                        <b> Pending Response </b>
                    @endif
                @endif

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