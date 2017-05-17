<div class="header-search">
    <form class="form-inline" id="search-form" method="GET" action="{{ route('search') }}">
        <input type="text" class="form-control search-input" name="term" id="search-input" placeholder="Search for a user or guitar" value="{{app('request')->input('term') }}">
        <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit" onclick="event.preventDefault(); document.getElementById('search-form').submit();">Search</a>
        <a href="{{ route('search') }}" class="btn btn-default search-submit" id="search-submit-mobile" onclick="event.preventDefault(); document.getElementById('search-form').submit();"><i class="fa fa-search" aria-hidden="true"></i></a>
    </form>
</div>