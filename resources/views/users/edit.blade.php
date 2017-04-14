@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

    <div class="container">
        <form action="{{route('user.update', $user->id)}}" method="post" class="form-group" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="{{$user->id}}"/>

            <div class="row">
                <div class="col-md-6">
                    <label for="sel1">Name:</label><br>
                    <input name="name" type="text" class="form-control file" placeholder="User Name"
                           value="{{$user->name}}" required><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="sel1">Email:</label><br>
                    <input name="email" type="email" class="form-control file" placeholder="User Email"
                           value="{{$user->email}}" required><br>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="sel1">Phone Number:</label><br>
                    <input name="phone" type="number" class="form-control file" placeholder="Phone Number"
                           value="{{$user->phone}}"><br>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Update Imagem de Perfil</label>
                        <input type="file" name="avatar" accept="image/*">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group pull-right">
                <a href="{{route('index')}}">
                    <button type="button" class="btn btn-default" name="cancel">Cancel</button>
                </a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
            {{csrf_field()}}
        </form>
    </div>
@endsection