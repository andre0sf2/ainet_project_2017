@extends('layouts.app')

@section('title', 'PrintIT! - Landing page')

@section('content')

    <div class="container">
        <h2><strong>Department: </strong> {{ $currentDepar->name }}</h2>

        <br>
        <div id="chart-div"></div>

        {!! $lava->render('PieChart', 'Prints', 'chart-div') !!}

        <br>

        <div class="row" style="display: inline">
            <div class="thumbnail col-md-6" style="background-color: white">
                <h4><strong>Total Prints: </strong> {{ $currentDepar->countPrints() }}</h4>
            </div>
            <div class="thumbnail col-md-6" style="background-color: white">
                <h4><strong>Today Prints: </strong>{{$todayPrint}}</h4>
            </div>
        </div>

        <h3>Média diária de impressões no mês atual</h3>
        <div id="perf_div"></div>

    </div>


@endsection