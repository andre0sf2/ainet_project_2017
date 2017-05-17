@extends('layouts.app')

@section('title', 'PrintIT! - Requests')

@section('content')
    <div class="container">
            <form class="form-group" method="POST" action="#">
                <div class="form-group" style="display: flex;">
                    <input name="search" type="text" class="form-control" placeholder="Search for..." style="width: 97%;"/>
                    <span class="input-group-btn"><button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button></span>
                </div>
                {{csrf_field()}}
            </form>

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
                            @if($request->status == 2)
                                <td>Expired</td>
                            @elseif($request->status == 1)
                                <td>Printed</td>
                            @else
                                <td>Waiting</td>
                            @endif
                            <td>{{ $request->due_date }}</td>
                            <td class="col-md-3 inline">
                                <div class="col-md-2">
                                    <a class="btn btn-xs btn-primary" href="{{route('request.view', $request->id)}}">View Request</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        <div style="text-align: center">
            {{ $requests->links() }}
        </div>
        </div>
    </div>


@endsection