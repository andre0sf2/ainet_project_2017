@extends('layouts.app')

@section('title', 'Details!')

@section('content')
    <div class="container">

        @if(session('success'))
            @include('partials.success')
        @endif

        @if(session('errors'))
            @include('partials.errors')
        @endif

        <br>
        <div>
            <p><strong><h3>More details about Prints</h3></strong></p>
        </div>

        <div class="caption-full">
            <p><strong>Name:</strong> {{ $request->owner->name }}</p>
            <p><strong>Department:</strong> {{ $request->owner->department->name }}</p>

            <p><strong>Email:</strong> {{ $request->owner->email }}</p>
            @if(is_null($request->owner->phone))
                <p><strong>Phone Number:</strong>No phone number available</p>
            @else
                <p><strong>Phone Number:</strong>{{$request->owner->phone}}</p>
            @endif
            <p><strong>Date:</strong> {{ $request->due_date }}</p>
            <br>
            <h4><strong>Details about the request:</strong></h4>

            @if($request->colored == 0)
                <p><strong>Color:</strong> Black and White</p>
            @else
                <p>Colored</p>
            @endif

            @if($request->front_back == 0)
                <p><strong>Single Paged or Both Sides:</strong> Single paged</p>
            @else
                <p><strong>Single Paged or Both Sides:</strong> Printed on both sides</p>
            @endif

            @if($request->description == null)
                <p><strong>Description:</strong>No description</p>
            @else
                <p><strong>Description:</strong>{{$request->description}}</p>
            @endif

            @if($request->stapled == 0)
                <p><strong>Stapled:</strong> No</p>
            @else
                <p><strong>Stapled:</strong> Yes</p>
            @endif

            @if($request->paper_size == 3)
                <p><strong>Paper Size:</strong> A3</p>
            @else
                <p><strong>Paper Size:</strong> A4</p>
            @endif

            @if($request->paper_type == 0)
                <p><strong>Type of paper:</strong> Draft Copy</p>
            @elseif($request->paper_type == 1)
                <p><strong>Type of paper:</strong> Normal</p>
            @else
                <p><strong>Type of paper:</strong> Photographic Paper</p>
            @endif

            <p><strong>File URL:</strong><a href="{{ $request->file }}">{{ $request->file }}</a></p>

            @if($request->status == 2)
                <p><strong>Status of Print:</strong> Expired</p>
            @elseif($request->status == 1)
                <p><strong>Status of Print:</strong> Printed</p>
            @else
                <p><strong>Status of Print:</strong> Waiting</p>
            @endif

        </div>
    </div>
    <hr>
    <div class="container">
        <p><strong>Comments:</strong></p>
        @if(Auth::user())
            <form class="form-group" method="POST"
                  action="{{route('request.comment', $request->id)}}">
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <input type="hidden" name="request_id" value="{{$request->id}}">
                <div style="display: flex">
                    <input type="textarea" class="form-control" rows="5" name="comment">
                    <button type="submit" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-send"></i> Leave
                        a Comment
                    </button>
                </div>
                {{csrf_field()}}
            </form>
            <hr>
        @endif

        <div class="media">

            @foreach($comments as $comment)
                @if (is_null($comment->parent_id))
                    <a class="pull-left" href="{{ route('user.show', $comment->user_id) }}">
                        @if(is_null($comment->owner->profile_photo))
                            <img class="media-object" src="/uploads/avatars/default.png" alt="" style="width:64px; height:64px; top: 10px; left: 10px; border-radius: 50%;">
                        @else
                            <img class="media-object" src="data:image/jpeg;base64,{{ base64_encode(Storage::get('public/profiles/'.$comment->owner->profile_photo)) }}" alt="" style="width:64px; height:64px; top: 10px; left: 10px; border-radius: 50%;">
                        @endif
                    </a>

                    <div class="media-body">

                        <div class="thumbnail" style="background-color: white">
                            <p class="pull-right">({{ $comment->created_at }})</p>
                            <h4 class="media-heading"><a
                                        href="{{ route('user.show', $comment->user_id) }}">{{ $comment->owner->name }}</a>
                            </h4>
                            <hr>
                            <p>{{$comment->comment}}</p>

                            @if(Auth::user()->isAdmin())
                                <hr>
                                <div style="margin-left: 93%">
                                    <form method="POST" action="{{route('comment.block')}}">
                                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                        <input type="hidden" name="request_id" value="{{$request->id}}">
                                        <button type="submit" class="btn btn-danger" action="">Block
                                        </button>
                                        {{csrf_field()}}
                                    </form>
                                </div>
                            @endif
                        </div>


                        @if(Auth::user())
                            <form class="form-group" method="POST"
                                  action="{{route('request.subComment', $request->id)}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="request_id"
                                       value="{{$request->id}}">
                                <input type="hidden" name="parent_id" value="{{$comment->id}}">
                                <div style="display: flex">
                                    <input type="textarea" class="form-control" rows="5" name="comment">
                                    <button type="submit" class="btn btn-primary"><i
                                                class="glyphicon glyphicon-send"></i> Reply
                                    </button>
                                </div>
                                {{csrf_field()}}
                            </form>
                            <hr>
                        @endif
                        <div class="media">
                            @foreach ($comments as $c)
                                @if($c->parent_id == $comment->id)
                                    <a class="pull-left" href="{{ route('user.show', $c->user_id) }}">
                                        @if(is_null($c->owner->profile_photo))
                                            <img class="media-object" src="/uploads/avatars/default.png" alt="" style="width:64px; height:64px; top: 10px; left: 10px; border-radius: 50%;">
                                        @else
                                            <img class="media-object" src="data:image/jpeg;base64,{{ base64_encode(Storage::get('public/profiles/'.$c->owner->profile_photo)) }}" alt="" style="width:64px; height:64px; top: 10px; left: 10px; border-radius: 50%;">
                                        @endif
                                    </a>
                                    <div class="media-body">

                                        <div class="thumbnail" style="background-color: white">
                                            <p class="pull-right">({{ $c->created_at }})</p>
                                            <h4 class="media-heading"><a
                                                        href="{{ route('user.show', $c->user_id) }}">{{ $c->owner->name }}</a>
                                            </h4>
                                            <hr>
                                            <p>{{$c->comment}}</p>

                                            @if(Auth::user()->isAdmin())
                                                <hr>
                                                <div style="margin-left: 93%">
                                                    <form method="POST" action="{{route('comment.block')}}">
                                                        <input type="hidden" name="comment_id" value="{{$c->id}}">
                                                        <input type="hidden" name="request_id" value="{{$request->id}}">
                                                        <button type="submit" class="btn btn-danger" action="">Block
                                                        </button>
                                                        {{csrf_field()}}
                                                    </form>
                                                </div>
                                            @endif

                                        </div>

                                        @if(Auth::user())
                                            <form class="form-group" method="POST"
                                                  action="{{route('request.subComment', $request->id)}}">
                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                <input type="hidden" name="advertisement_id"
                                                       value="{{$request->id}}">
                                                <input type="hidden" name="parent_id" value="{{$comment->id}}">
                                                <div style="display: flex">
                                                    <input type="textarea" class="form-control" rows="5" name="comment">
                                                    <button type="submit" class="btn btn-primary"><i
                                                                class="glyphicon glyphicon-send"></i> Reply
                                                    </button>
                                                </div>
                                                {{csrf_field()}}
                                            </form>
                                            <hr>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <hr>
                @endif
            @endforeach
        </div>
    </div>




@endsection