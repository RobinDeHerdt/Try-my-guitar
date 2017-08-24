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
                    <h1>Guitars</h1>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>Back to control panel</a>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
                </div>
            </div>
            @if($guitars->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Added</th>
                                <th>Title</th>
                                <th>Brand</th>
                                <th>Types</th>
                                <th class="center">View</th>
                                <th class="center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guitars as $guitar)
                                <tr>
                                    <td>{{ $guitar->created_at ? $guitar->created_at->diffForHumans() : 'n/a' }}</td>
                                    <td>{{ $guitar->name }}</td>
                                    <td>{{ $guitar->guitarBrand->name }}</td>
                                    <td>
                                        @foreach($guitar->guitarTypes as $type)
                                            {{ $type->name_en . ($loop->last ? '' : ' &middot; ') }}
                                        @endforeach
                                    </td>
                                    <td class="center"><a href="{{ route('guitar.show', ['id' => $guitar->id]) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                                    <td class="center"><a href="{{ route('admin.guitars.destroy', ['id' => $guitar->id]) }}" onclick="deleteItem({{ $guitar->id }},'delete-guitar');"><span class="glyphicon glyphicon-trash"></span></a>
                                        <form id="delete-guitar-{{ $guitar->id }}" action="{{ route('admin.guitars.destroy', ['id' => $guitar->id]) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $guitars->links() }}
            @else
                <div class="no-results">
                    <h4>No guitars to be displayed</h4>
                </div>
            @endif
        </div>
    </div>
    @include('partials.dialog')
@endsection

@section('scripts')
    @include('partials.dialog-js')
@endsection
