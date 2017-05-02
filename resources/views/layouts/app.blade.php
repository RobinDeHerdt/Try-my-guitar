<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Try my guitar</title>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        @if (Auth::user() && Auth::user()->isAdmin())
        <nav class="navbar-default">
            <ul class="custom-navbar-top">
                <li class="custom-navbar-title"><a href="#">Administrator dashboard</a></li>
                <li><a href="#">Admin item</a></li>
                <li><a href="#">Admin item</a></li>
                <li><a href="#">Admin item</a></li>
                <li><a href="#">Admin item</a></li>
                <li><a href="#">Admin item</a></li>
            </ul>
        </nav>
        @endif
        <nav class="navbar-default">
            <div class="container">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('home') }}">@lang('navigation.home')</a></li>
                    <li><a href="#">@lang('navigation.about')</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        {{-- Not authenticated --}}
                        <li class="nav-highlighted"><a href="{{ route('register') }}">@lang('navigation.register')</a></li>
                        <li><a href="{{ route('login') }}">@lang('navigation.login')</a></li>
                    @else
                        {{-- Authenticated --}}
                        <li><a href="#">@lang('navigation.profile')</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('navigation.logout')</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 footer-item footer-item-left">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                <span class="{{ LaravelLocalization::getCurrentLocale() === $localeCode ? 'selected-locale locale' : 'locale' }}">{{ strtoupper($localeCode) }}</span>
                                @if(!$loop->last)
                                    <span> | </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                    <div class="col-md-4 footer-item footer-item-center">
                        <a href="#"><i class="fa fa-youtube-play fa-2x" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-twitter fa-2x "aria-hidden="true"></i></a>
                    </div>
                    <div class="col-md-4 footer-item footer-item-right">
                        <a href="#"><span>Disclaimer</span></a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
