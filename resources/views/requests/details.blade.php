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
            <p><strong>Phone Number:</strong> @if($request->owner->phone == null)
                <td>No phone number available</td>
            @else
                <td>{{$request->owner->phone}}</td>
                @endif
                </p>
                <p><strong>Date:</strong> {{ $request->due_date }}</p>
                <br>
                <p><strong><h4>Details about the request:</h4></strong></p>
                <p><strong>Color:</strong>@if($request->colored == 0)
                    <td>Black and White</td>
                @else
                    <td>Colored</td>
                    @endif
                    </p>
                    <p><strong>Single Paged or Both Sides:</strong>@if($request->front_back == 0)
                        <td>Single paged</td>
                    @else
                        <td>Printed on both sides</td>
                        @endif</p>
                        <p><strong>Description:</strong> @if($request->description == null)
                            <td>No description</td>
                        @else
                            <td>
                                {{$request->description}}</td>
                            @endif
                            </p>
                            <p><strong>Stapled:</strong>@if($request->stapled == 0)
                                <td>No</td>
                            @else
                                <td>Yes</td>
                                @endif
                                </p>
                                <p><strong>Paper Size:</strong>@if($request->paper_size == 3)
                                    <td>A3</td>
                                @else
                                    <td>A4</td>
                                    @endif
                                    </p>
                                    <p><strong>Type of paper:</strong>@if($request->paper_type == 0)
                                        <td>Draft Copy</td>
                                    @elseif($request->paper_type == 1)
                                        <td>Normal</td>
                                    @else
                                        <td>Photographic Paper</td>
                                        @endif
                                        </p>
                                        <p><strong>File URL:</strong><a
                                                    href="{{ $request->file }}">{{ $request->file }}</a></p>
                                        <p><strong>Status of Print:</strong> @if($request->status == 2)
                                            <td>Expired</td>
                                        @elseif($request->status == 1)
                                            <td>Printed</td>
                                        @else
                                            <td>Waiting</td>
                                            @endif
                                            </p>
        </div>
    </div>



@endsection