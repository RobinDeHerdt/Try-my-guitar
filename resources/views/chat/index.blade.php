@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success alert-margin">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info alert-margin">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row heading">
                <div class="col-md-12">
                    <h1>@lang('dashboard.chat')</h1>
                    <a href="{{ route('dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>Dashboard</a>
                    <a href="{{ route('dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if ($channels->isNotEmpty())
                        <div class="chats-overview">
                            @foreach($channels as $channel)
                                <div class="channel">
                                    <div class="channel-name">
                                        <a href="{{ route('chat.show', ['id' => $channel->id]) }}">{{ $channel->name }}</a>
                                    </div>
                                    <div class="channel-participants">
                                        @foreach($channel->users as $user)
                                            <div class="profile-teaser {{ $user->pivot->accepted ? '' : 'invited' }}">
                                                <a href="{{ route('profile.show', ['id' => $user->id]) }}" title="{{ $user->fullName() }}{{ $user->pivot->accepted ? '' : ' - Invite pending' }}">
                                                    <div class="profile-picture" style="background-image: url('{{ Storage::disk('public')->url($user->image_uri) }}')"></div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-results">
                            <h4>@lang('content.no-open-conversations')</h4>
                        </div>
                    @endif
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
