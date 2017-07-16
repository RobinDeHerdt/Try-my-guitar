@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @include('partials.messages')
            <div class="row heading">
                <div class="col-md-12">
                    <h1>@lang('content.s-experiences', ['name' => $user->first_name])</h1>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-user"></span>@lang('content.view-name-profile', ['name' => $user->first_name])</a>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-user"></span></a>
                </div>
            </div>
            @if($experiences->isNotEmpty())
                <div class="row">
                    @foreach($experiences as $experience)
                        <div class="col-md-6" id="experience-{{ $experience->id }}">
                            <div class="search-result">
                                <a href="{{ route('guitar.show', ['id' => $experience->guitar->id]) }}">
                                    @if($experience->guitar->guitarImages->isNotEmpty())
                                        <img src="{{ Storage::disk('public')->url($experience->guitar->guitarImages()->first()->image_uri) }}" class="search-result-image">
                                    @else
                                        <div class="search-result-image no-image">@lang('content.no-image-available')</div>
                                    @endif
                                </a>
                                <h3>{{ $experience->guitar->name }}</h3>
                                <hr>
                                <form action="{{ route('experience.update', ['id' => $experience->id ])}}"  method="POST" id="experience-form-{{ $experience->id }}" style="display: none">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <i class="fa fa-times" onclick="closeEditForm({{ $experience->id }})"></i>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="experience" class="form-control" id="input-experience" rows="5">{{ $experience->experience }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Save">
                                    </div>
                                </form>
                                <div id="experience-text-{{ $experience->id }}">
                                    <p>{{ $experience->experience }}</p>
                                </div>
                                @if(Auth::check() && Auth::user()->id === $user->id)
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-4 col-md-offset-2">
                                                <a href="{{ route('experience.update', ['id' => $experience->id ]) }}" onclick="event.preventDefault(); showEditForm({{ $experience->id }});" title="Update your experience">
                                                    <span class="glyphicon glyphicon-edit"></span> @lang('input.edit')
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="{{ route('experience.destroy', ['id' => $experience->id ]) }}" onclick="deleteItem({{ $experience->id }}, 'delete-experience');" title="Remove your experience">
                                                    <span class="glyphicon glyphicon-trash"></span> @lang('input.delete')
                                                </a>
                                                <form action="{{ route('experience.destroy', ['id' => $experience->id ])}}"  method="POST" id="delete-experience-{{ $experience->id }}" style="display: none">
                                                    {{ csrf_field() }}
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="@lang('content.mark-as-helpful')" onclick="event.preventDefault(); vote('{{ $experience->id }}', 1);">
                                            <span>
                                                 <i class="fa {{ Auth::check() && $experience->upVotes->contains('user_id', Auth::user()->id) ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}" aria-hidden="true" id="upvote-{{ $experience->id }}"></i>
                                                  <span id="upvote-count-{{ $experience->id }}">{{ $experience->upVotes->count() }}</span>
                                            </span>
                                        </a>
                                        <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="@lang('content.mark-as--not-helpful')" onclick="event.preventDefault(); vote('{{ $experience->id }}', 0);">
                                             <span>
                                                 <i class="fa {{ Auth::check() && $experience->downVotes->contains('user_id', Auth::user()->id) ? 'fa-thumbs-down' : 'fa-thumbs-o-down' }}" aria-hidden="true" id="downvote-{{ $experience->id }}"></i>
                                                <span id="downvote-count-{{ $experience->id }}">{{ $experience->downVotes->count() }}</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h4>@lang('content.nothing-to-see-here')</h4>
            @endif
        </div>
    </div>
    @include('partials.dialog')
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

        function showEditForm(id) {
            $('#experience-form-' + id).show();
            $('#experience-text-' + id).hide();
        }

        function closeEditForm(id) {
            $('#experience-form-' + id).hide();
            $('#experience-text-' + id).show();
        }

        function vote(id, value) {
            var class_list;

            var selected;
            var opposite;

            var selected_vote_count;
            var opposite_vote_count;

            switch(value) {
                case 0:
                    selected = "downvote";
                    opposite = "upvote";
                    break;

                case 1:
                    selected = "upvote";
                    opposite = "downvote";
                    break;

                default:
                    return;
            }

            var selected_count_selector = "#" + selected + "-count-" + id;
            var selected_icon_selector  = "#" + selected + "-" + id;
            var opposite_count_selector = "#" + opposite + "-count-" + id;
            var opposite_icon_selector  = "#" + opposite + "-" + id;

            selected_vote_count = $(selected_count_selector).text();
            opposite_vote_count = $(opposite_count_selector).text();

            class_list  = $(selected_icon_selector).attr("class").split(' ');

            for(var i = 0; i < class_list.length; i++) {
                switch(class_list[i]) {
                    case "fa-thumbs-o-up":
                        if($(opposite_icon_selector).hasClass("fa-thumbs-down")) {
                            cancelDownvote(opposite_icon_selector, id, false);
                            opposite_vote_count--;
                        }

                        upvote(selected_icon_selector, id);
                        selected_vote_count++;

                        break;

                    case "fa-thumbs-up":
                        cancelUpvote(selected_icon_selector, id);
                        selected_vote_count--;
                        break;

                    case "fa-thumbs-o-down":
                        if($(opposite_icon_selector).hasClass("fa-thumbs-up")) {
                            cancelUpvote(opposite_icon_selector, id, false);
                            opposite_vote_count--;
                        }

                        downvote(selected_icon_selector, id);
                        selected_vote_count++;

                        break;

                    case "fa-thumbs-down":
                        cancelDownvote(selected_icon_selector, id);
                        selected_vote_count--;
                        break;
                }
            }

            $(selected_count_selector).text(selected_vote_count);
            $(opposite_count_selector).text(opposite_vote_count);
        }

        function upvote(selector, id) {
            $(selector).removeClass("fa-thumbs-o-up").addClass("fa-thumbs-up");
            $.post("/experience/" + id + "/vote", { value: 1 }).done(function(data) {
                if(data == 304) {
                    window.location = '/login';
                }
            });
        }

        function cancelUpvote(selector, id, send = true) {
            $(selector).removeClass("fa-thumbs-up").addClass("fa-thumbs-o-up");

            if (send) {
                $.post("/experience/" + id + "/vote", {value: 1}).done(function(data) {
                    if(data == 304) {
                        window.location = '/login';
                    }
                });
            }
        }

        function downvote(selector, id) {
            $(selector).removeClass("fa-thumbs-o-down").addClass("fa-thumbs-down");
            $.post("/experience/" + id + "/vote", {value: 0}).done(function(data) {
                if(data == 304) {
                    window.location = '/login';
                }
            });
        }

        function cancelDownvote(selector, id, send = true) {
            $(selector).removeClass("fa-thumbs-down").addClass("fa-thumbs-o-down");

            if (send) {
                $.post("/experience/" + id + "/vote", {value: 0}).done(function(data) {
                    if(data == 304) {
                        window.location = '/login';
                    }
                });
            }
        }
    </script>
    @include('partials.dialog-js')
    @include('partials.analytics')
@endsection
