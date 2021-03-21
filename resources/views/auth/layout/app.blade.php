<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('auth.layout.css.css')

</head>
<body class="nk-body npc-crypto ui-clean pg-auth">
    <div class="nk-app-root">
        <div class="nk-split nk-split-page nk-split-md" style="justify-content: center">

            <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container">
                <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                    <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                </div>
                <div class="nk-block nk-block-middle nk-auth-body">
                    <div class="brand-logo pb-5">
                        <a href="{{ route('dashboard') }}" class="logo-link">
                            <img class="logo-light logo-img logo-img-lg" src="{{ url('img/user.png') }}" >
                            <img class="logo-dark logo-img logo-img-lg" src="{{ url('img/user.png') }}" >
                        </a>
                    </div>
                    @yield('content')
                </div><!-- .nk-block -->
                <div class="nk-block nk-auth-footer">
                    <div class="mt-3">
                        <p>&copy; {{ date("Y") }} {{ config('app.name') }}. All Rights Reserved.</p>
                    </div>
                </div><!-- .nk-block -->
            </div><!-- .nk-split-content -->


            {{--@include('auth.layout.aside')--}}
        </div>
    </div>
    @include('auth.layout.js.js')
</body>
</html>
