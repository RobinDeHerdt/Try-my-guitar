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
                    <h1>{{ $user->first_name }}'s collection</h1>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-user"></span>View {{ $user->first_name }}'s profile</a>
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-user"></span></a>
                    @if(Auth::check() && Auth::user()->id === $user->id)
                        <a href="{{ route('collection.create') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-plus"></span>Add guitar to collection</a>
                        <a href="{{ route('collection.create') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-plus"></span></a>
                    @endif
                </div>
            </div>
            @if($user->guitars->isNotEmpty())
                <div class="row">
                    @foreach($user->guitars as $guitar)
                        <div class="col-md-6" id="guitar-{{$guitar->id }}">
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
                                    @if(!$user->guitarExperience($guitar))
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('experience.store', ['guitar' => $guitar->id]) }}"  onclick="event.preventDefault(); showCreateForm({{ $guitar->id }});" id="experience-add-link-{{ $guitar->id }}">Write your experience</a>
                                                <form action="{{ route('experience.store', ['guitar' => $guitar->id]) }}" method="POST" id="experience-add-form-{{ $guitar->id }}" style="display: none">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <textarea name="experience" class="form-control" id="input-experience" rows="5" placeholder="Write your experience here"></textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-8">
                                                            <div class="form-group">
                                                                <input type="submit" class="btn btn-primary col-md-12" value="Save">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('collection.destroy', ['guitar' => $guitar->id]) }}"  onclick="event.preventDefault(); document.getElementById('collection-remove-{{ $guitar->id }}').submit();">Remove from collection</a>
                                            <form action="{{ route('collection.destroy', ['guitar' => $guitar->id]) }}" method="POST" id="collection-remove-{{ $guitar->id }}">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                @if ($user->guitarExperience($guitar))<hr>
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="collection-experience">
                                                <strong>{{ $user->first_name }}'s experience with this guitar:</strong>
                                                <br><br>
                                                <form action="{{ route('experience.update', ['id' => $user->guitarExperience($guitar)->id ])}}"  method="POST" id="experience-form-{{ $user->guitarExperience($guitar)->id }}" style="display: none">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <textarea name="experience" class="form-control" id="input-experience" rows="5">{{ $user->guitarExperience($guitar)->experience }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-primary" value="Save">
                                                    </div>
                                                </form>
                                                <div id="experience-text-{{ $user->guitarExperience($guitar)->id }}">
                                                    <p>{{ $user->guitarExperience($guitar)->experience }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        @if(Auth::check() && Auth::user()->id === $user->id)
                                            <div class="col-md-12">
                                                <div class="col-md-4 col-md-offset-2">
                                                    <a href="{{ route('guitar.show', ['id' => $guitar->id]) }}" onclick="event.preventDefault(); showEditForm({{ $user->guitarExperience($guitar)->id }});"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="{{ route('experience.destroy', ['id' => $user->guitarExperience($guitar)->id ]) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->guitarExperience($guitar)->id }}').submit();"><i class="fa fa-times" aria-hidden="true"></i> Delete</a>
                                                    <form action="{{ route('experience.destroy', ['id' => $user->guitarExperience($guitar)->id ])}}"  method="POST" id="delete-form-{{ $user->guitarExperience($guitar)->id }}" style="display: none">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <a href="{{ route('experience.vote', ['id' => $user->guitarExperience($guitar)->id ])}}" class="cta-button" title="Mark this experience as helpful" onclick="event.preventDefault(); vote('{{ $user->guitarExperience($guitar)->id }}', 1);">
                                                    <span>
                                                        <i class="fa {{ Auth::check() && $user->guitarExperience($guitar)->upVotes->contains('user_id', Auth::user()->id) ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}" aria-hidden="true"></i>
                                                        {{ $user->guitarExperience($guitar)->upVotes->count() }}
                                                    </span>
                                                </a>
                                                <a href="{{ route('experience.vote', ['id' => $user->guitarExperience($guitar)->id ])}}" class="cta-button" title="Mark this experience as not helpful" onclick="event.preventDefault(); vote('{{ $user->guitarExperience($guitar)->id }}', 0);">
                                                    <span>
                                                        <i class="fa {{ Auth::check() && $user->guitarExperience($guitar)->downVotes->contains('user_id', Auth::user()->id) ? 'fa-thumbs-down' : 'fa-thumbs-o-down' }}" aria-hidden="true"></i>
                                                         {{ $user->guitarExperience($guitar)->downVotes->count() }}
                                                    </span>
                                                </a>
                                                <form action="{{ route('experience.vote', ['id' => $user->guitarExperience($guitar)->id ])}}" method="POST" id="vote-form-{{ $user->guitarExperience($guitar)->id }}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="value" id="value-field-{{ $user->guitarExperience($guitar)->id }}">
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <h4>Nothing to see here (yet).</h4>
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

        function showEditForm(id) {
            $('#experience-form-' + id).show();
            $('#experience-text-' + id).hide();
        }

        function showCreateForm(id) {
            $('#experience-add-form-' + id).show();
            $('#experience-add-link-' + id).hide();
        }
    </script>
    @include('partials.analytics')
@endsection
