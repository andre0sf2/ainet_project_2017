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
                <input name="search" type="text" class="form-control" placeholder="Search for..." style="width: 97%;"/>
                <span class="input-group-btn"><button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button></span>
            </div>
            {{csrf_field()}}
        </form>

        <br>
            <div id="chart-div"></div>

            {!! $lava->render('PieChart', 'Prints', 'chart-div') !!}
        <br>

        <div class="row" style="display: inline">
        @foreach($departments as $department)
            <div class="col-md-3 thumbnail" style="background-color: white">
                <h4><strong>Department: </strong> {{ $department->name }}</h4>
                <p><strong>Prints: </strong> {{ $department->countPrints() }}</p>
            </div>
        @endforeach
        </div>

        <h3>Nº de impressões do dia de hoje</h3>
        <h3>Média diária de impressões no mês atual</h3>
        <h3>Outros dados estatísticos considerados relevantes</h3>

    </div>


@endsection