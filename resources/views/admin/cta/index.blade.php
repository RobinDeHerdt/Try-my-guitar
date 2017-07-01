@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row heading">
                <div class="col-md-12">
                    <h1>Call to action items</h1>
                    <a href="{{ route('articles.create') }}" class="icon-text"><span class="glyphicon glyphicon-plus"></span>Create call to action item</a>
                </div>
            </div>
            @if (Session::has('success-message'))
                <div class="alert alert-success">{{ Session::get('success-message') }}</div>
            @endif
            @if (Session::has('info-message'))
                <div class="alert alert-info">{{ Session::get('info-message') }}</div>
            @endif
            @if($cta_items->isNotEmpty())
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Icon</th>
                        <th>Last updated</th>
                        <th class="center">View</th>
                        <th class="center">Edit</th>
                        <th class="center">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cta_items as $cta_item)
                        <tr>
                            <td>{{ str_limit($cta_item->title) }}</td>
                            <td>{{ str_limit($cta_item->content, 85) }}</td>
                            <td><i class="fa {{ $cta_item->icon_class }}" aria-hidden="true"></i></td>
                            <td>{{ $cta_item->updated_at ? $cta_item->updated_at : 'n/a' }}</td>
                            <td class="center"><a href="{{ route('admin.cta.show', ['id' => $cta_item->id]) }}"><span class="glyphicon glyphicon-search"></span></a></td>
                            <td class="center"><a href="{{ route('admin.cta.edit', ['id' => $cta_item->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="center"><a href="{{ route('admin.cta.destroy', ['id' => $cta_item->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-cta-{{ $cta_item->id }}-form').submit();"><span class="glyphicon glyphicon-trash"></span></a>
                                <form id="delete-cta-{{ $cta_item->id }}-form" action="{{ route('admin.cta.destroy', ['id' => $cta_item->id]) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-results">
                    <h4>No call to action sections to be displayed</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
