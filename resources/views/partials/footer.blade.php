<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 footer-item footer-item-left">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a hreflang="{{ $localeCode }}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                        <span class="{{ LaravelLocalization::getCurrentLocale() === $localeCode ? 'selected-locale' : '' }}">{{ strtoupper($localeCode) }}</span>
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
                <a href="#"><span>@lang('navigation.disclaimer')</span></a>
            </div>
        </div>
    </div>
</footer>