@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>{{ $user->first_name }}'s experiences</h1>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text"><span class="glyphicon glyphicon-user"></span>View {{ $user->first_name }}'s profile</a>
                </div>
            </div>
            @if($experiences->isNotEmpty())
                <div class="row">
                    @foreach($experiences as $experience)
                        <div class="col-md-6">
                            <div class="search-result">
                                <a href="{{ route('guitar.show', ['id' => $experience->guitar->id]) }}">
                                    @if($experience->guitar->guitarImages->isNotEmpty())
                                        <img src="{{ Storage::disk('public')->url($experience->guitar->guitarImages()->first()->image_uri) }}" class="search-result-image">
                                    @else
                                        <div class="search-result-image">No image available</div>
                                    @endif
                                </a>
                                <h3>{{ $experience->guitar->name }}</h3>
                                <hr>
                                <p>{{ $experience->experience }}</p>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 feedback-section">
                                        <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="Mark this experience as helpful" onclick="event.preventDefault(); vote('{{ $experience->id }}', 1);">
                                            <span id="upvote-count">
                                                <i class="fa {{ Auth::check() && $experience->upVotes->contains(Auth::user()->id) ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}" aria-hidden="true"></i>
                                                {{ $experience->upVotes->count() }}
                                            </span>
                                        </a>
                                        <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="Mark this experience as not helpful" onclick="event.preventDefault(); vote('{{ $experience->id }}', 0);">
                                             <span>
                                                 <i class="fa {{ Auth::check() && $experience->downVotes->contains(Auth::user()->id) ? 'fa-thumbs-down' : 'fa-thumbs-o-down' }}" aria-hidden="true"></i>
                                                 {{ $experience->downVotes->count() }}
                                             </span>
                                        </a>
                                        <form action="{{ route('experience.vote', ['id' => $experience->id ])}}"  method="POST" id="vote-form-{{ $experience->id }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="value" id="value-field-{{ $experience->id }}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h4>Nothing to see here (yet).</h4>
            @endif
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
