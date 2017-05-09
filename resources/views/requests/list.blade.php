@extends('layouts.app')

@section('title', 'PrintIT! - Requests')

@section('content')

    <div class="row">
        @foreach($requests as $request)

        @endforeach
    </div>

@endsection