@extends('layouts.app')

@section('title', 'PrintIT! - Admin Dashboard')

@section('content')

<div class="container">

    @if(session('success'))
        @include('partials.success')
    @endif

    @if(session('errors'))
        @include('partials.errors')
    @endif

    <div class="row">
        <div class="container">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#Users" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Users</a>
                </li>
                <li><a href="#Comments" data-toggle="tab"><i class="glyphicon glyphicon-comment"></i> Comments</a>
                </li>
                <li><a href="#Requests" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Prints Requests</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="Users">@include('admin.partials.users')</div>
                <div class="tab-pane" id="Comments">@include('admin.partials.comments')</div>
                <div class="tab-pane" id="Requests">@include('admin.partials.requests')</div>
            </div>
        </div>
    </div>
</div>
@endsection