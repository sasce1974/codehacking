@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @if(Session::has('deleted_user'))
        <div class="panel-body bg-info">
        <p>{{session('deleted_user')}}</p>
        </div>
    @endif

    <h1>Admin users</h1>
    <table class="table table-striped">
        <thead>
        <tr style="vertical-align: middle;">
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Is active</th>
            <th>Created</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>
        @if($users)
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>
                        @if($user->photos->first() !="")
                            <img class="img-rounded" height="50" src="{{asset($user->photos->first()['file'])}}" alt="User photo">
                        @else <img height="50" src="http://placehold.it/50x50" alt="No user photo">
                        @endif
                    </td>
                    <td style="vertical-align: middle;"><a href="{{route('admin.users.edit', $user->id)}}">{{$user->name}}</a></td>
                    <td style="vertical-align: middle;">{{$user->email}}</td>
                    <td style="vertical-align: middle;">{{$user->role['name']}}</td>
                    {{--<td>@if($user->is_active == 1) YES--}}
                    {{--@else NO--}}
                    {{--@endif</td>--}}
                    <td style="vertical-align: middle;">{{$user->is_active == 1 ? 'Active' : 'Not active'}}</td>
                    <td style="vertical-align: middle;">{{$user->created_at->diffForHumans()}}</td>
                    <td style="vertical-align: middle;">{{$user->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@endsection

@section('footer')
    <h3>This is ADMIN INDEX FOOTER</h3>
@endsection
