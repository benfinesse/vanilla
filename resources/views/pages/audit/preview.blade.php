@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Audit record</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('notice.index',['type'=>'all']) }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span class="d-none d-sm-inline-block">All Notice</span></a></li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
        @if(!empty($message))
            <div class="alert alert-info" >
                {{ $message }}
                <a href="#" class="close pull-right" data-dismiss="alert" aria-label="close" >&times;</a>
            </div>
        @endif
    </div>
    <div class="nk-content-wrap">
        <div class="nk-block">
            <h5>Office: <b>{{ $record->office->name }}</b></h5>
            <h6>Process: <b>{{ $record->process->name }}</b></h6>

            <div class="row">

                <?php $grand_total = 0; ?>
                @foreach($record->groups as $group_rec)
                    <div class="col-md-12 mb-4 mt-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <a href="{{ route('record.group.edit', $group_rec->uuid) }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-edit-alt"></em><span class="d-none d-sm-inline-block">Edit</span></a>
                                        <a href="#" class="btn btn-white btn-dim btn-danger"><em class="icon ni ni-trash-alt"></em></a>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-right">
                                            {{ $group_rec->group->name }} Record
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
                                            <th scope="col">Qty</th>
                                            <th scope="col">Unit Price</th>
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
                @endforeach

                @if($grand_total>0)
                    @if(!empty($record->nextOffice))
                        <div class="col-12">
                            <form action="{{ route('record.process.next_office', ['record_id'=>$record->uuid,'dir'=>'next']) }}" method="get">
                                <div class="row">
                                    <div class="col-md-6 mb-4 mt-4">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="form-group">
                                                    <label class="form-label" for="first_name">Comment (optional)</label>
                                                    <input id="first_name" class="form-control" name="comment" value="{{ old('comment') }}" autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 mt-4">
                                        <div class="card card-bordered">
                                            <div class="card-inner text-center">
                                                <h4 class="">Grand Total: {{ number_format($grand_total) }}</h4>
                                                @if(!empty($record->nextOffice))
                                                    <button class="btn btn-outline-primary">Submit to {{ $record->nextOffice->name }}</button>
                                                @else
                                                    <button class="btn btn-outline-primary">Complete and Close Record</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="col-12">
                            <form action="{{ route('record.close', $record->uuid) }}" method="get">
                                <div class="row">
                                    <div class="col-md-6 mb-4 mt-4">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="form-group">
                                                    <label class="form-label" for="first_name">Comment (optional)</label>
                                                    <input id="first_name" class="form-control" name="comment" value="{{ old('comment') }}" autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 mt-4">
                                        <div class="card card-bordered">
                                            <div class="card-inner text-center">
                                                <h4 class="">Grand Total: {{ number_format($grand_total) }}</h4>
                                                @if(!empty($record->nextOffice))
                                                    <button class="btn btn-outline-primary">Submit to {{ $record->nextOffice->name }}</button>
                                                @else
                                                    <button class="btn btn-outline-primary">Complete and Close Record</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    @endif

                    <div class="col-12 mb-4 mt-4">
                        <p class="">Click the <b>submit to ... button</b> above when audit is completed to move audit to the next office. or send it back for review.</p>
                    </div>
                @endif

            </div>

        </div>
    </div>

@endsection
