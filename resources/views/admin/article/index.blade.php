@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ str_limit($article->body, 75)}}</td>
                        <td><a href="{{ $article->image_uri }}">View image</a></td>
                        <td><a href=""><span class="glyphicon glyphicon-search"></span></a></td>
                        <td><a href=""><span class="glyphicon glyphicon-pencil"></span></a></td>
                        <td><a href=""><span class="glyphicon glyphicon-trash"></span></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
