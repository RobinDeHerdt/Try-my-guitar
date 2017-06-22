@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="header-image profile-header-image" style="background-image: url({{ Storage::disk('public')->url($user->header_image_uri) }})"></div>
        <div class="container profile-container">
            <div class="profile-image" style="background-image: url({{ Storage::disk('public')->url($user->image_uri) }})"></div>
            @if($user->verified)
            <span title="Verified e-mail address">
                <div class="verified-mark"><i class="fa fa-check fa-2x" aria-hidden="true"></i></div>
            </span>
            @endif
            <h1 class="profile-name">{{ $user->fullName() }}</h1>
            @if($user->description)
                <p class="text-center profile-description">{{ $user->description }}</p>
            @endif
            @if($user->location)
                <span class="profile-location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $user->location }}</span>
            @endif
            <div class="profile-button-container">
                @if(Auth::check())
                    @if ($user->id === Auth::user()->id)
                        <div class="profile-button blue" title="Edit profile">
                            <a href="{{ route('profile.edit') }}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        </div>
                    @else
                        <a href="{{ route('profile.invite', ['id' => $user->id]) }}">
                            <div class="profile-button blue" title="Invite to chat">
                                <i class="fa fa-comments" aria-hidden="true"></i>
                            </div>
                        </a>
                        <a href="{{ route('report.create', ['id' => $user->id]) }}">
                            <div class="profile-button red" title="Report">
                                <i class="fa fa-flag" aria-hidden="true"></i>
                            </div>
                        </a>
                    @endif
                @endif
            </div>
            @if($guitars->isNotEmpty())
                <h2>Collection <span class="counter">{{ $user->guitars->count() }}</span></h2>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="collection">
                            @foreach($guitars as $guitar)
                                <div class="collection-item">
                                    <a href="{{ route('guitar.show', ['guitar' => $guitar->id]) }}">
                                        <div style="background-image: url({{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }}" class="collection-item-image"></div>
                                        <div class="collection-text">
                                            <span>{{ $guitar->name }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <div class="big-cta-button">
                            <a href="{{ route('collection.show', ['id' => $user]) }}">View collection</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($user->experiences->isNotEmpty())
                <h2>Experiences <span class="counter">{{ $user->experiences->count() }}</span></h2>
                <div class="row">
                    @foreach($user->experiences as $experience)
                        <div class="col-md-6">
                            <div class="experience-container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="experience-user">
                                            <a href="{{ route('guitar.show', ['guitar' => $experience->guitar->id]) }}" title="{{ $experience->guitar->name }}">
                                                <div class="experience-guitar-image" style="background-image: url({{ Storage::disk('public')->url($experience->guitar->guitarImages()->first()->image_uri) }})"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="experience-text">
                                            <p>{{ str_limit($experience->experience, 150) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-5">
                        <div class="big-cta-button">
                            <a href="{{ route('profile.experiences', ['id' => $user]) }}">View experiences</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    @include('partials.analytics')
@endsection
