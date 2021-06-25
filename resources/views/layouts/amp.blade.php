<!doctype html>
<html amp lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    @include('includes.meta-tags')
    @include('includes.favicon')
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap">
    @yield('amp')


    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
    <script async custom-element="amp-audio" src="https://cdn.ampproject.org/v0/amp-audio-0.1.js"></script>
    <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
    <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
    <script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>
    <script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/amp-vimeo-0.1.js"></script>


    @include('includes.amp.css')
</head>
<body class="bg-lighter">
@include('structure.header')
@yield('content')
@include('structure.footer')
@yield('schema')
</body>
</html>
