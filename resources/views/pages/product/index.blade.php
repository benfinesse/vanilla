@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Products</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('product.create') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-file-plus"></em><span><span class="d-none d-sm-inline-block">New</span> Product</span></a></li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="card card-bordered">
                <div class="table-responsive">
                    <table class="table table-tranx table-billing">
                        <thead>
                        <tr class="tb-tnx-head">
                            <th><span class="d-md-inline-block">Name</span></th>
                            <th><span class="d-md-inline-block">Category</span></th>
                            <th><span class="d-md-inline-block">Created At</span></th>
                            <th><span class="d-md-inline-block">Action</span></th>
                        </tr><!-- .tb-tnx-head -->
                        </thead>
                        <tbody>
                        @forelse($data as $item)
                            <tr class="tb-tnx-item">
                                <td>{{ $item->name  }}</td>
                                <td>{{ $item->group->name }}</td>
                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="#" class="text-danger" onclick="deleteItem('{{ route('product.delete', $item->uuid) }}')">
                                        <em class="icon ni ni-trash-alt"></em>
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


            </div>
        </div>
    </div>

@endsection

@section('custom_js')
    <script>
        function deleteItem(url) {
            const answer = prompt("Are you sure? Type 'yes' to perform the operation!");
            if (answer === "yes") {
                //console.log('you said yes')
                window.location.href = url;
            }else{
                console.log('action ignored')
            }
        }
    </script>
@endsection