@extends('layouts.app')

@section('title', 'PrintIT!')

@section('content')
    <div class="container">
        <div class="row">
            @if(is_null($user->profile_photo))
                <img src="/uploads/avatars/default.png" style="width: 150px; height:150px; border-radius: 50%; margin-right: 25px; float: left;" >
            @else
                <img src="data:image/jpeg;base64,{{ base64_encode($file) }}" style="width: 150px; height:150px; border-radius: 50%; margin-right: 25px; float: left;" >
            @endif
            <h2><strong>{{$user->name}}'s Profile</strong></h2>
            @if (Auth::user() && (Auth::user()->id == $user->id))

                <a class="btn btn-xs btn-success" href="{{route('user.edit', $user->id)}}">Edit</a>

            @endif
        </div>
        <br>
        <div class="caption-full">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>User since:</strong> {{ $user->created_at }}</p>
            @if(!is_null($user->phone))
                <p><strong>Phone number:</strong> {{ $user->phone }}</p>
            @endif
            <p><strong>Department:</strong> {{ $user->department->name }}</p>
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
