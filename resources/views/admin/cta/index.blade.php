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
                    <h1>Calls to action</h1>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-home"></span>Back to control panel</a>
                    <a href="{{ route('admin.dashboard') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-home"></span></a>
                    <a href="{{ route('admin.cta.create') }}" class="icon-text icon-full"><span class="glyphicon glyphicon-plus"></span>Create call to action item</a>
                    <a href="{{ route('admin.cta.create') }}" class="icon-text icon-responsive"><span class="glyphicon glyphicon-plus"></span></a>
                </div>
            </div>
            @if($cta_items->isNotEmpty())
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="center">Active</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th class="center">Icon</th>
                                <th class="center">Last updated</th>
                                <th class="center">View</th>
                                <th class="center">Edit</th>
                                <th class="center">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($cta_items as $cta_item)
                                    <tr>
                                        <td class="center">
                                            <form action="{{ route('admin.cta.update-status', ['cta_item' => $cta_item]) }}" method="POST" id="status-form-{{ $cta_item->id }}">
                                                {{ csrf_field() }}
                                                <input type="checkbox" name="value" {{ $cta_item->active ? 'checked' : '' }} onclick="changeStatus({{ $cta_item->id }});">
                                            </form>
                                        </td>
                                        <td>{{ str_limit($cta_item->title) }}</td>
                                        <td>{{ str_limit($cta_item->content_en, 85) }}</td>
                                        <td class="center"><i class="fa {{ $cta_item->icon_class }}" aria-hidden="true"></i></td>
                                        <td class="center">{{ $cta_item->updated_at ? $cta_item->updated_at : 'n/a' }}</td>
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
                    </div>
                </div>
            @else
                <div class="no-results">
                    <h4>No call to action sections to be displayed</h4>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function changeStatus(id) {
            $("#status-form-"+id).submit();
        }
    </script>
@endsection