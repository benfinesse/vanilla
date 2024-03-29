@extends('layouts.app')

@section('custom_css')
    <style>
        .changes_panel{
            display: none;
        }


    </style>
@endsection

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
            <h6 style="color: forestgreen;">Source: <b>{{ !empty($record->fund_source)?$record->fund_source:'Not Updated' }}</b></h6>

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
                                            <th scope="col">Item Name <br> <small style="font-size: 12px">(supplier)</small></th>
                                            <th scope="col">Measure</th>
                                            <th scope="col">Stock <br> Outside</th>
                                            <th scope="col">Stock <br> Store</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Total</th>
                                            @if($record->office->verifiable)
                                                <th scope="col">Action</th>
                                            @endif

                                        </tr>
                                        </thead>
                                        <tbody class="card_table_content">
                                        <?php $total = 0; ?>
                                        @foreach($group_rec->recordItems as $item)
                                            <tr style="{{ $item->excluded?'color: #e9e9e9':'' }}" >
                                                <td>
                                                    @if($item->excluded)
                                                        <s>{{ $item->name }}</s>
                                                        @if(!empty($item->supplier))
                                                            <br>
                                                        <s>
                                                            <small style="font-size: 10px">{{ $item->supplier }}</small>
                                                        </s>
                                                        @endif
                                                    @else
                                                        {{ $item->name }}
                                                        @if(!empty($item->supplier))
                                                            <br>
                                                            <small style="font-size: 10px">{{ $item->supplier }}</small>
                                                        @endif
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($item->excluded)
                                                        <s>{{ $item->measure }}</s>
                                                    @else
                                                    {{ $item->measure }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->excluded)
                                                        <s>{{ $item->stock_outside }}</s>
                                                    @else
                                                        {{ $item->stock_outside }}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($item->excluded)
                                                        <s>{{ $item->stock_store }}</s>
                                                    @else
                                                        {{ $item->stock_store }}
                                                    @endif

                                                </td>
                                                <td>
                                                    <div class="qty_wrapper_{{ $item->uuid }}">
                                                        <div>
                                                            @if($item->excluded)
                                                                <s>{{ $item->qty }}</s>
                                                                @if(!empty($item->true_qty))
                                                                    @if($item->true_qty>0)
                                                                        <s><span class="true_qty_{{ $item->uuid }} fs-9px text-muted"> | {{ $item->true_qty }}</span></s>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                {{ $item->qty }}
                                                                @if(!empty($item->true_qty))
                                                                    @if($item->true_qty>0)
                                                                        <span class="true_qty_{{ $item->uuid }} fs-9px text-muted"> | {{ $item->true_qty }}</span>
                                                                    @endif
                                                                @endif
                                                            @endif

                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="price_wrapper_{{ $item->uuid }}">
                                                        <div>
                                                            @if($item->excluded)
                                                                <s>{{ number_format($item->price) }}</s>
                                                                @if(!empty($item->true_price))
                                                                    @if($item->true_price>0)
                                                                        <s><span class="true_price_{{ $item->uuid }} fs-9px text-muted"> | {{ number_format($item->true_price) }}</span></s>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                {{ number_format($item->price) }}
                                                                @if(!empty($item->true_price))
                                                                    @if($item->true_price>0)
                                                                        <span class="true_price_{{ $item->uuid }} fs-9px text-muted"> | {{ number_format($item->true_price) }}</span>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="total_wrapper_{{ $item->uuid }}">
                                                        <div>
                                                            @if($item->excluded)
                                                                <s>{{ number_format($item->total) }}</s>
                                                                @if(!empty($item->true_price) && !empty($item->true_qty))
                                                                    <s><span class="true_total_{{ $item->uuid }} fs-9px text-muted"> | {{ number_format(floatval($item->true_price) * floatval($item->true_qty)) }}</span></s>
                                                                @endif
                                                            @else
                                                                {{ number_format($item->total) }}
                                                                @if(!empty($item->true_price) && !empty($item->true_qty))
                                                                    <span class="true_total_{{ $item->uuid }} fs-9px text-muted"> | {{ number_format(floatval($item->true_price) * floatval($item->true_qty)) }}</span>
                                                                @endif
                                                            @endif



                                                        </div>
                                                    </div>
                                                </td>
                                                @if($record->office->verifiable)
                                                    <td class="btn_wrapper btn_wrp_{{$item->uuid}}">
                                                        <a href="#" class="btn btn-sm btn-outline-primary" onclick="event.preventDefault(); openModal('{{$item->name}}','{{ !empty($item->true_price)?$item->true_price:$item->price }}', '{{ !empty($item->true_qty)?$item->true_qty:$item->qty }}', '{{ $item->uuid }}' )">
                                                            Compliance
                                                        </a>
                                                        <a href="{{ route('item.toggle.availability', ['item_id'=>$item->uuid]) }}" class="btn btn-sm btn-outline-dark">
                                                            {{ $item->excluded?"Include":"Exclude" }}
                                                        </a>
                                                    </td>
                                                @endif
                                                @if(!$item->excluded)
                                                    <?php $total+=$item->total; ?>
                                                @endif

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <button onclick="revealChange('{{ $group_rec->uuid }}_change_panel')" class="btn btn-white btn-dim btn-outline-primary">
                                            <em class="icon ni ni-histroy"></em>
                                            <span class="d-none d-sm-inline-block">View Changes</span>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-right">
                                            <?php $grand_total+= $total; ?>
                                            Sub Total: <span class="sub_total">{{ number_format($total) }}</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="changes_panel mt-5 {{ $group_rec->uuid }}_change_panel">
                                    <button onclick="closeElem('{{ $group_rec->uuid }}_change_panel')" class="float-right btn btn-white btn-dim btn-danger"><b>X</b></button>
                                    @if($group_rec->loggroup->count()>0)
                                        @foreach($group_rec->loggroup as $loggroup)
                                            <p>
                                                Edited by {{ $loggroup->user->names }} on {{ date('F d, Y h:i', strtotime($loggroup->created_at)) }}
                                            </p>
                                            <div class="table-responsive mb-5">
                                                <table class="table table-hover">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Item Name</th>
                                                        <th scope="col">Old Qty</th>
                                                        <th scope="col">New Qty</th>
                                                        <th scope="col">Old Price</th>
                                                        <th scope="col">New Price</th>
                                                        <th scope="col" style="width: 400px">Action Taken</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody class="card_table_content">

                                                    @foreach($loggroup->logs as $log)
                                                        <tr>
                                                            <td>{{ $log->name }}</td>
                                                            <td>{{ $log->old_qty }}</td>
                                                            <td>{{ $log->new_qty }}</td>
                                                            <td>{{ number_format($log->old_price) }}</td>
                                                            <td>{{ number_format($log->new_price) }}</td>
                                                            <td>{{ "({$log->info}) ".$log->action_taken }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach

                                    @else
                                        <p class="text-center"><b>No Change Log</b></p>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

                @if($grand_total>0)
                    @if(!empty($record->nextOffice))
                        <div class="col-12">
                            <?php
                                $approvable_state = @$record->office->approvable?"yes":"no";
                            ?>
                            <form action="{{ route('record.process.next_office', ['record_id'=>$record->uuid,'dir'=>'next']) }}" method="get" id="actionComForm">
                                <input type="hidden" name="coffice" value="{{ $record->office->uuid }}">
                                <input type="hidden" name="approvable" value="{{ $approvable_state }}">

                                <div class="row">
                                    @if($person->hasAccess('fund_source'))
                                        @if(@$record->office->funds)
                                            <div class="col-12 mb-4 mt-4">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="first_name">Fund Source (required)</label>
                                                                    <select name="fund_source" class="form-control" id="" required>
                                                                        <option value="" selected>Select One Option</option>
                                                                        @foreach($sources as $source)
                                                                            <option value="{{ $source }}" {{ $record->fund_source===$source?'selected':'' }}>{{ $source }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="amount_approved">Approved Amount (required - numbers only)</label>
                                                                    <input id="amount_approved" required class="form-control" onkeypress="return numbersOnly(event)" name="amount_approved" value="{{ $record->amount_approved }}" placeholder="ENTER AMOUNT APPROVED" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    @endif

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

                                                @if(!empty($record->prevOffice))
                                                    @if($record->office->funds)
                                                    @else
                                                        <!-- the onclick function is not deleting the item but calling the link with custom warning first -->
                                                        <a href="javascript:void(0)" onclick="deleteItem('{{ route('record.process.next_office', ['record_id'=>$record->uuid,'dir'=>'prev','coffice'=>$record->office->uuid]) }}', 'Are you sure you want to submit to previous office? type yes to proceed.')" class="btn btn-dark mr-2 mb-3">
                                                            <i class="ni ni-back-arrow-fill mr-3"></i> Return to {{ $record->prevOffice->name }}
                                                        </a>
                                                    @endif



                                                @endif

                                                @if(!empty($record->nextOffice))
                                                    @if($record->office->approvable)
                                                        <a href="javascript:void(0)" class="btn btn-outline-primary ml-2 mb-3" onclick="verifyAction('actionComForm', 'final_approve','{{ $record->nextOffice->name }}')"> Approve <i class="ni ni-check-round ml-3"></i></a>
                                                    @else
                                                        <a href="javascript:void(0)" class="btn btn-outline-primary ml-2 mb-3" onclick="verifyAction('actionComForm', 'Approve','{{ $record->nextOffice->name }}')"> Approve <i class="ni ni-forward-arrow-fill ml-3"></i></a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0)" class="btn btn-outline-primary ml-2 mb-3" onclick="verifyAction('actionComForm','Complete', 'Complete and Close')"> Complete and Close Record <i class="ni ni-check-round-fill ml-3"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="col-12">
                            <form action="{{ route('record.close', $record->uuid) }}" method="get" id="actionComForm">
                                <input type="hidden" name="coffice" value="{{ $record->office->uuid }}">
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
                                                <h4 class="">Grand Total: N {{ number_format($grand_total) }}</h4>
                                                @if(!empty($record->amount_approved) )
                                                    <h4 class="text-success">Approved: N {{ number_format($record->amount_approved) }}</h4>
                                                @endif
                                                <!-- remove below -->
                                                {{--@include('layouts.trash1content')--}}
                                                <!-- stop remove -->
                                                @if(!empty($record->prevOffice))
                                                    @if($record->office->funds)
                                                    @else
                                                        <!-- the onclick function is not deleting the item but calling the link with custom warning first -->
                                                        <a href="javascript:void(0)" onclick="deleteItem('{{ route('record.process.next_office', ['record_id'=>$record->uuid,'dir'=>'prev','coffice'=>$record->office->uuid]) }}', 'Are you sure you want to submit to previous office? type yes to proceed.')" class="btn btn-dark mr-2 mb-3">
                                                            <i class="ni ni-back-arrow-fill mr-3"></i> Return to {{ $record->prevOffice->name }}
                                                        </a>
                                                    @endif
                                                @endif



                                                @if(!empty($record->nextOffice))
                                                    <a href="javascript:void(0)" class="btn btn-outline-primary ml-2 mb-3" onclick="verifyAction('actionComForm', 'Approve', '{{ $record->nextOffice->name }}')"> Approve <i class="ni ni-forward-arrow-fill ml-3"></i></a>
                                                @else
                                                    <a href="{{ route('record.history', $record->uuid) }}" class="btn btn-info mr-2 ml-2 mb-3">
                                                        <i class="ni ni-clock mr-3"></i> Full Details
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-outline-primary ml-2 mb-3" onclick="verifyAction('actionComForm', 'Complete', 'Complete and Close')"> Complete and Close Record <i class="ni ni-check-round-fill ml-3"></i></a>
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
    
    <div class="modal_frame"></div>



@endsection

@section('custom_js')
    <script>

        function openModal(title, price, qty, uuid){

            console.log("opening dialog");



            let modal_frame = $('.modal_frame');

            console.log('modal length is ',modal_frame.children().length, `showing title ${title}, price ${price}, qty ${qty}`);

            if(modal_frame.children().length > 0){
                modal_frame.children().remove();
            }

            let elem = `<div class="modal fade" id="complianceModal" tabindex="-1" role="dialog" aria-labelledby="complianceModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">${title}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-label" for="price">Purchase Price</label>
                                                    <input type="text" id="price" onkeypress="return numbersOnly(event)" class="form-control input_price" name="price" placeholder="Market Purchase price" required="" autocomplete="off" value="${price}" >
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-label" for="qty">Quantity purchased</label>
                                                    <input type="text" id="qty" onkeypress="return numbersOnly(event)" class="form-control input_qty" name="qty" required="" placeholder="Quantity Purchased" value="${qty}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <p class="text-danger float-left error_txt"></p>
                                        <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                        <button type="button" class="btn btn-primary btn_action" onclick="complete('${uuid}', '${title}','${qty}','${price}')">
                                            <span class="btn_label">Complete</span>
                                            <div class="spinner-border" role="status" style="display: none; width: 1rem;height: 1rem;">
                                              <span class="sr-only">Loading...</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            modal_frame.append(elem);
            $('#complianceModal').modal({ show: true});
        }

        function complete(id, title, qty, price) {
            let label = $('.btn_label');
            let spinner = $('.spinner-border');
            let btn = $('.btn_action');


            let input_price = $('.input_price').val();
            let input_qty = $('.input_qty').val();

            let err = $('.error_txt');

            if(input_price!=="" && input_qty!=="" ){

                label.hide();
                spinner.show();
                btn.prop('disabled', true);

                let _token   = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('item.inject') }}"+`?item_id=${id}`,
                    type:"POST",
                    data:{
                        _token: _token,
                        id: id,
                        price:input_price,
                        qty:input_qty
                    },
                    success: function (res) {
                        console.log(res);
                        //hide loader


                        if(res.success){
                            spinner.hide();
                            btn.prop('disabled', false);
                            btn.removeClass('btn-primary');
                            btn.addClass('btn-success');
                            label.text("completed");
                            label.show();

                            //update fields
                            updateFields(res.item);

                            //replace button
                            let btn_wrapper = $(`.btn_wrp_${id}`);
                            btn_wrapper.children().remove();
                            btn_wrapper.append(`<a href="#" class="btn btn-sm btn-outline-primary" onclick="event.preventDefault(); openModal('${title}','${input_price}', '${input_qty}', '${id}' )">Compliance</a>`);
                            setTimeout(()=>{$('#complianceModal .close').click()}, 2000);
                        }else{
                            spinner.hide();
                            $('.btn_action').prop('disabled', false);
                            err.text(res.message);
                            label.show();
                        }

                        // You will get response from your PHP page (what you echo or print)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        spinner.hide();
                        err.text("Could not complete. try again later.")
                        $('.btn_action').prop('disabled', false);
                        label.show();

                        // $('#complianceModal').modal({ show: false })
                    }
                });


            }else{
                err.text("One or more fields are missing.")
                setTimeout(()=>{
                    err.text("")
                }, 4000);
            }
        }

        function updateFields(item) {
            let qty_wrapper = $(`.qty_wrapper_${item.uuid}`);
            let price_wrapper = $(`.price_wrapper_${item.uuid}`);
            let total_wrapper = $(`.total_wrapper_${item.uuid}`);

            qty_wrapper.children().remove();
            price_wrapper.children().remove();
            total_wrapper.children().remove();

            qty_wrapper.append(`<div>${doPrint(item.qty)} <span class="true_qty_${item.uuid} fs-9px text-muted"> | ${doPrint(item.true_qty)}</span></div>`);
            price_wrapper.append(`<div>${doPrint(item.price)} <span class="true_qty_${item.uuid} fs-9px text-muted"> | ${doPrint(item.true_price)}</span></div>`);
            total_wrapper.append(`<div>${doPrint(item.qty*item.price)} <span class="true_total_${item.uuid} fs-9px text-muted"> | ${doPrint(item.true_qty*item.true_price)}</span></div>`);
        }

        function numbersOnly(evt) {
            let k = evt.key;
            if(k===" "){
                return false;
            }
            if(k==="."){
                return true;
            }
            if(isNaN(k)){
                return false;
            }
        }

        function doPrint(val) {
            return val.toLocaleString('en-US', {maximumFractionDigits:2})
        }

        function revealChange(id) {
            $('.changes_panel').hide();
            let elem = $(`.${id}`);
            elem.slideToggle();
        }

        function closeElem(id) {
            let elem = $(`.${id}`);
            elem.slideToggle();
        }

        function verifyAction(id, action, office) {
            console.log("form id is ", id);
            let modal_frame = $('.modal_frame');

            if(modal_frame.children().length > 0){
                modal_frame.children().remove();
            }

            let intro = "";
            let title = "Approve";
            let btn_title = "Approve";
            if(action==='Approve'){
                intro = `Your approval will send this request to : ${office}. Continue?`;
            }else if(action==='final_approve'){
                intro = "Final Approval. Do you wish to continue?"
                title = "Final Approval"
                btn_title = "Approve";
            }else{
                intro = "Completing this will prevent further changes. Continue?";
                btn_title = "Complete";
                title = "Complete";
            }

            let elem = `<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">${title}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <h5>${intro}</h5>
                                            <br>
                                            <a href="javascript:void(0)" onclick="submitForm('${id}');" class="btn btn-primary">${btn_title}</a>

                                            <button onclick="" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">Cancle</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            modal_frame.append(elem);
            $('#approvalModal').modal({ show: true});
        }

        function submitForm(id) {
            document.getElementById(id).submit();
            // let form = $('#'+`${id}`);
            // console.log(form)
        }

    </script>
@endsection