<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="https://ttysi.uz/assets/public/images/logo_black.svg"/>
    <title>TTYSI Requests</title>

    <!-- BOOTSTRAP STYLES-->
    @include('components.css')
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%!important;
            font-family: Arial;
        }

        .content {
            min-height: calc(100vh - 50px); /* Footerning balandligini hisobga oling */
            display: flex;
            flex-direction: column;
        }

        .footer {
            height: 50px; /* Footerning balandligi */
            background-color: #000;
            color: #fff;
            text-align: center;
            line-height: 50px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input/build/css/intlTelInput.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css">
    @yield('style')
</head>
<body>
<div style="height: fit-content!important;">
<div id="wrapper">
    @include('components.navbar')

    <!-- /. NAV TOP  -->
    @include('components.saidbar')
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div>
                <div class="col-md-12 content">
                    <h1 class="page-head-line">@yield('h1')Dashboard</h1>
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->

<div id="footer-sec" class="footer">
    &copy; 2024 Raqamli ta`lim texnalogiyalari bo'limi!!!
</div>
@include('components.script')

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/intlTelInput.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/locales/ru.js"></script>
    @yield('script')
</div>
</body>
</html>
