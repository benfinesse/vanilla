@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Department Records</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('record.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span class="d-none d-sm-inline-block">Back</span></a></li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    <div class="nk-content-wrap">
        <div class="nk-block">
            <p>Record submission on process: <b>{{ $record->process->name }}</b></p>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <p>Create Record for at least one available departments.</p>
                </div>
                <?php $grand_total = 0; ?>
                @foreach($groups as $group)
                    <?php $group_rec =  $group->hasRecord($record->uuid); ?>
                    @if($group_rec)
                        <div class="col-md-12 mb-4 mt-4">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <a href="#" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-edit-alt"></em><span class="d-none d-sm-inline-block">Edit</span></a>
                                            <a href="#" class="btn btn-white btn-dim btn-danger"><em class="icon ni ni-trash-alt"></em></a>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="text-right">
                                                {{ $group->name }} Record
                                            </h6>
                                            <p class="text-right">
                                                {{ $group_rec->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Measure</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody class="card_table_content">
                                            <?php $total = 0; ?>
                                                @foreach($group_rec->recordItems as $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->measure }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ number_format($item->price) }}</td>
                                                        <td>{{ number_format($item->total) }}</td>
                                                        <?php $total+=$item->total; ?>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <h5 class="text-right">
                                        <?php $grand_total+= $total; ?>
                                        Sub Total: <span class="sub_total">{{ number_format($total) }}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-6 mb-4 mt-4">
                            <div class="card card-bordered">
                                <div class="card-inner text-center">
                                    <h4 class="">{{ $group->name }}</h4>
                                    <a href="{{ route('record.manage', ['uuid'=>$record->uuid, 'gid'=>$group->uuid]) }}" class="btn btn-primary">Create {{ $group->name }} Record</a>
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach

                @if($grand_total>0)
                    <div class="col-md-6 mb-4 mt-4">
                        <div class="card card-bordered">
                            <div class="card-inner text-center">
                                <h4 class="">Grand Total: {{ number_format($grand_total) }}</h4>
                                <a href="{{ route('record.process.start', $record->uuid) }}" class="btn btn-outline-primary">Submit to {{ $record->process->name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4 mt-4">
                        <p class="">Click the <b>submit to ... button</b> above when required department records are entered to start.</p>
                    </div>
                @endif

            </div>

            <br>
            @if($record->ready)
                <a href="#" class="btn btn-primary">
                    <em class="icon ni ni-send mr-2" style="font-size: 15px" ></em>
                    Submit Record
                </a>
            @endif

        </div>
    </div>

@endsection
