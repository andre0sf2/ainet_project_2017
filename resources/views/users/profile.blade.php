@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <img src="/uploads/avatars/{{$user->profile_photo}}" style="width: 150px; height:150px; border-radius: 50%; margin-right: 25px; float: left;" >
            <h2><strong>{{$user->name}}'s Profile</strong></h2>
            <form method="post" role="form" enctype="multipart/form-data" action="/user/{id}">
                <label>Update Imagem de Perfil</label>
                <input type="file" name="avatar">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="submit" class="pull-right btn btn-primary">
            </form>
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

        </div>
    </div>
@endsection
