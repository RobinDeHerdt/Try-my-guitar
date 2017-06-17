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
            </span>
            @endif
            <h1 class="profile-name">{{ $user->fullName() }}</h1>
            @if($user->description)
                <p class="text-center profile-description">{{ $user->description }}</p>
            @endif
            @if($user->location)
                <span class="profile-location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $user->location }}</span>
            @endif
            @if(Auth::check())
                @if ($user->id === Auth::user()->id)
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <div class="big-cta-button">
                                <a href="{{ route('profile.edit') }}">Edit profile</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <div class="big-cta-button">
                                <a href="{{ route('profile.invite', ['id' => $user->id]) }}">Invite to chat</a>
                            </div>
                        </div>
                        <div class="col-md-2 col-md-offset-3">
                            <div class="report-button">
                                <a href="{{ route('report.create', ['id' => $user->id]) }}">Report profile</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            @if($user->ownedGuitars->isNotEmpty())
                <h2 class="padding-top">Collection <span class="counter">{{ $user->ownedGuitars->count() }}</span></h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="collection">
                            @foreach($user->ownedGuitars as $guitar)
                                <div class="collection-item">
                                    <div style="background-image: url({{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }}" class="collection-item-image"></div>
                                    <a href="{{ route('guitar.show', ['guitar' => $guitar->id]) }}" class="collection-item-text">{{ $guitar->name }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="big-cta-button">
                            <a href="{{ route('collection.show', ['id' => $user]) }}">View full collection</a>
                        </div>
                    </div>
                </div>
            @endif
            @if($user->experiencedGuitars->isNotEmpty())
                <h2 class="padding-top">Experienced guitars <span class="counter">{{ $user->experiencedGuitars->count() }}</span></h2>
                <div class="row">
                    @foreach($user->experiencedGuitars as $guitar)
                        <div class="col-md-6">
                            <div class="experience-container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="experience-user">
                                            <a href="{{ route('profile.show', ['guitar' => $guitar->id]) }}" title="{{ $guitar->name }}">
                                                <div class="experience-guitar-image" style="background-image: url({{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }})"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="experience-text">
                                            <blockquote>
                                                <br>
                                                <p>{{ str_limit($guitar->pivot->experience, 150) }}</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="big-cta-button">
                            <a href="{{ route('collection.show', ['id' => $user]) }}">View all experiences</a>
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
