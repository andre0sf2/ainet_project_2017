@extends('layouts.app')

@section('title', 'PrintIT!')

@section('content')
    <div class="container">
        <div class="thumbnail text-center">
            <h1>PrintIT!</h1>
            <h2>Instituto Politécnico de Leiria</h2>
            <h4>Aplicações para a Internet</h4>
        </div>
        <div class="thumbnail">
            <h3 class="text-center">Grupo: 25 - Turno: PL2/PL5</h3>
            <table class="table table-striped">
                <thead>
                <th>Nome</th>
                <th>Número de Estudante</th>
                <th>Ano</th>
                <th>Regime</th>

                <thead>
                <tbody>
                <tr>
                    <td>André Alexandre Santos Figueirinha</td>
                    <td>2140283</td>
                    <td>3</td>
                    <td>Diurno</td>
                </tr>
                <tr>
                    <td>Miguel Narciso Ferreira</td>
                    <td>2140982</td>
                    <td>3</td>
                    <td>Diurno</td>
                </tr>
                <tr>
                    <td>Edgar João Cipriano De Azevedo</td>
                    <td>2130153</td>
                    <td>3</td>
                    <td>Diurno</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pull-right">
            <a href="{{url('/')}}">
                <button class="btn btn-primary">Back</button>
            </a>
        </div>
    </div>
@endsection