@extends('layouts.app')

@section('title', 'PrintIT! - My Requests')

@section('content')
    <div class="container">


        @if(session('success'))
            @include('partials.success')
        @endif

        @if(session('errors'))
            @include('partials.errors')
        @endif

        @if(session('warning'))
            @include('partials.warning')
        @endif


        <div class="jumbotron">
            <form class="form-horizontal" role="form" action="{{ route('request.user') }}" method="GET">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="-1">All Status</option>
                            <option value="0" @if(isset($status) && $status == 0) selected @endif>Open</option>
                            <option value="1" @if(isset($status) && $status == 1) selected @endif>Refused</option>
                            <option value="2" @if(isset($status) && $status == 2) selected @endif>Completed</option>
                            <option value="3" @if(isset($status) && $status == 3) selected @endif>Expired</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="created_date">Date Created</label>
                        <input class="form-control" type="date" name="created_date" id="created_date" value="{{ isset($createdDate)?$createdDate:'' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="due_date">Due Date</label>
                        <input class="form-control" type="date" name="due_date" id="due_date" value="{{ isset($dueDate)?$dueDate:'' }}">
                    </div>
                </div>
                <button class="btn btn-default pull-right"><span class="glyphicon glyphicon-search"></span> Search</button>
            </form>
        </div>
        @if(count($requests))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th>Due Date</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr>
                        @if(is_null($request->description))
                            <td>No Description</td>
                        @else
                            <td>{{ $request->description }}</td>
                        @endif
                        <td>{{ $request->statusToStr() }}</td>
                        <td>{{ $request->created_at }}</td>
                        <td>{{ $request->due_date }}</td>
                        <td class="col-md-6 inline" style="display: flex">
                            <div>
                                <a class="btn btn-xs btn-primary" href="{{route('request.view', $request->id)}}">View Request</a>
                            </div>

                            @if(Auth::user()->id == $request->owner_id && $request->status == 0)

                                <div>
                                    <a class="btn btn-xs btn-success" href="{{route('request.edit',$request->id) }}">Edit Request</a>
                                </div>

                                <div>
                                    <form action="{{ route('request.delete', $request->id) }}" method="post">
                                        {{ method_field('delete') }}
                                        <input type="hidden" name="request_id" value="{{$request->id}}">
                                        <button type="submit" class="btn btn-xs btn-danger">Delete Request</button>
                                        {{csrf_field()}}
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div style="text-align: center">
                {{ $requests->appends(['status' => $status, 'created_date'=>$createdDate, 'due_date'=>$dueDate])->links() }}
            </div>

        @else
            <h2>No Requests were found</h2>
        @endif
    </div>


@endsection