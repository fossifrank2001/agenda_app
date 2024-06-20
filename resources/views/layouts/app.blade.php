<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Agenda .:. @yield('title', ' Login')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="{{ asset('../assets/images/logos/favicon.png') }}" />

        <!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
        @vite('resources/css/app.css')
    </head>

    <body>
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
             data-sidebar-position="fixed" data-header-position="fixed">
            <div
                class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <div class="row justify-content-center w-100">
                        @yield('app_content')
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset("assets/libs/jquery/dist/jquery.min.js")}}"></script>
        <script src="{{asset("assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>

        @vite('resources/js/app.js')
    </body>

</html>
