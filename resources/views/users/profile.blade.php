@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <img src="/uploads/avatars/{{$user->profile_photo}}" style="width: 150px; height:150px; border-radius: 50%; margin-right: 25px; float: left;" >
            <h2><strong>{{$user->name}}'s Profile</strong></h2>
        </div>
        <br>
        <div class="caption-full">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>User since:</strong> {{ $user->created_at }}</p>
            @if(!is_null($user->phone))
                <p><strong>Phone number:</strong> {{ $user->phone }}</p>
            @endif
            @if(!is_null($user->department_id))
                <p><strong>Department:</strong> {{ $department->name }}</p>
            @endif
            @if($user->admin)
                <p><strong>Type:</strong> Administrator</p>
            @else
                <p><strong>Type:</strong> Employee</p>
            @endif
        </div>
    </div>
@endsection
