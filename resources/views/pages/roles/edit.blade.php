@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Edit Role </h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('role.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span><span class="d-none d-sm-inline-block">Back</span> </span></a></li>
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
                        <h5 class="card-title">Edit Role</h5>
                    </div>
                    <form action="{{ route('role.update', $role->uuid) }}" method="post">
                        @csrf
                        {{ method_field('put') }}
                        <p class="text-left">Enter a details to complete.</p>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="first_name">Role title</label>
                                    <input id="first_name" class="form-control" name="title" value="{{ $role->title }}" required autofocus autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-control-sm custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkall" name="checkall">
                                    <label class="custom-control-label" for="checkall">Check All</label>
                                </div>
                                <hr>
                            </div>
                            @foreach($roles as $item)
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input check_boxes" id="ss{{ $item }}" name="{{ $item }}" {{ $role->$item?'checked':'' }}>
                                            <label class="custom-control-label" for="ss{{ $item }}">{{ str_replace('_',' ', $item)  }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Update Role</label>
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
@section('custom_js')
    <script>
        $('#checkall').change(function() {
            if(this.checked) {
                $('.check_boxes').prop("checked", true);
            }else{
                $('.check_boxes').prop("checked", false);
            }
            $('#textbox1').val(this.checked);
        });
    </script>
@endsection