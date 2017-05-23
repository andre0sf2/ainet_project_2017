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
                            <td>{{ $request->statusToStr() }}</td>
                            <td>{{ $request->due_date }}</td>
                            <td class="col-md-6 inline" style="display: flex">
                                <div>
                                    <a class="btn btn-xs btn-primary" href="{{route('request.view', $request->id)}}">View Request</a>
                                </div>
                                @if(Auth::user()->id == $request->owner_id)
                                    <div>
                                        <a class="btn btn-xs btn-success" href="#">Edit Request</a>
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
        </div>
    </div>


@endsection