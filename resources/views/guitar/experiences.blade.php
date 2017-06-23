@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>"{{ $guitar->name }}" experiences</h1>
                    <a href="{{ route('guitar.show', $guitar->id) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-search"></span>View guitar</a>
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
                            <div class="col-md-12 feedback-section">
                                <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="Mark this experience as helpful" onclick="event.preventDefault(); vote('{{ $experience->id }}', 1);">
                                    <span>
                                         <i class="fa {{ Auth::check() && $experience->upVotes->contains('user_id', Auth::user()->id) ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}" aria-hidden="true"></i>
                                          {{ $experience->upVotes->count() }}
                                    </span>
                                </a>
                                <a href="{{ route('experience.vote', ['id' => $experience->id ])}}" class="cta-button" title="Mark this experience as not helpful" onclick="event.preventDefault(); vote('{{ $experience->id }}', 0);">
                                    <span>
                                         <i class="fa {{ Auth::check() && $experience->downVotes->contains('user_id', Auth::user()->id) ? 'fa-thumbs-down' : 'fa-thumbs-o-down' }}" aria-hidden="true"></i>
                                        {{ $experience->downVotes->count() }}
                                    </span>
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
        if(location.hash.slice(1)) {
            $('html,body').animate({
                scrollTop: $("#" + location.hash.slice(1)).offset().top - 80
            }, 1000 );
        }

        function vote(id, value) {
            $('#value-field-' +id).val(value);
            $('#vote-form-' + id).submit();
        }
    </script>
    @include('partials.analytics')
@endsection
