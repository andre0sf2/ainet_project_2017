@extends('layouts.app')

@section('title', 'PrintIT! - Landing page')

@section('content')

<div class="container">

    @if(!is_null($message))
        <div class="alert alert-danger">
            {{ $message }}.
        </div>
    @endif

        <form class="form-group" method="POST" action="#">
            <div class="form-group" style="display: flex;">
                <input name="search" type="text" class="form-control" placeholder="Search for " style="width: 91%;"/>
                <button type="submit" class="btn btn-default" style="width:8%;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                </button>
            </div>
            {{csrf_field()}}
        </form>

</div>


@endsection