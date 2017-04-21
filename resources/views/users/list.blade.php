@extends('layouts.app')

@section('title', 'PrintIT! - Users')

@section('content')

    @if(count($users))
        <div class="container">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Email</th>
                    <th>Fullname</th>
                    <th>Registered At</th>
                </tr>
                </thead>
                <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->email}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->created_at}}</td>
                <td class="col-md-3 inline">
                    <div class="col-md-2">
                        <a class="btn btn-xs btn-primary" href="{{route('user.show', $user->id)}}">View</a>
                    </div>
                    @if (Auth::user() && (Auth::user()->isAdmin() || Auth::user()->id == $user->id))
                        <div class="col-md-2">

                            <a class="btn btn-xs btn-success" href="{{route('user.edit', $user->id)}}">Edit</a>
                        </div>
                    @endif
                    @if (Auth::user() && Auth::user()->isAdmin())
                        <div class="col-md-2">

                            <form action="{{ route('user.block') }}" method="post">
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <button type="submit" class="btn btn-xs btn-danger">Block</button>
                                {{csrf_field()}}
                            </form>
                        </div>
                        <div class="col-md-3">

                            @if($user->admin != 1)
                                <form action="{{ route('admin.grant') }}" method="post">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-xs btn-alert">Grant Admin</button>
                                    {{csrf_field()}}
                                </form>
                            @else
                                <form action="{{ route('admin.revoke') }}" method="post">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-xs btn-danger">Revoke Admin</button>
                                    {{csrf_field()}}
                                </form>
                        </div>
                            @endif
                    @endif
            </tr>
                </tbody>
        @endforeach
            </table>
        </div>
        @else
            <div class="container">
                <h2>No Users Found</h2>
            </div>
        @endif


@endsection