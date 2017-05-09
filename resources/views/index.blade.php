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

        <br>
        <div id="chart-div"></div>

        {!! $lava->render('PieChart', 'Prints', 'chart-div') !!}

        <br>

        <div class="row" style="display: inline">
            @foreach($departments as $department)
                <div class="col-md-6 thumbnail" style="background-color: white">
                    <h4><strong>Department: </strong> {{ $department->name }}</h4>
                    <p><strong>Total Prints: </strong> {{ $department->countPrints() }}</p>
                </div>
            @endforeach
        </div>
        <div class="row" style="display: inline">
            <div class="thumbnail" style="background-color: white">
                <h4><strong>All Prints: </strong>{{$allRequests}}</h4>
            </div>
        </div>

        <h3>Nº de impressões do dia de hoje</h3>
        <h3>Média diária de impressões no mês atual</h3>
        <h3>Outros dados estatísticos considerados relevantes</h3>

    </div>


@endsection