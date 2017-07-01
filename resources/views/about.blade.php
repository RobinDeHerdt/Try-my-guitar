@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content {{ Auth::user() && Auth::user()->hasRole('administrator') ? 'admin-authenticated' : '' }}">
        <div class="header-image" style="background-image: url('/images/about-bg.jpg');"></div>
        <div class="container">
            <div class="row">
                @if (Session::has('success-message'))
                    <div class="alert alert-success alert-margin" id="alert">{{ Session::get('success-message') }}</div>
                @endif
                @if (Session::has('info-message'))
                    <div class="alert alert-info alert-margin" id="alert">{{ Session::get('info-message') }}</div>
                @endif
                @if (Session::has('error-message'))
                    <div class="alert alert-danger alert-margin" id="alert">{{ Session::get('error-message') }}</div>
                @endif
            </div>
            <h2 id="meet">Meet people</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content">
                        <strong>Do you have a guitar in mind that you have always wanted to play, but it isn't available in the stores anymore?</strong><br>
                        <span>Look it up here and find owners near you! Invite them to chat and arrange a meet-up in a local practice room. Don't forget to share your experience afterwards!</span>
                    </div>
                </div>
            </div>
            <h2 id="discover">Discover</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content">
                        <strong>Not sure which guitar you're interested in?</strong><br>
                        <span>No problem! Check out the 'explore' section on the site and discover guitars that suit your needs.</span>
                        <span>If you just want to hang out with people near you, check out the map!</span>
                    </div>
                </div>
            </div>
            <h2 id="profilelevel">Profile level</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content">
                        <p>You can increase your profile level by earning experience points.
                            Experience points are awarded for contributing to the site: </p>
                        <ul>
                            <li>Verify your e-mail (<strong>+100 exp</strong>)</li>
                            <li>Complete your profile (<strong>+100 exp</strong>)</li>
                            <li>Add a guitar to the website (<strong>+100 exp and +25 exp per image</strong>)</li>
                            <li>Add images to a guitar (<strong>+25 exp per image</strong>)</li>
                            <li>Share a guitar experience (<strong>+75 exp</strong>)</li>
                        </ul>
                        <strong>Warning! Contributions will be monitored by the site administrators.
                            You will receive an exp penalty or permanent ban in case spam is uploaded.</strong>
                    </div>
                </div>
            </div>
            <h2 id="contact">Contact</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-content">
                        <form action="{{ route('contact') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">@lang('input.email') *</label>
                                        <input type="email" class="form-control" name="email" placeholder="Your e-mail address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">@lang('input.subject')</label>
                                        <input type="text" class="form-control" name="subject" placeholder="@lang('input.subject')">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="message">@lang('input.your-message') *</label>
                                        <textarea name="message" cols="30" rows="10" class="form-control" placeholder="Your message" required></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-8">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary form-control" value="Send">
                                            </div>
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
    <script>
        if(location.hash.slice(1)) {
            $('html,body').animate({
                scrollTop: $("#" + location.hash.slice(1)).offset().top - 70
            }, 1000 );
        }
    </script>
    @include('partials.analytics')
@endsection