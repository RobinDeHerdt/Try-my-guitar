@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content" id="chat-page">
        <input type="hidden" value="{{ $channel->id }}" id="channel-id">
        <div class="container">
            <chat-name :channelname="channelname"></chat-name>
            <div class="conversation-participants">
                <chat-participants :channel="channel"></chat-participants>
            </div>
            <div class="row heading">
                <div class="col-md-12">
                    <a href="{{ route('chat.leave', ['channel' => $channel->id]) }}" class="icon-text icon-full" onclick="event.preventDefault(); document.getElementById('leave-form').submit();"><span class="glyphicon glyphicon-log-out"></span>@lang('content.leave-conversation')</a>
                    <a href="{{ route('chat.leave', ['channel' => $channel->id]) }}" class="icon-text icon-responsive" onclick="event.preventDefault(); document.getElementById('leave-form').submit();"><span class="glyphicon glyphicon-log-out"></span></a>
                    <a href="{{ route('chat.index') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-th-list"></span>@lang('content.back-to-conversations')</a>
                    <a href="{{ route('chat.index') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-th-list"></span></a>
                    <a href="{{ route('chat.update', ['channel' => $channel->id]) }}" class="icon-text icon-full" onclick="event.preventDefault(); showEditForm();"><span class="glyphicon glyphicon-pencil"></span>@lang('content.edit-conversation-name')</a>
                    <a href="{{ route('chat.update', ['channel' => $channel->id]) }}" class="icon-text icon-responsive" onclick="event.preventDefault(); showEditForm();"><span class="glyphicon glyphicon-pencil"></span></a>
                    <div class="row edit-channel-form">
                        <div id="edit-channel-form" style="display: none;">
                            <input type="hidden" id="channel_id" value="{{ $channel->id }}">
                            <div class="col-md-10">
                                <input type="text" id="channel_name" class="form-control" value="{{ $channel->name }}">
                            </div>
                            <div class="col-md-2">
                                <button onclick="changeChatName();" class="btn btn-primary">@lang('input.save')</button>
                                <div class="close-edit-form" onclick="hideEditForm();">
                                    <span>@lang('input.close') </span> <span class="glyphicon glyphicon-remove"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="leave-form" action="{{ route('chat.leave', ['channel' => $channel->id]) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="chat-container">
                        <chat-messages :messages="messages"></chat-messages>
                    </div>
                    <div class="chat-form">
                        <chat-form v-on:messagesent="addMessage" :user="{{ Auth::user() }}"></chat-form>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function changeChatName() {
            var channel_id      = $('#channel_id').val();
            var channel_name    = $('#channel_name').val();

            $.post("/chat/channel/"+channel_id+"/update", {channel_name: channel_name}, function( data ) {
                $("#channel-name").text(channel_name);
                hideEditForm();
            });
        }

        function showEditForm() {
            $("#edit-channel-form").show();
        }

        function hideEditForm() {
            $("#edit-channel-form").hide();
        }
    </script>
    @include('partials.analytics')
@endsection
