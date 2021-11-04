
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
<?php $err = session('err'); ?>
@if(!empty($err))

    <div >
        <ul class="list-unstyled">
            <li class="alert alert-danger">
                <i class="fa fa-warning"></i> Error:  {{ var_dump($err) }}
                <a href="#" class="close pull-right" data-dismiss="alert" aria-label="close">&times;</a>
            </li>
        </ul>
    </div>
    <br>
    <?php session()->forget('err') ?>
@endif

<?php $err1 = session('err1'); ?>
@if(!empty($err1))

    <div >
        <ul class="list-unstyled">
            <li class="alert alert-danger">
                <i class="fa fa-warning"></i> Error:  {{ var_dump($err1) }}
                <a href="#" class="close pull-right" data-dismiss="alert" aria-label="close">&times;</a>
            </li>
        </ul>
    </div>
    <br>
    <?php session()->forget('err1') ?>
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