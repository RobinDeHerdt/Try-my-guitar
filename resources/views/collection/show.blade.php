@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            <div class="row heading">
                <div class="col-md-12">
                    <h1>{{ $user->first_name }}'s collection</h1>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text"><span class="glyphicon glyphicon-user"></span>View {{ $user->first_name }}'s profile</a>
                    @if(Auth::check() && Auth::user()->id === $user->id)
                        <a href="{{ route('collection.create') }}" class="icon-text"><span class="glyphicon glyphicon-plus"></span>Add guitar to collection</a>
                    @endif
                </div>
                @if($user->guitars->isNotEmpty())
                    @foreach($user->guitars as $guitar)
                        <div class="col-md-6">
                            <div class="search-result">
                                <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">
                                    @if($guitar->guitarImages->isNotEmpty())
                                        <img src="{{ Storage::disk('public')->url($guitar->guitarImages()->first()->image_uri) }}" class="search-result-image">
                                    @else
                                        <div class="search-result-image">No image available</div>
                                    @endif
                                </a>
                                <h3>{{ $guitar->name }}</h3>
                                @if(Auth::check() && Auth::user()->id === $user->id)
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}"  onclick="event.preventDefault(); document.getElementById('collection-remove-{{ $guitar->id }}').submit();">Remove from collection</a>
                                            <form action="{{ route('collection.destroy') }}" method="POST" id="collection-remove-{{ $guitar->id }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $guitar->id }}">
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                @if ($user->getGuitarExperience($guitar))
                                    <hr>
                                    <div class="collection-experience">
                                        <p>{{ $user->getGuitarExperience($guitar)->experience }}</p>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @if(Auth::check() && Auth::user()->id === $user->id)
                                            <div class="col-md-12">
                                                <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}">Edit</a>
                                            </div>
                                        @else
                                            <div class="col-md-12 feedback-section">
                                                <a href="{{ route('experience.vote', ['id' => $user->getGuitarExperience($guitar)->id ])}}" class="cta-button" title="Mark this experience as helpful" onclick="event.preventDefault(); vote('{{ $user->getGuitarExperience($guitar)->id }}', 1);">
                                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                                    <span id="upvote-count"> {{ $user->getGuitarExperience($guitar)->upVotes->count() }}</span>
                                                </a>
                                                <a href="{{ route('experience.vote', ['id' => $user->getGuitarExperience($guitar)->id ])}}" class="cta-button" title="Mark this experience as not helpful" onclick="event.preventDefault(); vote('{{ $user->getGuitarExperience($guitar)->id }}', 0);">
                                                    <span class="glyphicon glyphicon-thumbs-down"></span>
                                                    <span id="{{ $user->getGuitarExperience($guitar)->id  }}"> {{ $user->getGuitarExperience($guitar)->downVotes->count() }}</span>
                                                </a>
                                                <form action="{{ route('experience.vote', ['id' => $user->getGuitarExperience($guitar)->id ])}}"  method="POST" id="vote-form-{{ $user->getGuitarExperience($guitar)->id }}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="value" id="value-field-{{ $user->getGuitarExperience($guitar)->id }}">
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                        <h4>Nothing to see here (yet).</h4>
                    </div>
                @endif
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
