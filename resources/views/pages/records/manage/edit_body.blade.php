<div class="card card-bordered">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Enter Details</h5>
        </div>
        <form action="#">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="dept"> Department - {{ $dept->name }}</label>
                        <input type="hidden" name="group_id" value="{{ $dept->name }}" required />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="dept"> Date</label>
                        <input type="date" class="form-control date_field input_sync" name="date" value="{{ date('Y-m-d', strtotime($groupRecord->created_at)) }}" required />
                    </div>
                </div>

                <div class="col-12 table-responsive mb-5">
                    <table class="table table-hover">
                        @include('components.tables.record_table_head')
                        <tbody class="card_table_content">
                        <tr>
                            <td class="text-center" colspan="8">
                                <b>No Items Added</b>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-12">
                    <div class="row input_fields_section">
                        <div class="col-12 mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="msg_field"></div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="item_name ">Item Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control item_name item_val input_sync" id="item_name" name="item_name" list="products" autocomplete="off">
                                            <datalist id="products">
                                                @foreach($products as $product)
                                                    <option data-price="{{ $product->price }}" data-measure="{{ $product->measure }}" value="{{ $product->name }}" >{{ $product->measure }}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-label" for="item_qty">Quantity</label>
                                        <div class="form-control-wrap">
                                            <input type="text" onkeypress="return numbersOnly(event)" class="form-control p_control item_qty item_val input_sync" id="item_qty">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-label" for="item_price">Price</label>
                                        <div class="form-control-wrap">
                                            <input type="text" onkeypress="return numbersOnly(event)" class="form-control p_control item_price item_val input_sync" id="item_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-label" for="item_measure">Measure</label>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control item_measure item_val input_sync" id="item_measure" required>
                                                    @foreach($measures as $measure)
                                                        <option value="{{ $measure->name }}">{{ $measure->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-label" for="item_amount">Amount</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control item_amount item_val" id="item_amount" value="0" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">

                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="item_stock_outside">Supplier</label>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control item_supplier item_val input_sync" id="item_supplier" required>
                                                    <option value="" selected disabled="disabled">Select Supplier</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->name }}" {{ $supplier->name==='Market'?'selected':'' }}>{{ $supplier->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <div class="form-group">
                                        <label class="form-label" for="item_stock_outside">Stock Outside</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control p_control item_stock_outside item_val input_sync" id="item_stock_outside" value="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-5">
                                    <div class="form-group">
                                        <label class="form-label" for="item_stock_store">Stock Store</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control p_control item_stock_store item_val input_sync" id="item_stock_store" value="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <label class="form-label" for="pay-amount-1">Add</label>
                                        <div class="form-control-wrap">
                                            <button class="btn btn-success" onclick="event.preventDefault(); addItem()">
                                                <em class="icon ni ni-check-c"></em>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <hr>
                    <div class="form-group">
                        <h5 class="text-right">
                            Sub Total: <span class="sub_total">0.00</span>
                        </h5>
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="event.preventDefault(); submitForm()" class="btn btn-lg btn-primary btn_sync">
                            <span class="process_text">Update Record</span>
                            <div class="spinner-border process_loader" role="status" style="display: none; width: 1.4em; height: 1.4em;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal_context"></div>

