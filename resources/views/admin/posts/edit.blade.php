@extends('layouts.admin')

@section('content')
    <h1 class="page-header well">Edit Post</h1>
    <div class="row">
        @include('includes.form_errors')
    </div>
    <div class="col-sm-3">
        @if($post->photo !="")
            <img class="img-responsive img-circle" height="200" src="{{asset($post->photo->file)}}" alt="Post photo">
        @else <img height="200" src="http://placehold.it/200x200" alt="No user photo">
        @endif
    </div>
    <div class="col-sm-9">
    <form method="POST" action="/admin/posts/{{$post->id}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id">
                @foreach($categories as $category)
                    @if($category['id'] == $post->category_id)
                        <option value="{{$category['id']}}" selected>{{$category['name']}}</option>
                    @else
                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" class="form-control" name="title" value="{{$post->title}}">
        </div>
        <div class="form-group">
            <label for="body">Post Content</label>
            <textarea class="form-control" name="body" rows="3">{{$post->body}}</textarea>
        </div>
        <div class="form-group">
            <label for="photo_id">Photo</label>
            <input type="file" name="photo_id">
        </div>
        <button type="submit" class="btn btn-primary mb-2 col-sm-3">Update post</button>
    </form>
    <form method="POST" action="/admin/posts/{{$post->id}}">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger mb-2 pull-right">Delete post</button>
    </form>
    </div>
@stop