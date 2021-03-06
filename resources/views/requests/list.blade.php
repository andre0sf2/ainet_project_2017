@extends('layouts.app')

@section('title', 'PrintIT! - Requests')

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
            @if(Auth::user()->isAdmin())
                <form class="form-horizontal" role="form" action="{{ route('request.list') }}" method="GET">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="search">User Name</label>
                            <input placeholder="Search for..." class="form-control" type="text" name="search" id="search" value="{{ isset($search)?$search:'' }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="department">Departments</label>
                            <select name="department" id="department" class="form-control">
                                <option value="-1">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @if(isset($dep) && $dep == $department->id) selected @endif>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="date">Date Created</label>
                            <input class="form-control" type="date" name="create_date" id="create_date" value="{{ isset($create_date)?$create_date:'' }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="date">Due Date</label>
                            <input class="form-control" type="date" name="due_date" id="due_date" value="{{ isset($due_date)?$due_date:'' }}">
                        </div>
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
                            <label for="type">Paper Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="-1">All Types</option>
                                <option value="0" @if(isset($type) && $type == 0) selected @endif>Draft</option>
                                <option value="1" @if(isset($type) && $type == 1) selected @endif>Normal</option>
                                <option value="2" @if(isset($type) && $type == 2) selected @endif>Photo</option>
                            </select>
                        </div>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
                    </div>
                </form>
            @endif
        </div>
    @if(count($requests))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th>Due Date</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td>
                            @if($request->paper_type == 2)
                                <img src="{{ asset('print-jobs/'.$request->owner->id.'/'.$request->file) }}"
                                     style="width: 30px; height:30px; border-radius: 50%; margin-right: 25px; float: left;" alt="Image">
                            @endif
                        </td>
                        <td><a href="{{route('user.show', $request->owner->id)}}">{{ $request->owner->name }}</a></td>
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
                {{ $requests->appends([
                'search' => $search,
                'status' => $status,
                'create_date' => $create_date,
                'department' => $dep,
                'due_date' => $due_date,
                'type' => $type
                ])->links() }}
            </div>

    @else
        <h2>No Requests were found</h2>
    @endif
    </div>


@endsection