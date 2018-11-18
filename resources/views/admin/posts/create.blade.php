@extends('layouts.admin')

@section('content')
    <h1 class="page-header">Create Post</h1>
    @include('includes.form_errors')
    <form method="POST" action="/admin/posts" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id">
                <option value="">Choose Post Category</option>
                @foreach($categories as $category)
                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>
            {{--<input type="text" class="form-control" id="role_id" aria-describedby="roleHelp" placeholder="Enter User Role">--}}
            {{--<small id="roleHelp" class="form-text text-muted">Please insert role:1,2,3.</small>--}}
        </div>
        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" class="form-control" name="title" placeholder="Post title">
        </div>
        <div class="form-group">
            <label for="body">Post Content</label>
            <textarea class="form-control" name="body" rows="3" placeholder="Post content"></textarea>
        </div>
        <div class="form-group">
            <label for="photo_id">Photo</label>
            <input type="file" name="photo_id">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>
@stop