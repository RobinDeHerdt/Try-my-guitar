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
                    <h1>@lang('content.guitar-experiences', ['guitar' => $guitar->name, 'brand' => $guitar->guitarBrand->name])</h1>
                    <a href="{{ route('guitar.show', $guitar->id) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-search"></span>@lang('content.view-guitar')</a>
                    <a href="{{ route('guitar.show', $guitar->id) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-search"></span></a>
                </div>
            </div>
            <div class="row">
                @foreach($guitar->experiences as $experience)
                    <div class="col-md-6" id="experience-{{ $experience->id }}">
                        <div class="search-result-header-image" style="background-image: url({{ Storage::disk('public')->url($experience->user->header_image_uri) }})"></div>
                        <div class="search-result">
                            <a href="{{ route('profile.show', ['id' => $experience->user->id]) }}" title="{{ $experience->user->fullName() }}">
                                <div class="search-result-profile-image" style="background-image: url({{ Storage::disk('public')->url($experience->user->image_uri) }})"></div>
                            </a>
                            <h3>{{ $experience->user->fullName()  }}</h3>
                            <br>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <p>{{ $experience->experience }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="@lang('content.mark-as-helpful')" onclick="event.preventDefault(); vote('{{ $experience->id }}', 1);">
                                    <span>
                                         <i class="fa {{ Auth::check() && $experience->upVotes->contains('user_id', Auth::user()->id) ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}" aria-hidden="true" id="upvote-{{ $experience->id }}"></i>
                                          <span id="upvote-count-{{ $experience->id }}">{{ $experience->upVotes->count() }}</span>
                                    </span>
                                </a>
                                <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="@lang('content.mark-as-not-helpful')" onclick="event.preventDefault(); vote('{{ $experience->id }}', 0);">
                                    <span>
                                         <i class="fa {{ Auth::check() && $experience->downVotes->contains('user_id', Auth::user()->id) ? 'fa-thumbs-down' : 'fa-thumbs-o-down' }}" aria-hidden="true" id="downvote-{{ $experience->id }}"></i>
                                        <span id="downvote-count-{{ $experience->id }}">{{ $experience->downVotes->count() }}</span>
                                    </span>
                                </a>
                            </div>
                            <br>
                        </div>
                    </div>
                @endforeach
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
            $.post("/experience/" + id + "/vote", { value: 1 });
        }

        function cancelUpvote(selector, id, send = true) {
            $(selector).removeClass("fa-thumbs-up").addClass("fa-thumbs-o-up");

            if (send) {
                $.post("/experience/" + id + "/vote", {value: 1});
            }
        }

        function downvote(selector, id) {
            $(selector).removeClass("fa-thumbs-o-down").addClass("fa-thumbs-down");
            $.post("/experience/" + id + "/vote", {value: 0});
        }

        function cancelDownvote(selector, id, send = true) {
            $(selector).removeClass("fa-thumbs-down").addClass("fa-thumbs-o-down");

            if (send) {
                $.post("/experience/" + id + "/vote", {value: 0});
            }
        }
    </script>
    @include('partials.analytics')
@endsection
