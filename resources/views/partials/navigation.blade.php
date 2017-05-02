<nav class="navbar-default">
    <div class="container">
        <ul class="nav navbar-nav">
            <li><a href="{{ route('home') }}">@lang('navigation.home')</a></li>
            <li><a href="#">@lang('navigation.about')</a></li>
        </ul>
        <a href="/{{LaravelLocalization::getCurrentLocale()}}">
            <div class="site-logo" style="background-image: url('/images/logo.jpg');"></div>
        </a>
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