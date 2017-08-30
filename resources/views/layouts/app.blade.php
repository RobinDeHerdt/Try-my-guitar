<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A platform that brings guitar players - and their guitars - together.">
    <title>Try my guitar</title>
    <link rel="icon" href="/favicon.ico" />
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
        @if (!Cookie::get('cookie-popup'))
            <div class="cookie-popup" id="cookie-window">
                <span>@lang('content.cookie-text')</span>
                <a href="#" onclick="closeCookieWindow()">@lang('content.cookie-confirm')</a>
            </div>
        @endif
        @if(Auth::check())
            <chat-notifications :notifications="notifications"></chat-notifications>
        @endif
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    @if (!Cookie::get('cookie-popup'))
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function closeCookieWindow() {
                event.preventDefault();
                $.post("/cookie").done(function() {
                    $("#cookie-window").hide();
                });
            }
        </script>
    @endif
</body>
</html>
