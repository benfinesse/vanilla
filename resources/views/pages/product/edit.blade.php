@extends('layouts.app')

@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title fw-normal">Edit Product</h4>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li><a href="{{ route('product.index') }}" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-arrow-left"></em><span><span class="d-none d-sm-inline-block">Back</span> </span></a></li>
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
                        <h5 class="card-title">Edit {{ $product->name }}</h5>
                    </div>
                    <form action="{{ route('product.update', $product->uuid) }}" method="post">
                        @csrf
                        {{ method_field('put') }}
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Product Name</label>
                                    <input id="process" class="form-control" name="name" value="{{ $product->name }}" required autofocus autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Product Price</label>
                                    <input id="process" class="form-control" name="price" value="{{ $product->price }}" required autocomplete="off" onkeypress="return numbersOnly(event)" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Groups</label>
                                    <select name="group_id" id="" class="form-control">
                                        @foreach($groups as $group)
                                            <option value="{{ $group->uuid }}" {{ $product->group_id===$group->uuid?'selected':'' }}>{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Measure</label>
                                    <select name="measure" id="" class="form-control">
                                        @foreach($measures as $measure)
                                            <option value="{{ $measure->name }}" {{ $product->measure===$measure->name?'selected':'' }}>{{ $measure->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="process">Update Product</label>
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
    </script>
@endsection
