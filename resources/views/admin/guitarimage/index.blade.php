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
                    <h1>Images</h1>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>Back to control panel</a>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
                </div>
            </div>
            @if($guitarimages->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Added</th>
                                <th>Uploader</th>
                                <th class="center">View</th>
                                <th class="center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guitarimages as $guitarimage)
                                <tr>
                                    <td>{{ $guitarimage->created_at ? $guitarimage->created_at->diffForHumans() : 'n/a' }}</td>
                                    <td><a href="{{ route('profile.show', ['id' => $guitarimage->user->id]) }}">{{ $guitarimage->user->fullName() }}</a></td>
                                    <td class="center"><a href="{{ Storage::disk('public')->url($guitarimage->image_uri) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                                    <td class="center"><a href="{{ route('admin.guitarimages.destroy', ['guitarimage' => $guitarimage->id]) }}" onclick="deleteItem({{ $guitarimage->id }},'delete-guitarimage');"><span class="glyphicon glyphicon-trash"></span></a>
                                        <form id="delete-guitarimage-{{ $guitarimage->id }}" action="{{ route('admin.guitarimages.destroy', ['guitarimage' => $guitarimage->id]) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $guitarimages->links() }}
            @else
                <div class="no-results">
                    <h4>No images to be displayed</h4>
                </div>
            @endif
        </div>
    </div>
    @include('partials.dialog')
@endsection

@section('scripts')
    @include('partials.dialog-js')
@endsection
