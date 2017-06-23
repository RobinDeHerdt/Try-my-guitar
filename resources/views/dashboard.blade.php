@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content {{ Auth::user() && Auth::user()->hasRole('administrator') ? 'admin-authenticated' : '' }}">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            @if (Session::has('error-message'))
                <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <h3>@lang('dashboard.chat')</h3>
                        <hr>
                        @if($messages->isNotEmpty())
                            @foreach($messages as $message)
                                <div class="message-teaser-container">
                                    <strong>{{ $message->channel->name }}</strong><br>
                                    <span>{{ $message->user->first_name }}: {{ $message->message }}</span><br>
                                    <a href="{{ route('chat.show', [$message->channel_id]) }}">View  chat</a>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <div class="message-teaser-container">
                                <span>@lang('dashboard.no-unseen-messages')</span>
                            </div>
                        @endif
                        <hr>
                        <a href="{{ route('chat.index') }}">@lang('dashboard.my-conversations')</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <h3>@lang('dashboard.collection')</h3>
                        <hr>
                        <a href="{{ route('collection.show', ['user' => $user->id]) }}">@lang('dashboard.my-collection')</a><br>
                        <hr>
                        <a href="{{ route('collection.create') }}">@lang('dashboard.add-to-collection')</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <h3>@lang('dashboard.invites')</h3>
                        <hr>
                        @if($received_invites->isNotEmpty())
                            @foreach($received_invites as $invite)
                                <div class="message-teaser-container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span>You have been invited by <a href="{{ route('profile.show', ['id' => $invite->sender->id]) }}"><strong>{{ $invite->sender->fullName() }}</strong></a> to join <strong>{{ $invite->channel->name }}</strong></span>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <a href="{{ route('invite.response') }}" onclick="event.preventDefault(); document.getElementById('accept-form').submit();"><span><i class="fa fa-check" aria-hidden="true"></i> Accept</span></a>
                                            <form id="accept-form" action="{{ route('invite.response') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="response" value="1">
                                                <input type="hidden" name="invite_id" value="{{ $invite->id }}">
                                            </form>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <a href="{{ route('invite.response') }}" onclick="event.preventDefault(); document.getElementById('decline-form').submit();"><span><i class="fa fa-times" aria-hidden="true"></i> Decline</span></a>
                                            <form id="decline-form" action="{{ route('invite.response') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="response" value="0">
                                                <input type="hidden" name="invite_id" value="{{ $invite->id }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="message-teaser-container">
                                <span>@lang('dashboard.no-invites')</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <h3>@lang('dashboard.pending-invites')</h3>
                        <hr>
                        @if($sent_invites->isNotEmpty())
                            @foreach($sent_invites as $invite)
                                <div class="message-teaser-container">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <span>You have invited <strong>{{ $invite->receiver->first_name }}</strong> to join <strong>{{ $invite->channel->name }}</strong></span>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <a href="{{ route('invite.response') }}" onclick="event.preventDefault(); document.getElementById('cancel-form').submit();"><span><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></a>
                                            <form id="cancel-form" action="{{ route('invite.response') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="response" value="0">
                                                <input type="hidden" name="invite_id" value="{{ $invite->id }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="message-teaser-container">
                                <span>@lang('dashboard.no-pending-invites')</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="dashboard-content">
                        <h3>@lang('dashboard.personal-information')</h3>
                        <hr>
                        <a href="{{ route('profile.edit') }}">@lang('dashboard.personal-information')</a><br>
                        <hr>
                        <a href="{{ route('profile.show', ['id' => $user->id]) }}">@lang('dashboard.my-profile')</a>
                        @if(!$user->verified)
                            <hr>@lang('dashboard.profile-not-verified')
                            <span>@lang('dashboard.profile-not-verified') <a href="{{ route('verify.resend') }}">@lang('dashboard.click-to-send')</a> to send the verification mail again.</span>
                        @endif
                        <hr>
                        @if(!$user->location)
                            <span>@lang('dashboard.profile-not-complete') <a href="{{ route('profile.edit') }}">@lang('dashboard.click-to-complete')</a></span>
                        @endif
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
