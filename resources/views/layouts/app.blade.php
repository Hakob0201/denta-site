{{-- 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    @include('includes.meta-tags')
    @include('includes.favicon')
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <link rel="stylesheet" href="/assets/css/app.css" media="all">
    <link href="/assets/css/notosansarmenian.css" rel="stylesheet" media="none" onload="this.media='all'">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet"
          media="none" onload="this.media='all'">
    @yield('amp')
    <noscript>
        <link rel="stylesheet" href="/assets/css/notosansarmenian.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap">
    </noscript>
    <script src="https://progressier.com/client/script.js?id=SREetz4HaPJ36LeiqMCu"></script>
</head>
<body class="bg-lighter">
@include('structure.header')
@yield('content')
@include('structure.footer')
<script src="/assets/js/app.js"></script>
@yield('schema')
@yield('js')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-8Q821N9RRX"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'G-8Q821N9RRX');
</script>
</body>
</html> --}}



<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Medcity - Medical" />
    {{-- @include('includes.meta-tags')
    @include('includes.favicon') --}}
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <link href="{{ asset('assets/images/favicon/favicon.png') }}" rel="icon" />
    <title>Medcity - Medical Healthcare HTML5 Template</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&amp;family=Roboto:wght@400;700&amp;display=swap" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/use.fontawesome.com/releases/v5.15.3/css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/libraries.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>

<body>
    <div class="wrapper">
        <div class="preloader">
            <div class="loading"><span></span><span></span><span></span><span></span></div>
        </div>
        <!-- /.preloader -->

        @include('structure.header')

        @yield('content')
        
        @include('structure.footer')

        
        <button id="scrollTopBtn"><i class="fas fa-long-arrow-alt-up"></i></button>
    </div>
    <!-- /.wrapper -->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>