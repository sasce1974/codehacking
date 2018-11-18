@extends('layouts.admin')

@section('content')
    <h1 class="page-header well">Edit User</h1>
    <div class="row">
        @include('includes.form_errors')
    </div>
    <div class="col-sm-3">
        @if($user->photos->first() !="")
            <img class="img-responsive img-circle" height="200" src="{{asset($user->photos->first()['file'])}}" alt="User photo">
        @else <img height="200" src="http://placehold.it/200x200" alt="No user photo">
        @endif
    </div>
    <div class="col-sm-9">
    <form method="POST" action="/admin/users/{{$user->id}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="role_id">Role</label>
            <select class="form-control" name="role_id">
                <option value="">Choose User Role</option>
                @foreach($roles as $role)
                    @if($role['id'] == $user->role_id)
                        <option value="{{$role['id']}}" selected>{{$role['name']}}</option>
                    @else
                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                    @endif
                @endforeach
            </select>
            <label for="is_active">Status</label>
            <select class="form-control" name="is_active">
                <option value="">Choose User Status</option>
                    @if($user->is_active == 1)
                        <option value=1 selected>Active</option>
                        <option value=0>Not active</option>
                    @else
                        <option value=1>Active</option>
                        <option value=0 selected>Not active</option>
                    @endif
            </select>
            {{--<input type="text" class="form-control" id="role_id" aria-describedby="roleHelp" placeholder="Enter User Role">--}}
            {{--<small id="roleHelp" class="form-text text-muted">Please insert role:1,2,3.</small>--}}
        </div>
        <div class="form-group">
            <label for="name">User Name</label>
            <input type="text" class="form-control" name="name" value="{{$user->name}}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value={{$user->email}}>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="file">Photo</label>
            <input type="file" class="form-control" name="file">
        </div>
        <button type="submit" class="btn btn-primary mb-2 col-sm-3">Update</button>
        </form>
        <form method="POST" action="/admin/users/{{$user->id}}">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger mb-2 pull-right">Delete</button>
        </form>

    </div>
    @if($user->photos)
    <div class="center-block">
        @foreach($user->photos as $photo)
            <img height="100" class="img-rounded embed-responsive-item" src="{{asset($photo['file'])}}" alt="pic">
        @endforeach
    </div>
    @endif
@endsection