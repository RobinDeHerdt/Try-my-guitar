<nav class="navbar-default">
    @if (Auth::user() && Auth::user()->hasRole('administrator'))
        <div class="custom-navbar-top">
            <div class="container">
                <div class="top-menu-collapse">
                    <a href="{{ route('admin.dashboard') }}">Control panel</a>
                    <a href="{{ route('articles.index') }}">Articles</a>
                    <a href="{{ route('admin.users.index') }}">Users</a>
                    <a href="{{ route('admin.guitars.index') }}">Guitars</a>
                    <a href="{{ route('admin.guitarimages.index') }}">Images</a>
                    <a href="{{ route('admin.reports.index') }}">Reports</a>
                    <a href="{{ route('admin.messages.index') }}">Contact messages</a>
                    <a href="{{ route('admin.cta.index') }}">Call to action</a>
                    <a href="#" onclick="event.preventDefault();" id="top-menu-close">
                        <div class="center-content">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
                <div id="top-menu-open">
                    <i class="fa fa-list" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    @endif
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
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="{{ route('home') }}">@lang('navigation.home')</a></li>
                    <li><a href="{{ route('explore') }}">@lang('navigation.explore')</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li class="nav-highlighted"><a href="{{ route('register') }}">@lang('navigation.register')</a></li>
                        <li><a href="{{ route('login') }}">@lang('navigation.login')</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}">@lang('navigation.dashboard')</a></li>
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
