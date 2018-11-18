@extends('layouts.admin')

@section('content')
    @if(Session::has('deleted_post'))
        <div class="panel-body bg-info">
            <h2>{{session('deleted_post')}}</h2>
        </div>
    @endif
    <h1 class="page-header">Posts</h1>
    <table class="table table-striped">
        <thead>
        <tr style="vertical-align: middle;">
            <th>ID</th>
            <th>User</th>
            <th>Category</th>
            <th>Photo ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Created</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>
        @if($posts)
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td style="vertical-align: middle;">{{$post->user->name}}</td>
                    {{--can be also as: $post->user['name']--}}
                    {{--<td style="vertical-align: middle;">{{\App\Category::find($post->category_id)->name}}</td>--}}
                    <td style="vertical-align: middle;">{{$post->category ? $post->category->name : "Uncategoriazed"}}</td>
                    <td style="vertical-align: middle;"><img height="50" class="img-rounded" src="{{$post->photo ? $post->photo->file : 'http://placehold.it/50x50'}}"></td>
                    <td style="vertical-align: middle;"><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></td>
                    <td style="vertical-align: middle;">{{substr($post->body, 0, 20) . "..."}}</td>
                    <td style="vertical-align: middle;">{{$post->created_at->diffForHumans()}}</td>
                    <td style="vertical-align: middle;">{{$post->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    {{--@include('includes.form_errors')--}}
@stop