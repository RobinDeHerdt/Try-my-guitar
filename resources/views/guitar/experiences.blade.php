@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <h1>"{{ $guitar->name }}" experiences</h1>
                <a href="{{ route('guitar.show', $guitar->id) }}" class="icon-text"><span class="glyphicon glyphicon-search"></span>View guitar</a>
            </div>
            <div class="row">
                @foreach($guitar->experiences as $experience)
                    <div class="col-md-6">
                        <div class="search-result-header-image" style="background-image: url({{ Storage::disk('public')->url($experience->user->header_image_uri) }})"></div>
                        <div class="search-result">
                            <a href="{{ route('profile.show', ['id' => $experience->user->id]) }}" title="{{ $experience->user->fullName() }}">
                                <div class="search-result-profile-image" style="background-image: url({{ Storage::disk('public')->url($experience->user->image_uri) }})"></div>
                            </a>
                            <h3>{{ $experience->user->fullName()  }}</h3>
                            <br>
                            <p>{{ $experience->experience }}</p>
                            <hr>
                            <div class="col-md-12 feedback-section">
                                <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="Mark this experience as helpful" onclick="event.preventDefault(); vote('{{ $experience->id }}', 1);">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                    <span id="upvote-count"> {{ $experience->upVotes->count() }}</span>
                                </a>
                                <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="Mark this experience as not helpful" onclick="event.preventDefault(); vote('{{ $experience->id }}', 0);">
                                    <span class="glyphicon glyphicon-thumbs-down"></span>
                                    <span id="{{ $experience->id  }}"> {{ $experience->downVotes->count() }}</span>
                                </a>
                                <form action="{{ route('experience.vote', ['id' => $experience->id ])}}"  method="POST" id="vote-form-{{ $experience->id }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="value" id="value-field-{{ $experience->id }}">
                                </form>
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
        function vote(id, value) {
            $('#value-field-' +id).val(value);
            $('#vote-form-' + id).submit();
        }
    </script>
    @include('partials.analytics')
@endsection
