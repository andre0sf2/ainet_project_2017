@extends('layouts.app')

@section('title', 'PrintIT!')

@section('content')
    <div class="container">
        <div class="row">
            @if(is_null($user->profile_photo))
                <img src="{{ asset('uploads/avatars/default.png') }}"
                     style="width: 150px; height:150px; border-radius: 50%; margin-right: 25px; float: left;" alt="">
            @else
                <img src="{{ asset('storage/profiles/'.$user->profile_photo) }}"
                     style="width: 150px; height:150px; border-radius: 50%; margin-right: 25px; float: left;" alt="">
            @endif
            <h2><strong>{{$user->name}}'s Profile</strong></h2>
            <ul class="list-inline" style="display: flex;">
                @if (Auth::user() && (Auth::user()->id == $user->id))
                    <li>
                        <a class="btn btn-sm btn-success"
                           href="{{ route('user.edit', $user->id) }}">Edit</a>
                    </li>
                @endif

                @if (Auth::user() && Auth::user()->isAdmin() && !(Auth::user()->id == $user->id))
                    @if(!$user->isAdmin())
                        <li>
                            <form action="{{ route('user.block') }}" method="post">
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <button type="submit" class="btn btn-sm btn-danger">Block
                                </button>
                                {{csrf_field()}}
                            </form>
                        </li>


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
        <br>
        <div class="thumbnail caption-full" style="background-color: white">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>User since:</strong> {{ $user->created_at }}</p>
            @if(!is_null($user->phone))
                <p><strong>Phone number:</strong> {{ $user->phone }}</p>
            @else
                <p><strong>Phone number:</strong> No Phone Found</p>
            @endif
            <p><strong>Department:</strong> <a href="{{ route('department.info', $user->department->id) }}">{{ $user->department->name }}</a></p>
            @if($user->admin)
                <p><strong>Type:</strong> Administrator</p>
            @else
                <p><strong>Type:</strong> Employee</p>
            @endif
            @if(!is_null($user->presentation))
                <p><strong>Presentation: </strong>{{$user->presentation}}</p>
            @endif
            @if(!is_null($user->profile_url))
                <p><strong>Profile Url: </strong><a href="{{ $user->profile_url }}">{{ $user->profile_url }}</a></p>
            @endif
        </div>
    </div>
@endsection
