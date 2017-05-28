@extends('layouts.app')

@section('title', 'Details!')

@section('content')

<div class="container">
    <div class="caption-full">
        <p><strong>Name:</strong> {{ $request->owner->name }}</p>
        <p><strong>Department:</strong> {{ $request->owner->department->name }}</p>

        <p><strong>Email:</strong> {{ $request->owner->email }}</p>
        @if(is_null($request->owner->phone))
            <p><strong>Phone Number:</strong> No phone number available</p>
        @else
            <p><strong>Phone Number:</strong> {{$request->owner->phone}}</p>
        @endif
        <br><hr>

        <h4><strong>Details of Date</strong></h4>
        <div style="display: flex">
            <p style="width: 100%"><strong>Create at:</strong> {{ $request->created_at }}</p>
            <p style="width: 100%"><strong>Due Date:</strong> {{ $request->due_date }}</p>
        </div>
        <hr>
        <h4><strong>Details about the request:</strong></h4>

        @if($request->colored)
            <p><strong>Color:</strong> Colored</p>
        @else
            <p><strong>Color:</strong> Black and White</p>
        @endif

        @if($request->front_back)
            <p><strong>Single Paged or Both Sides:</strong> Printed on both sides</p>
        @else
            <p><strong>Single Paged or Both Sides:</strong> Single paged</p>
        @endif

        @if(is_null($request->description))
            <p><strong>Description: </strong>No description</p>
        @else
            <p><strong>Description: </strong>{{$request->description}}</p>
        @endif

        @if($request->stapled)
            <p><strong>Stapled:</strong> Yes</p>
        @else
            <p><strong>Stapled:</strong> No</p>
        @endif

        <p><strong>Paper Size:</strong> {{ $request->paperSizeToStr() }}</p>

        <p><strong>Type of paper:</strong> {{ $request->paperTypeToStr() }}</p>

        <p><strong>File URL: </strong><a href="{{ $request->file }}">{{ $request->file }}</a></p>

        <p><strong>Status of Print:</strong> {{ $request->statusToStr() }}</p>

        @if(!is_null($request->refused_reason))
            <p><strong>Refuse reason: </strong>{{ $request->refused_reason }}</p>
        @endif
    </div>
</div>
<hr>
@endsection