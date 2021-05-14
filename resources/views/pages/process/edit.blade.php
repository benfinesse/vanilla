@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Edit Process</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('process.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span><span class="d-none d-sm-inline-block">Back</span> </span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="nk-content-wrap">
        <div class="nk-block">
            @include('layouts.notice')
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Process {{ $process->name }}</h5>
                    </div>
                    <form action="{{ route('process.update', $process->uuid) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <p class="text-left">Update a name to complete.</p>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Enter Process Name</label>
                                    <input id="process" class="form-control" name="name" value="{{ $process->name }}" required autofocus autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Update Process</label>
                                    <div class="form-control-wrap ">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection
