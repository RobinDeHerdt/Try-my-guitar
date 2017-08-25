@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="header-image" style="background-image: url('/images/about-bg.jpg');"></div>
        <div class="container">
            <div class="row">
                @include('partials.messages')
            </div>
            <h2 id="meet">@lang('about.meet-people')</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content dashboard-border-left">
                        <strong>@lang('about.about-1-strong')</strong><br>
                        <span>@lang('about.about-1-text')</span>
                    </div>
                </div>
            </div>
            <h2 id="discover">@lang('about.discover')</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content dashboard-border-left">
                        <strong>@lang('about.about-2-strong')</strong><br>
                        <span>@lang('about.about-2-text')</span>
                    </div>
                </div>
            </div>
            <h2 id="profilelevel">Profile level</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content dashboard-border-left">
                        <p>@lang('about.about-3-text')</p>
                        <ul>
                            <li>@lang('about.about-3-point-1') (<strong>+100 exp</strong>)</li>
                            <li>@lang('about.about-3-point-2') (<strong>+100 exp</strong>)</li>
                            <li>@lang('about.about-3-point-3') (<strong>@lang('about.about-3-point-3-text')</strong>)</li>
                            <li>@lang('about.about-3-point-4') (<strong>@lang('about.about-3-point-4-text')</strong>)</li>
                            <li>@lang('about.about-3-point-5') (<strong>+75 exp</strong>)</li>
                        </ul>
                        <strong>@lang('about.about-3-strong')</strong>
                    </div>
                </div>
            </div>
            <h2 id="contact">Contact</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content dashboard-border-left">
                        <form action="{{ route('contact') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">@lang('input.email') *</label>
                                        <input type="email" class="form-control" name="email" placeholder="@lang('input.your-email')" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">@lang('input.subject')</label>
                                        <input type="text" class="form-control" name="subject" placeholder="@lang('input.subject')">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="message">@lang('input.your-message') *</label>
                                        <textarea name="message" cols="30" rows="5" class="form-control" placeholder="@lang('input.your-message')" required></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-8">
                                              <input type="submit" class="btn btn-primary red form-control" value="@lang('input.send')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    @include('partials.analytics')
@endsection
