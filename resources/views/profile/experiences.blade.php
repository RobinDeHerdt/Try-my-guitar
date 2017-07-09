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
                    <a href="{{ route('profile.show', ['user' => $user->id]) }}" class="icon-text icon-full"><span class="glyphicon glyphicon-user"></span>View {{ $user->first_name }}'s profile</a>
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
                                        <div class="search-result-image">No image available</div>
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
                                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="{{ route('experience.destroy', ['id' => $experience->id ]) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $experience->id }}').submit();" title="Remove your experience">
                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                </a>
                                                <form action="{{ route('experience.destroy', ['id' => $experience->id ])}}"  method="POST" id="delete-form-{{ $experience->id }}" style="display: none">
                                                    {{ csrf_field() }}
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
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

        function showEditForm(id) {
            $('#experience-form-' + id).show();
            $('#experience-text-' + id).hide();
        }

        function closeEditForm(id) {
            $('#experience-form-' + id).hide();
            $('#experience-text-' + id).show();
        }
    </script>
    @include('partials.analytics')
@endsection