@section('manage_logic')
    <script>
        "use strict";
        let items = [];
        let listObject = {
            name:"",
            qty:0,
            price:0,
            measure:"",
            amount:0,
            stock_outside:0,
            stock_store:0,
            supplier:"",
        };
        var controlConfig = null;
        var editPos = null;

        async function addItem() {
            let fields = $('.item_val');
            let process = true;

            await fields.each(function (a,b) {
                let val = $(this).val();
                if(val !== "" && val !== null){
                    if(a===0){listObject.name=val}
                    if(a===1){listObject.qty=val}
                    if(a===2){listObject.price=val}
                    if(a===3){listObject.measure=val}
                    if(a===4){listObject.amount=val}
                    if(a===5){listObject.supplier=val}
                    if(a===6){listObject.stock_outside=val}
                    if(a===7){listObject.stock_store=val}
                }else{
                    process = false;
                }
            });

            //check if item is already in list
            let exist = await items.find(o => o.name === listObject.name);

            if(process){

                if(editPos!= null){
                    items[editPos].name = listObject.name;
                    items[editPos].qty = listObject.qty;
                    items[editPos].price = parseFloat(listObject.price);
                    items[editPos].measure = listObject.measure;
                    items[editPos].amount = parseFloat(listObject.amount);
                    items[editPos].supplier = listObject.supplier;
                    items[editPos].stock_outside = listObject.stock_outside;
                    items[editPos].stock_store = listObject.stock_store;
                    $("#modal_edit").modal('hide');
                    await resControl();

                    resetListObject();
                    resetFields()
                    console.log(items);

                    await reloadTable();
                }else{

                    if(exist == null){
                        items.push({
                            name:listObject.name,
                            qty:listObject.qty,
                            price:parseFloat(listObject.price),
                            measure:listObject.measure,
                            amount:parseFloat(listObject.amount),
                            supplier: listObject.supplier,
                            stock_outside:listObject.stock_outside,
                            stock_store:listObject.stock_store,
                        });

                        resetListObject();
                        resetFields()
                        console.log(items);
                        exist = null;

                        await reloadTable();
                    }else{
                        toast('error', `Item with name '${exist.name}' already added to list`);
                    }
                }

            }else{
                toast('error', 'one or more required fields might be empty.')
            }
        }

        function resetListObject() {
            listObject.name="";
            listObject.qty=0;
            listObject.price=0;
            listObject.measure="";
            listObject.amount=0;
        }

        $(document).on('keyup','.item_name', function(event){
            // $('.item_name').on('keyup', async function (e) {
            var price = 0;
            let measure = null;
            let val = this.value;
            let option = $(`option[value='${val}']`);
            if(option.length>0){
                price = option.data("price");
                measure = option.data("measure");
            }
            $('.item_price').val(price)
            if(measure!==null){
                $('.item_measure').val(measure)
            }
        });

        function resetFields() {
            $('.item_val').val("");
            $('.item_amount').val("0");
            $('.item_stock_outside').val("0");
            $('.item_stock_store').val("0");
            $('.item_supplier').val("Market");
        }

        $(document).on('keyup','.p_control', function(event){
        // $('.p_control').on('keyup', function (e) {
            let qty = parseFloat($('.item_qty').val());
            let price = parseFloat($('.item_price').val());
            let amount = $('.item_amount');
            if(qty>0 && price>0){
                amount.val(qty*price)
            }else{
                amount.val(0)
            }
        });

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

        function toast(type, msg, time) {
            let msg_field = $('.msg_field');
            let duration = 4000;
            console.log("duration ", duration);
            if(time){
                duration = time;
            }
            let klas = 'info';
            if(type==='error'){
                klas = 'danger';
            }else if(type==='success'){
                klas = 'success'
            }
            msg_field.append(`<p class="text-${klas}">${msg}</p>`);
            setTimeout(function () {
                msg_field.children().remove()
            }, duration)
        }

        async function reloadTable() {
            let tbody = $('.card_table_content');
            let sub_total = $('.sub_total');
            tbody.children().remove();
            sub_total.text("0.00");
            let total = 0;
            if(items.length > 0){

                await items.forEach(function (item, i) {
                    let supply = item.supplier !== null ? item.supplier:'';
                    tbody
                        .append(`<tr>
                            <td>${item.name} <br> <small style="font-size: 10px">${supply}</small></td>
                            <td>${item.measure}</td>
                            <td>${item.stock_outside}</td>
                            <td>${item.stock_store}</td>
                            <td>${item.qty}</td>
                            <td>${doPrint(item.price)}</td>
                            <td>${doPrint(item.amount)}</td>

                            <td>
                                <button class="btn btn-primary btn-sm" onclick="event.preventDefault(); editItem(${i})">
                                    <em class="icon ni ni-edit-alt"></em>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="removeItem(${i})">
                                    <em class="icon ni ni-trash-alt"></em>
                                </button>
                            </td>
                        </tr>`);

                    total += item.amount;

                });
                sub_total.text(doPrint(total));
            }else{
                tbody.append(`<tr>
                            <td class="text-center" colspan="8">
                                <b>No Items Added</b>
                            </td>
                        </tr>`);
            }
        }

        async function removeItem(pos) {
            await items.splice(pos, 1);
            toast('info', "One item removed from list.")
            await reloadTable()

        }

        async function editItem(pos) {
            let editable = items[pos];
            console.log(editable);
            editModal(pos);

            $('#modal_edit').modal('show');


            // await items.splice(pos, 1);

            // await reloadTable();

            $('.item_name').val(editable.name);
            $('.item_qty').val(editable.qty);
            $('.item_price').val(editable.price);
            $('.item_measure').val(editable.measure);
            $('.item_amount').val(editable.amount);

            $('.item_supplier').val(editable.supplier);
            $('.item_stock_outside').val(editable.stock_outside);
            $('.item_stock_store').val(editable.stock_store);

        }

        function doPrint(val) {
            return val.toLocaleString('en-US', {maximumFractionDigits:2})
        }

        function submitForm() {
            processLoader('show');
            toggleFields(false);
            if(items.length>0){
                let date = $('.date_field').val();
                if(date!==""){
                    processForm(date);
                }else{
                    toast('error', 'Date field is empty.')
                    processLoader('hide');
                    toggleFields(true);
                }
            }else{
                toast('error', 'Form empty. Please add items to form.')
                toggleFields(true);
                processLoader('hide');
            }
        }

        function processForm(date) {
            let _token   = $('meta[name="csrf-token"]').attr('content');
            let slip_custom_id = $('.slip_custom_id').val();
            let invoice_date = $('.invoice_date').val();
            let dept_id = "{{ $dept->uuid }}";
            let group_record_id = "{{ $groupRecord->uuid }}";
            $.ajax({
                url: "{{ route('form.update', $record->uuid) }}",
                type:"POST",
                data:{
                    _token: _token,
                    items: items,
                    dept_id:dept_id,
                    group_record_id:group_record_id,
                    date:date
                },
                success: function (res) {
                    console.log(res);
                    //hide loader


                    if(res.success){
                        //empty deck

                        toast('success', '', `${res.message}`);
                        setTimeout(()=>{
                            window.location = "{{ str_replace("?message=Record%20Updated%20Successfully", "", $referer) }}?message=Record Updated Successfully";
                        }, 2000)
                    }else{
                        processLoader('hide');
                        toggleFields(true);
                        toast('error', `server response: ${res.message}`, 7000)
                    }

                    // You will get response from your PHP page (what you echo or print)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    processLoader('hide');
                    toggleFields(true);
                    toast('error', 'Unable to complete. Try again later.')
                    console.log(textStatus, errorThrown);
                }
            });
        }

        function processLoader(action){
            let loader = $('.process_loader');
            let text = $('.process_text');
            if(action==='hide'){
                loader.hide();
                text.show();
            }else{
                loader.show();
                text.hide();
            }
        }

        function resetDeck() {
            items = [];
            reloadTable();
        }

        function toggleFields(action){
            let inputs = $('.input_sync');
            let btn = $('.btn_sync');
            if(action){
                inputs.prop("disabled",false);
                btn.prop("disabled",false);
            }else{
                inputs.prop("disabled",true);
                btn.prop("disabled",true);
            }
        }

        function loadTable() {
            resetDeck();

            processLoader('show');

            let _token = $('meta[name="csrf-token"]').attr('content');
            let record_id = "{{ $record->uuid }}";

            $.ajax({
                url: "{{ route('record.load', ['record_id'=>$record->uuid, 'group_id'=>$dept->uuid]) }}",
                type:"POST",
                data:{
                    _token: _token,
                    record_id :record_id
                },
                success: function (res) {
//                    console.log(res);
                    //hide loader


                    if(res.success){
                        //empty deck
//                        console.log(res.data.group_items);
                        res.data.group_items.forEach( async (item, pos)=> {
                            await loadList(item);
                        });
                        reloadTable();
                        toast('success', '', `${res.message}`)
                        processLoader('hide');
                        toggleFields(true);
                    }else{
                        processLoader('hide');
                        toggleFields(true);
                        toast('error', `server response: ${res.message}`, 7000)
                    }

                    // You will get response from your PHP page (what you echo or print)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    processLoader('hide');
                    toggleFields(true);
                    toast('error', 'Unable to complete. Try again later.')
                    console.log(textStatus, errorThrown);
                }
            });
        }

        loadTable();

        async function loadList(item) {
            await items.push({
                name:item.name,
                qty:item.qty,
                price:parseFloat(item.price),
                measure:item.measure,
                amount:parseFloat(item.price*item.qty),
                supplier:item.supplier,
                stock_outside:item.stock_outside,
                stock_store:item.stock_store,
            });

            console.log(item);
        }

        function editModal(pos){
            editPos = pos;
            let controls = $('.input_fields_section');
            controlConfig = controls.html();
            console.log(controlConfig);
            let modalView =
                `<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_edit" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resControl()">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                <div class="modal-body">
                                <div class="p-3 modal_context_content">
                                    <div class="row">
                                        ${controlConfig}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

            //remove old modal
            let mcontent =  $('.modal_context');
            mcontent.children().remove();
            controls.children().remove();
            mcontent.append(modalView);
        }

        async function  resControl() {
            await $('.input_fields_section').append(controlConfig);

            controlConfig = null;
            editPos = null;

        }
    </script>
@endsection