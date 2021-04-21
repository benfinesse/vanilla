@extends('layouts.app')

@section('custom_css')
    <style>
        ul.timeline {
            list-style-type: none;
            position: relative;
        }
        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
        }
        ul.timeline > li {
            margin: 20px 0;
            padding-left: 20px;
        }
        ul.timeline > li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }
    </style>
@endsection

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Record History</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('record.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span class="d-none d-sm-inline-block">Records</span></a></li>
                </ul>
            </div>
        </div>
        @include('layouts.notice')
    </div>
    <div class="nk-content-wrap">
        <div class="nk-block">
            <h6>Current Status: <b>{{ $record->status }}</b></h6>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <p class=""><b>Record Trail</b></p>
                            <ul class="timeline">
                                @foreach($record->slips as $slip)
                                    <li class="mb-5">
                                        <div class="ml-5">
                                            <b>{{ $slip->office->name }}</b>
                                            <p title="{{ date('F d, Y', strtotime($slip->created_at)) }}">{{ $slip->created_at->diffForHumans() }}</p>
                                            <p>{{ $slip->comment }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <h6 class="mb-0">Record Details</h6>
            <div class="row mt-1">

                <?php $grand_total = 0; ?>
                @foreach($record->groups as $group_rec)
                    <div class="col-md-12 mb-5 ">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="row mb-3">
                                    <div class="col-6">

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
                    <div class="col-md-6 mb-4 mt-4">
                        <div class="card card-bordered">
                            <div class="card-inner text-center">
                                <h4 class="">Grand Total: {{ number_format($grand_total) }}</h4>
                            </div>
                        </div>
                    </div>
                @endif

            </div>


        </div>
    </div>

@endsection
