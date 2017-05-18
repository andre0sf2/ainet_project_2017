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
                    <input name="search" type="text" class="form-control" placeholder="Search for..."
                           style="width: 97%;"/>
                    <span class="input-group-btn"><button class="btn btn-default" type="button"><i
                                    class="glyphicon glyphicon-search"></i></button></span>
                </div>
                {{csrf_field()}}
            </form>

            <div class="media row">
                @foreach($users as $user)
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="media-main">
                                    <a class="pull-left" href="{{route('user.show', $user->id)}}"
                                       style="margin-right: 13%">
                                        @if(is_null($user->profile_photo))
                                            <img class="media-object" src="/uploads/avatars/default.png" alt=""
                                                 style="width:140px; height:140px; top: 10px; left: 10px; border-radius: 50%;">
                                        @else
                                            <img class="media-object"
                                                 src="{{ asset('storage/profiles/'.$user->profile_photo) }}"
                                                 alt=""
                                                 style="width:140px; height:140px; top: 10px; left: 10px; border-radius: 50%;">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <div class="info">
                                            <h4><a href="{{route('user.show', $user->id)}}">{{ $user->name }}</a></h4>
                                            <p class="text-muted"><strong>Email: </strong>{{$user->email}}</p>
                                            @if(!is_null($user->phone))
                                                <p class="text-muted"><strong>Phone: </strong>{{ $user->phone }}</p>
                                            @else
                                                <p class="text-muted"><strong>Phone: </strong>No Phone Number</p>
                                            @endif
                                            <p class="text-muted"><strong>Department: </strong>{{$user->department->name}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <ul class="list-inline" style="display: flex;">
                                    @if (Auth::user() && (Auth::user()->id == $user->id))
                                        <li>
                                            <a class="btn btn-sm btn-success"
                                               href="{{ route('user.edit', $user->id) }}">Edit</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="btn btn-sm btn-primary"
                                           href="{{route('user.show', $user->id)}}">View</a>
                                    </li>

                                    @if (Auth::user() && Auth::user()->isAdmin())
                                        <li>
                                            <form action="{{ route('user.block') }}" method="post">
                                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                                <button type="submit" class="btn btn-sm btn-danger">Block
                                                </button>
                                                {{csrf_field()}}
                                            </form>
                                        </li>

                                        @if($user->admin != 1)
                                            <li>
                                                <form action="{{ route('admin.grant') }}" method="post">
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <button type="submit" class="btn btn-sm btn-alert">Grant Admin
                                                    </button>
                                                    {{csrf_field()}}
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <form action="{{ route('admin.revoke') }}" method="post">
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Revoke
                                                        Admin
                                                    </button>
                                                    {{csrf_field()}}
                                                </form>
                                            </li>
                                        @endif
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        <div style="text-align: center">
            {{ $users->links() }}
        </div>
    @else
        <div class="container">
            <h2>No Users Found</h2>
        </div>
    @endif




@endsection

