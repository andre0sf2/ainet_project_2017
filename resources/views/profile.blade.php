@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <img src="/uploads/avatars/{{$user->profile_photo}}" style="width: 150px; height:150px; border-radius: 50%; margin-right: 25px; float: left;" >
            <h2>Perfil de <strong>{{$user->name}}</strong></h2>
            <form method="post" role="form" enctype="multipart/form-data" action="/user/{id}">
                <label>Update Imagem de Perfil</label>
                <input type="file" name="avatar">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="submit" class="pull-right btn btn-primary">
            </form>
        </div>
    </div>
@endsection
