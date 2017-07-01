<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A platform that brings guitar players - and their guitars - together.">
    <title>Try my guitar</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    @yield('stylesheets')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://use.fontawesome.com/24f215a663.js" async ></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        @include('partials.notifications')
        @yield('navigation')
        <div class="{{ Auth::user() && Auth::user()->hasRole('administrator') ? 'admin-authenticated' : '' }}">
            @yield('content')
        </div>
        @yield('footer')
        @if(Auth::check())
            <chat-notifications :notifications="notifications"></chat-notifications>
        @endif
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
