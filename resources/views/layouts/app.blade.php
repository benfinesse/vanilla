<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('layouts.script.css')
</head>
<body class="nk-body npc-subscription has-aside ui-clean ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap ">

                @include('layouts.content.header')

                <div class="nk-content ">
                    <div class="container wide-xl">
                        <div class="nk-content-inner">
                            @include('layouts.content.sidebar')
                            <div class="nk-content-body">
                                @yield('content')
                                @include('layouts.content.footer')
                            </div>


                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>



    @include('layouts.script.js')
</body>
</html>
