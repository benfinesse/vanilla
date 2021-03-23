@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">New Records</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-plus-c"></em><span><span class="d-none d-sm-inline-block">New</span> Dept.</span></a></li>
                    <li><a href="{{ route('record.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span><span class="d-none d-sm-inline-block">Back</span> </span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="nk-content-wrap">

        @if($measures->count() < 1)
            <div class="alert alert-danger">
                <em class="ni ni-alert-c" style="font-size: 15px"></em> Add Measure to continue
            </div>
        @else
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">Begin New Record</h5>
                        </div>
                        <form action="{{ route('record.store') }}" method="post">
                            @csrf
                            <p class="text-left">Select a process to begin.</p>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="process">Select Process</label>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select name="process_id" class="form-control" id="process" required="required">
                                                    <option selected disabled value="">Select Option</option>
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
                                        <label class="form-label" for="process">Begin Process</label>
                                        <div class="form-control-wrap ">
                                            <button type="submit" class="btn btn-primary">Begin Process</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif


    </div>

@endsection
