<div class="table-responsive">
    <table class="table table-tranx table-billing">
        <thead>
        <tr class="tb-tnx-head">
            <th><span class="d-md-inline-block">Name</span></th>
            <th><span class="d-md-inline-block">Created By</span></th>
            <th><span class="d-md-inline-block">Created At</span></th>
            <th><span class="d-md-inline-block">Action</span></th>
        </tr><!-- .tb-tnx-head -->
        </thead>
        <tbody>
        @forelse($data as $item)
            <tr class="tb-tnx-item">
                <td>{{ $item->name  }}</td>
                <td>{{ $item->user->names }}</td>
                <td>{{ $item->created_at->diffForHumans() }}</td>
                <td>
                    @if($person->hasAccess('delete_supplier'))
                        <a href="#" class="btn btn-sm btn-outline-danger mr-3" onclick="deleteItem('{{ route('supplier.pop', $item->uuid) }}')">
                            <em class="icon ni ni-trash-alt"></em>
                        </a>
                    @endif
                    @if($person->hasAccess('edit_supplier'))
                        <a href="{{ route('supplier.edit', $item->uuid) }}" class="btn btn-sm btn-outline-primary mr-3">
                            <em class="icon ni ni-edit-alt"></em>
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

