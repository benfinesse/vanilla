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
                    <li><a href="#" class="btn btn-white btn-dim btn-outline-primary" onclick="event.preventDefault(); print()"><em class="icon ni ni-printer"></em><span class="d-none d-sm-inline-block">Print</span></a></li>
                    <li><a href="#" class="btn btn-white btn-dim btn-outline-primary" onclick="event.preventDefault(); openModal('{{ $record->uuid }}')"><em class="icon ni ni-mail"></em><span class="d-none d-sm-inline-block">Send Email</span></a></li>
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
                            <p class=""><b>Office Record Trail</b></p>
                            <ul class="timeline">
                                @foreach($record->slips as $slip)
                                    <li class="mb-5">
                                        <div class="ml-5">
                                            <b>{{ $slip->office->name }} Office</b> <small class="ml-3" title="{{ date('F d, Y | h:i', strtotime($slip->created_at)) }}">{{ $slip->created_at->diffForHumans() }}</small>
                                            <p class="mb-0">{{ !empty($slip->lastUser)?$slip->lastUser->names:"pending" }} <small class="ml-3" title="{{ date('F d, Y | h:i', strtotime($slip->updated_at)) }}">{{ $slip->updated_at->diffForHumans() }}</small></p>
                                            <p>{{ $slip->comment }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="print_element">
                <h6 class="mb-2">Record Details</h6>
                <div class="row mt-1">

                    <?php $grand_total = 0; ?>
                    <?php $grand_true_total = 0; ?>
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
                                            <?php $true_total = 0; ?>
                                            @foreach($group_rec->recordItems as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->measure }}</td>
                                                    <td>
                                                        <div>
                                                            {{ $item->qty }}
                                                            @if(!empty($item->true_qty))
                                                                @if($item->true_qty>0)
                                                                    <span class="true_qty_{{ $item->uuid }} fs-9px text-muted"> | {{ $item->true_qty }}</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            {{ number_format($item->price) }}
                                                            @if(!empty($item->true_price))
                                                                @if($item->true_price>0)
                                                                    <span class="true_price_{{ $item->uuid }} fs-9px text-muted"> | {{ number_format($item->true_price) }}</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>

                                                        <div>
                                                            {{ number_format($item->total) }}
                                                            @if(!empty($item->true_price) && !empty($item->true_qty))
                                                                <span class="true_total_{{ $item->uuid }} fs-9px text-muted"> | {{ number_format(floatval($item->true_price) * floatval($item->true_qty)) }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <?php $total+=$item->total; ?>
                                                    <?php $true_total+=!empty($item->true_qty)?$item->true_qty*$item->true_price:0; ?>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <h5 class="text-right">
                                        <?php $grand_total+= $total; ?>
                                        <?php $grand_true_total+= $true_total; ?>

                                        Sub Total: <span class="sub_total">{{ number_format($total) }}</span>
                                        @if($true_total>0)
                                            <br>
                                            <small> True Total {{ number_format($true_total) }}</small>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($grand_total>0)
                        <div class="col-md-6 mb-4 mt-4 half_width">
                            <div class="card card-bordered">
                                <div class="card-inner text-center">
                                    <h4>Grand Total: {{ number_format($grand_total) }}</h4>
                                    @if($grand_true_total>0)

                                        <p class="mt-2"> Final Total {{ number_format($grand_true_total) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="modal_frame"></div>

@endsection

@section('custom_js')
    <script src="{{ asset('app/js/jquery.printElement.min.js') }}"></script>
    <script>
        function openModal(id) {
            let modal_frame = $('.modal_frame');

            let route = '{{ route('send.record.email') }}';

            if(modal_frame.children().length > 0){
                modal_frame.children().remove();
            }
            let elem = `<div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="mailModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <form action="${route}" method="get" style="width: 100%">
                                    <input type="hidden" name="record_id" value="${id}" />
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Send Email</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="form-label" for="price">Email (Recipient)</label>
                                                        <input type="text" id="price" class="form-control" name="emails" placeholder="Email addresses seperated by coma (,)" required autocomplete="off" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <p class="text-danger float-left error_txt"></p>
                                            <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                            <button type="submit" class="btn btn-primary btn_action">
                                                <span class="btn_label">Complete</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>`;
            modal_frame.append(elem);
            $('#mailModal').modal({ show: true});
        }

        function print() {

            var contents = $(".print_element").html();
            var frame1 = $('<iframe />');
            frame1[0].name = "frame1";
            frame1.css({ "position": "absolute", "top": "-1000000px" });
            $("body").append(frame1);
            var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
            frameDoc.document.open();
            //Create a new HTML document.
            frameDoc.document.write('<html><head><title>Print out</title>');
            frameDoc.document.write('</head><body>');
            //Append the external CSS file.


            frameDoc.document.write("<link rel='stylesheet' href='/app/assets/css/dashlite.css'>");
            frameDoc.document.write('<link rel="stylesheet" href="/app/assets/css/theme.css">');
            frameDoc.document.write('<style>.half_width{width: 50%}</style>');


            //Append the DIV contents.
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                frame1.remove();
            }, 500);
        }
    </script>
@endsection
