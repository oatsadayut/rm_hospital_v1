<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RM <?php echo env("APP_TITLE"); ?></title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


        <!-- Styles -->
        <style>
            .bg-foot-b{
                background-color: #000836;
            }
            .shadow-ic{
                -webkit-box-shadow: 4px 13px 46px 0px rgba(235,255,249,1);
                -moz-box-shadow: 4px 13px 46px 0px rgba(235,255,249,1);
                box-shadow: 4px 13px 46px 0px rgb(213, 252, 240);
            }
            .card {
                border: 0px solid rgba(0, 0, 0, 0) !important;
            }
            html, body {
                font-family: 'Sarabun', sans-serif;
                background-color: #fff;
                color: #636b6f;
                font-weight: 200;
                height: 100vh;
                margin:0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
</head>
<body>
    @include('sweetalert::alert')
    <div id="app" class="flex-center position-ref full-height">
        @yield('content')
    </div>
</body>
</html>
