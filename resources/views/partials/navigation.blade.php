<nav class="navbar-default">
    <img src="" alt="">
    <!-- Collapsed Hamburger -->
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="container">
        <div class="row">
            <a href="{{ route('home') }}">
                <div class="site-logo" style="background-image: url('/images/logo-transparent.png');"></div>
            </a>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
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
                        <li><a href="{{ route('profile') }}">@lang('navigation.profile')</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('navigation.logout')</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>