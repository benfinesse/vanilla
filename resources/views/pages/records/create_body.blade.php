<div class="card card-bordered">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Enter Details</h5>
        </div>
        <form action="#">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="process">Select Process</label>
                        <div class="form-control-wrap ">
                            <div class="form-control-select">
                                <select class="form-control" id="process" required>
                                    <option selected disabled>Select Option</option>
                                    @foreach($processes as $process)
                                        <option value="{{ $process->uuid }}">{{ $process->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="dept">Select Department</label>
                        <div class="form-control-wrap ">
                            <div class="form-control-select">
                                <select class="form-control" id="dept" required>
                                    <option selected disabled>Select Option</option>
                                    @foreach($depts as $dept)
                                        <option value="{{ $dept->uuid }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 table-responsive mb-5">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Item Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Measure</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody class="card_table_content">
                        <tr>
                            <td class="text-center" colspan="5">
                                <b>No Items Added</b>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-12 mb-5">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="item_name">Item Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control item_name" id="item_name" name="item_name">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="item_qty">Quantity</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control item_qty" id="item_qty">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="item_measure">Measure</label>
                                <div class="form-control-wrap ">
                                    <div class="form-control-select">
                                        <select class="form-control item_measure" id="item_measure" required>
                                            <option selected disabled>Select</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="item_amount">Amount</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control item_amount" id="item_amount" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="pay-amount-1">Complete</label>
                                <div class="form-control-wrap">
                                    <button class="btn btn-primary" onclick="event.preventDefault(); ">Add Item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary">Save Record</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>