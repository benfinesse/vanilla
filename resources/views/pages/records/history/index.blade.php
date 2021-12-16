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

            <?php $cash_change = 0; ?>
            <?php $cash_balance = 0; ?>

            <div class="print_element ">
                @if(!empty($record->fund_source))
                    <h6 style="color: forestgreen;">Source: <b>{{ $record->fund_source }}</b></h6>
                    <hr>
                @endif


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
                                                <th scope="col">Item Name <br> <small style="font-size: 12px">(supplier)</small></th>
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
                                                    <td>
                                                        {{ $item->name }}
                                                        @if(!empty($item->supplier))
                                                            <br>
                                                            <small style="font-size: 10px">{{ $item->supplier }}</small>
                                                        @endif


                                                    </td>
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

                                        Cash Required: <span class="sub_total">{{ number_format($total) }}</span>

                                    </h5>
                                    @if($true_total>0)
                                        <br>
                                        <h5 class="text-right mb-0"><small>  Compliance / Cash Spent: {{ number_format($true_total) }}</small></h5>

                                        <h5 class="text-right mb-0 mt-0">
                                            @if($total === $true_total)

                                            @elseif($total > $true_total)
                                                <?php $cash_change += ($total - $true_total)?>
                                                Change of {{ number_format($total - $true_total) }}
                                            @else
                                                <?php $cash_balance += ($true_total - $total)?>
                                                Excess of {{ number_format($true_total - $total) }}
                                            @endif
                                        </h5>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($grand_total>0)
                        <div class="col-md-6 mb-4 mt-3 half_width">
                            <div class="card card-bordered">
                                <div class="card-inner text-center">
                                    <h4>Total Cash Required: <span>N</span>{{ number_format($grand_total) }}</h4>
                                    @if($grand_true_total>0)

                                        <h4 class="mt-2 text-success">Total Cash Spent: <span>N</span>{{ number_format($grand_true_total) }}</h4>
                                        <hr>
                                        <h6>Excess Cash Spent: N{{ number_format($cash_balance) }}</h6>
                                        <h6>Total Change Available: N{{ number_format($cash_change) }}</h6>


                                        <h6>
                                            Final Balance / Change:
                                            @if($cash_balance === $cash_change)

                                            @elseif($cash_change > $cash_balance)
                                                {{ number_format($cash_change - $cash_balance) }}
                                            @else
                                                 {{ number_format($cash_change - $cash_balance ) }}
                                            @endif
                                        </h6>
                                    @endif


                                </div>
                            </div>
                        </div>
                        @if(empty($record->nextOffice))
                            @if($record->status!=="completed")
                                <?php $office = $record->office; ?>
                                @if(!empty($office))
                                    @if(!empty($office->isMember))
                                        <div class="col-md-6 mb-4 mt-3 half_width">
                                            <div class="card card-bordered">
                                                <div class="card-inner text-center">
                                                    <a href="{{ route('record.audit', $record->uuid) }}" class="btn btn-outline-primary">Complete Record</a>
                                                    <br>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                            @endif
                        @endif
                    @endif

                </div>
            </div>

            <br>

            <a href="#" class="btn btn-white btn-dim btn-outline-primary" onclick="event.preventDefault(); purchaseSlip()"><em class="icon ni ni-printer"></em><span class="d-none d-sm-inline-block">Print Purchase Slip</span></a>

            <div class="purchase_slip " style="display: none">
                <h6 class="mb-4 mt-4">Purchase Details</h6>
                <div class=" mt-1">

                    <?php $grand_total = 0; ?>
                    <?php $grand_true_total = 0; ?>
                    <?php $page_count = 0; ?>
                    @foreach($record->groups as $group_rec)
                        <div class="mb-5 mt-5 {{ $page_count>0?"page-break":"" }}">
                            <div class="card">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <h6 class="">
                                            {{ $group_rec->group->name }} Records
                                        </h6>
                                    </div>
                                    <div class="col-6">
                                        <h6>
                                            Date: ............................................................
                                        </h6>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th colspan="3" class="text-uppercase text-center">Shopping Budget</th>
                                            <th colspan="4" class="text-uppercase text-center">Shopping List</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 50px">SUP</th>
                                            <th scope="col">ITEM </th>
                                            <th scope="col">MEASURE</th>
                                            <th scope="col">Stock <br> Outside</th>
                                            <th scope="col">Stock <br> Store</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody class="card_table_content">
                                        <?php $total = 0; ?>
                                        <?php $true_total = 0; ?>
                                        <?php $table_items = $group_rec->recordItems->count(); ?>
                                        <?php $solved = 0; ?>
                                        <?php $gtotal = 0; ?>

                                        @foreach($group_rec->recordItems as $item)
                                            <?php $ttotal = 0; ?>
                                            <tr>
                                                <td>{{ $item->supplier }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->measure }}</td>
                                                <td>{{ $item->stock_outside }}</td>
                                                <td>{{ $item->stock_store }}</td>
                                                <td>
                                                    <div>
                                                        {{ $item->qty }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        {{ number_format($item->price) }}
                                                    </div>
                                                </td>
                                                <td>

                                                    <div>
                                                        {{ number_format($item->total) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if(!empty($item->true_qty))
                                                        @if($item->true_qty)
                                                            {{ $item->true_qty }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td></td>
                                                <td>
                                                    @if(!empty($item->true_price))
                                                        @if($item->true_price>0)
                                                            {{ number_format($item->true_price) }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($item->true_qty) && !empty($item->true_price))
                                                        <?php $ttotal+= $item->true_qty * $item->true_price; ?>
                                                        {{ number_format($ttotal) }}
                                                    @endif
                                                </td>
                                            </tr>

                                            <?php $total+=$item->total; ?>
                                            <?php $gtotal+= $ttotal; ?>

                                            <?php $solved++; ?>
                                            @if($solved===$table_items)
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <b>SubTotal <br> Cash:</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format($total) }}</b>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <b>SubTotal <br> Cash:</b>
                                                    </td>
                                                    <td>
                                                        <b></b>
                                                    </td>

                                                </tr>

                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                            </div>
                        </div>
                            <?php $page_count++; ?>
                    @endforeach

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
            frameDoc.document.write('<style>.half_width{width: 50%}@media print{.page-break  { display:block; page-break-before:always; }}</style>');


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

        function purchaseSlip() {

            var contents = $(".purchase_slip").html();
            var frame1 = $('<iframe />');
            frame1[0].name = "frame1";
            frame1.css({ "position": "absolute", "top": "-1000000px" });
            $("body").append(frame1);
            var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
            frameDoc.document.open();
            //Create a new HTML document.
            frameDoc.document.write('<html><head><title></title>');
            frameDoc.document.write('</head><body>');
            //Append the external CSS file.


            frameDoc.document.write("<link rel='stylesheet' href='/app/assets/css/dashlite.css'>");
            frameDoc.document.write('<link rel="stylesheet" href="/app/assets/css/theme.css">');
            frameDoc.document.write('<style>.half_width{width: 50%}.purchase_slip{display: block}</style>');
            frameDoc.document.write('<style type="text/css" media="print">@page  {size: landscape} @media print{.page-break{page-break-before: always}}</style>');


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
