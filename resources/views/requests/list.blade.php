@extends('layouts.app')

@section('title', 'PrintIT! - Requests')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <form class="form-horizontal" role="form" action="{{ route('request.search') }}" method="GET">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="search">User Name</label>
                        <input placeholder="Search for..." class="form-control" type="text" name="search" id="search">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="date">Date Created</label>
                        <input class="form-control" type="date" name="date" id="date">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="-1">All Status</option>
                            <option value="0">Open</option>
                            <option value="1">Refused</option>
                            <option value="2">Completed</option>
                            <option value="3">Expired</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="owner">My Requests</label>
                        <input type="checkbox" id="owner" name="owner" value="0">
                    </div>
                </div>
                <button class="btn btn-default pull-right"><span class="glyphicon glyphicon-search"></span> Search</button>
            </form>
        </div>
    @if(count($requests))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->owner->name }}</td>
                        <td>{{ $request->statusToStr() }}</td>
                        <td>{{ $request->due_date }}</td>
                        <td class="col-md-6 inline" style="display: flex">
                            <div>
                                <a class="btn btn-xs btn-primary" href="{{route('request.view', $request->id)}}">View Request</a>
                            </div>

                            @if(Auth::user()->id == $request->owner_id && $request->status == 0)

                                <div>
                                    <a class="btn btn-xs btn-success" href="{{route('request.edit',$request->id) }}">Edit Request</a>
                                </div>
                            @endif
                            @if(Auth::user()->id == $request->owner_id && $request->status == 0)
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
                {{ $requests->links() }}
            </div>

    @else
        <h2>No Requests were found</h2>
    @endif
    </div>


@endsection