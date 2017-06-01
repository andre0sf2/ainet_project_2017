@extends('layouts.app')

@section('title', 'PrintIT! - Landing page')

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

        <br>
        <div id="chart-div"></div>

        {!! $lava->render('PieChart', 'Prints', 'chart-div') !!}

        <br>

        <div class="row" style="display: inline">
            @foreach($departments as $department)
                <div class="col-md-6 thumbnail" style="background-color: white">
                    <h4><strong>Department: </strong> <a href="{{ route('department.info', $department->id) }}">{{ $department->name }}</a></h4>
                    <p><strong>Total Prints: </strong> {{ $department->countPrints() }}</p>
                </div>
            @endforeach
        </div>
        <div class="row" style="display: inline;">
            <div class="thumbnail col-md-6" style="background-color: white">
                <h4><strong>All Prints: </strong>{{$allRequests}}</h4>
            </div>
            <div class="thumbnail col-md-6" style="background-color: white">
                <h4><strong>Today Prints: </strong>{{$todayPrint}}</h4>
            </div>
        </div>

        <h3>Prints of {{ date("F", mktime(0, 0, 0, \Carbon\Carbon::now()->month, 1)) }}</h3>
        <div id="perf_div"></div>

        {!! $lava->render('ColumnChart', 'PerDay', 'perf_div') !!}

    </div>


@endsection