@extends('layouts.app')

@section('title', 'PrintIT! - Requests')

@section('content')
    <div class="container">
        <form class="form-group" method="GET" action="{{ route('request.search') }}">
            <div class="form-group" style="display: flex;">
                <input name="search" type="text" class="form-control" placeholder="Search for..." style="width: 97%;"/>
                <span class="input-group-btn"><button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button></span>
            </div>
            <div>
                <input type="checkbox" value="1" id="check" name="check"> My Requests
                <select id="status" name="status">
                    <option>------------</option>
                    <option value="0">Open</option>
                    <option value="1">Refuse</option>
                    <option value="2">Completed</option>
                    <option value="3">Expired</option>
                </select>
            </div>
            {{csrf_field()}}
        </form>
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