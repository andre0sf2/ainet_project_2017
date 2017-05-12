@extends('layouts.app')

@section('title', 'PrintIT! - Users')

@section('content')

    @if(count($users))
        <div class="container">


            @if(session('success'))
                @include('partials.success')
            @endif

            @if(session('errors'))
                @include('partials.errors')
            @endif


            <form class="form-group" method="POST" action="#">
                <div class="form-group" style="display: flex;">
                    <input name="search" type="text" class="form-control" placeholder="Search for..." style="width: 97%;"/>
                    <span class="input-group-btn"><button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button></span>
                </div>
                {{csrf_field()}}
            </form>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Member Since</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                @if(!is_null($user->phone))
                    <td>{{ $user->phone }}</td>
                @else
                    <td>No Phone Number</td>
                @endif
                <td>{{$user->created_at}}</td>
                <td class="col-md-3 inline">
                    <div class="col-md-2">
                        <a class="btn btn-xs btn-primary" href="{{route('user.show', $user->id)}}">View</a>
                    </div>
                    @if (Auth::user() && (Auth::user()->id == $user->id))
                        <div class="col-md-2">

                            <a class="btn btn-xs btn-success" href="{{ route('user.edit', $user->id) }}">Edit</a>
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
                </td>
            </tr>
                </tbody>
        @endforeach
            </table>
        </div >
        <div style="text-align: center">
            {{ $users->links() }}
        </div>
        @else
            <div class="container">
                <h2>No Users Found</h2>
            </div>
        @endif


@endsection