<nav class="navbar-default no-bg-color">
    <div class="container">
        <ul class="nav navbar-nav">
            <li><a href="{{ route('home') }}">@lang('navigation.home')</a></li>
            <li><a href="#">@lang('navigation.about')</a></li>
        </ul>
        <a href="/{{ LaravelLocalization::getCurrentLocale() }}">
            <div class="site-logo" style="background-image: url('/images/logo.jpg');"></div>
        </a>
        <ul class="nav navbar-nav navbar-right">
            @if (Route::currentRouteName() !== 'register')
                <li class="nav-highlighted"><a href="{{ route('register') }}">@lang('navigation.register')</a></li>
            @else
                <li class="nav-highlighted"><a href="{{ route('login') }}">@lang('navigation.login')</a></li>
            @endif
        </ul>
    </div>
</nav>