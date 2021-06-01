
@if (session('status'))
    <br>
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    <br>
@endif

@if(session('message'))
    <br>
    <div class="alert alert-info p-2" >
        {!! session('message') !!}
        <a href="#" class="close pull-right" data-dismiss="alert" aria-label="close" >&times;</a>
    </div>
    <br>
@endif

@if(!empty(session('err')))
    <br>
    <div >
        <ul class="list-unstyled">
            @foreach(session('err') as $key=>$error)
                <li class="alert alert-danger">
                    <i class="fa fa-warning"></i> {{ $error }}
                    <a href="#" class="close pull-right" data-dismiss="alert" aria-label="close">&times;</a>
                </li>

            @endforeach
        </ul>
    </div>
    <br>
    <?php session()->forget('err') ?>
@endif

@if(count($errors) > 0)
    <br>
    <div >
        <ul class="list-unstyled">
            @foreach($errors->all() as $error)
                <li class="alert alert-danger">
                    <i class="fa fa-warning"></i> {{ $error }}
                    <a href="#" class="close pull-right" data-dismiss="alert" aria-label="close">&times;</a>
                </li>

            @endforeach
        </ul>
    </div>
    <br>
@endif