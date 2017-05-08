@extends('layouts.app')

@section('title', 'PrintIT! - Landing page')

@section('content')

    <div class="container">

        @if(!is_null($message))
            <div class="alert alert-danger">
                {{ $message }}.
            </div>
        @endif

        <br>
            <div id="chart-div"></div>

            {!! $lava->render('PieChart', 'Prints', 'chart-div') !!}
        <br>

        <div class="row" style="display: inline">
        @foreach($departments as $department)
            <div class="col-md-3 thumbnail" style="background-color: white">
                <h4><strong>Department: </strong> {{ $department->name }}</h4>
                <p><strong>Total Prints: </strong> {{ $department->countPrints() }}</p>
            </div>
        @endforeach
        </div>

        <h3>Nº de impressões do dia de hoje</h3>
        <h3>Média diária de impressões no mês atual</h3>
        <h3>Outros dados estatísticos considerados relevantes</h3>

    </div>


@endsection