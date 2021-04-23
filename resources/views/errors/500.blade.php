<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Softnio">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="error">
        <!-- Fav Icon  -->
        <link rel="shortcut icon" href="{{ url('app/images/favicon.png') }}">
        <!-- Page Title  -->
        <title>Error 500 | {{ config('app.name') }}</title>
        <!-- StyleSheets  -->
        <link rel="stylesheet" href="{{ asset('app/assets/css/dashlite.css?ver=1.4.0') }}">
        <link id="skin-default" rel="stylesheet" href="{{ asset('app/assets/css/theme.css?ver=1.4.0') }}">
    </head>
    <body class="nk-body bg-white npc-general pg-error">
        <div class="nk-app-root">
            <div class="nk-main ">
                <div class="nk-wrap justify-center">
                    <div class="nk-content ">
                        <div class="nk-block nk-block-middle wide-xs mx-auto">
                            <div class="nk-block-content nk-error-ld text-center">
                                <h1 class="nk-error-head">500</h1>
                                <h3 class="nk-error-title">Oops! Why you’re here?</h3>
                                <p class="nk-error-text">We are very sorry for the inconvenience. Seems something went wrong in the engine room.</p>
                                <p class="nk-error-text"><b>Fear Not!</b> Some Super engineer got an email already and is fixing it.
                                    <br>
                                    <br>
                                    Click the button below to continue.
                                </p>

                                <a href="{{ route('home') }}" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                            </div>
                        </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>