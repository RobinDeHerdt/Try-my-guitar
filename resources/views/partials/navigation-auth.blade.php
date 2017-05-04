<nav class="navbar-default no-bg-color">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="container">
        <div class="row">
            <a href="{{ route('home') }}">
                <img src="/images/logo-transparent.png" alt="site logo" class="site-logo">
            </a>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('home') }}">@lang('navigation.home')</a></li>
                <li><a href="#">@lang('navigation.about')</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Route::currentRouteName() !== 'register')
                    <li class="nav-highlighted"><a href="{{ route('register') }}">@lang('navigation.register')</a></li>
                @else
                    <li class="nav-highlighted"><a href="{{ route('login') }}">@lang('navigation.login')</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>