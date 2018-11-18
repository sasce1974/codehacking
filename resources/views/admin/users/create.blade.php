@extends('layouts.admin')

@section('content')
    <h1>Create User</h1>
    @include('includes.form_errors')
    <form method="POST" action="/admin/users" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="role_id">Role</label>
            <select class="form-control" name="role_id">
                <option value="">Choose User Role</option>
                @foreach($roles as $role)
                    <option value="{{$role['id']}}">{{$role['name']}}</option>
                @endforeach
            </select>
            {{--<input type="text" class="form-control" id="role_id" aria-describedby="roleHelp" placeholder="Enter User Role">--}}
            {{--<small id="roleHelp" class="form-text text-muted">Please insert role:1,2,3.</small>--}}
        </div>
        <div class="form-group">
            <label for="name">User Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name and Surname">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" placeholder="someone@domain.com">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="file">Photo</label>
            <input type="file" class="form-control" name="file">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>
@endsection