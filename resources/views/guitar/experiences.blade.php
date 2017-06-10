@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <h2>"{{ $guitar->name }}" experiences</h2>
        <div class="container">
            <div class="row">
                @foreach($guitar->users as $user)
                    <div class="col-md-6">
                        <div class="dashboard-content">
                            <p>{{ $user->pivot->experience }}</p>
                            <a href="{{ route('profile.show', ['id' => $user->id]) }}">{{ $user->fullName() }}</a>
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
    @include('partials.analytics')
@endsection
