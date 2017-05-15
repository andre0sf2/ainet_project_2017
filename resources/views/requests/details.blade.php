@extends('layouts.app')

@section('title', 'Details!')

@section('content')
    <div class="container">
        <br>
        <div>
            <p><strong><h3>More details about Prints</h3></strong></p>
        </div>

        <div class="caption-full">
            <p><strong>Name:</strong> {{ $request->owner->name }}</p>
            <p><strong>Department:</strong> {{ $request->owner->department->name }}</p>

            <p><strong>Email:</strong> {{ $request->owner->email }}</p>
            <p><strong>Phone Number:</strong></p> @if($request->owner->phone == null)
                <p>No phone number available</p>
            @else
                <p>{{$request->owner->phone}}</p>
            @endif
            <p><strong>Date:</strong> {{ $request->due_date }}</p>
            <br>
            <p><strong><h4>Details about the request:</h4></strong></p>
            <p><strong>Color:</strong></p> @if($request->colored == 0)
                <p>Black and White</p>
            @else
                <p>Colored</p>
            @endif
            <p><strong>Single Paged or Both Sides:</strong></p>@if($request->front_back == 0)
                <p>Single paged</p>
            @else
                <p>Printed on both sides</p>
            @endif
            <p><strong>Description:</strong></p> @if($request->description == null)
                <p>No description</p>
            @else
                <p>
                    {{$request->description}}</p>
            @endif

            <p><strong>Stapled:</strong></p>@if($request->stapled == 0)
                <p>No</p>
            @else
                <p>Yes</p>
            @endif

            <p><strong>Paper Size:</strong></p>@if($request->paper_size == 3)
                <p>A3</p>
            @else
                <p>A4</p>
            @endif

            <p><strong>Type of paper:</strong></p>@if($request->paper_type == 0)
                <p>Draft Copy</p>
            @elseif($request->paper_type == 1)
                <p>Normal</p>
            @else
                <p>Photographic Paper</p>
            @endif

            <p><strong>File URL:</strong><a
                        href="{{ $request->file }}">{{ $request->file }}</a></p>
            <p><strong>Status of Print:</strong></p> @if($request->status == 2)
                <p>Expired</p>
            @elseif($request->status == 1)
                <p>Printed</p>
            @else
                <p>Waiting</p>
            @endif

        </div>
    </div>
    <hr>
    <div class="container">
        <p><strong>Comments:</strong></p>
        @foreach($comments as $comment)
            <p><strong>{{$comment->owner->name}}: </strong>{{$comment->comment}}</p>
            @if(!is_null($comment->parent))
                <p style="margin-left: 10px"><strong>{{$comment->parent->owner->name}}: </strong>{{$comment->parent->comment}}</p>
            @endif
        @endforeach
    </div>



@endsection