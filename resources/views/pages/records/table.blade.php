<div class="table-responsive">
    <table class="table table-tranx table-billing">
        <thead>
        <tr class="tb-tnx-head">
            <th><span class="d-md-inline-block">#</span></th>
            <th style="min-width: 300px"><span class="d-md-inline-block">Information</span></th>
            <th><span class="d-md-inline-block">Created</span></th>
            <th><span class="d-md-inline-block">Last Update</span></th>
            <th><span class="d-md-inline-block">Status</span></th>
            <th style="min-width: 300px"><span class="d-md-inline-block">Action</span></th>
        </tr><!-- .tb-tnx-head -->
        </thead>
        <tbody>
        @forelse($records as $record)
            <tr class="tb-tnx-item">
                <td>{{ $record->id }}</td>
                <td style="min-width: 300px">{{ $record->title }}</td>
                <td>{{ date('F d, Y', strtotime($record->created_at)) }}</td>
                <td>{{ date('F d, Y', strtotime($record->updated_at)) }}</td>
                <td>
                    <div class="tb-tnx-status">
                        <span class="badge badge-dot badge-{{ $record->statusColor }}">{{ $record->status }}</span>
                    </div>
                </td>
                <td>
                    @if($record->status==="edited")

                        <a href="{{ route('record.list', $record->uuid) }}" title="List Records" class="mr-2">
                            <em class="icon ni ni-setting-alt" style="font-size: 20px"></em>
                        </a>
                        <a href="#" title="Delete Records" class="mr-2 text-danger" onclick="deleteItem('{{ route('record.pop', $record->uuid) }}')">
                            <em class="icon ni ni-trash-alt" style="font-size: 20px"></em>
                        </a>

                        @if($record->ready)
                            <a href="#" title="Start Process">
                                <em class="icon ni ni-send" style="font-size: 20px"></em>
                            </a>
                        @endif

                    @else
                        @if($record->status!=="completed")
                            <b> Pending Response </b>
                            @if($person->isSuperAdmin)
                                <a href="{{ route('resend.notice', $record->uuid) }}" title="Resend Notice" class="ml-4">
                                    <em class="icon ni ni-send-alt" style="font-size: 20px"></em>
                                </a>
                            @endif
                        @endif
                            <a href="{{ route('record.history', $record->uuid) }}" title="List Records" class="ml-4">
                                <em class="icon ni ni-histroy" style="font-size: 20px"></em>
                            </a>


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
</div>