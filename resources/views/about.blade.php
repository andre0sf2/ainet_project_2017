@extends('layouts.app')

@section('title', 'PrintIT!')

@section('content')
    <div class="container">
        <div class="thumbnail text-center">
            <h1>PrintIT!</h1>
            <h2>Polythecnic Institute of Leiria - School of Technology and Management</h2>
            <h4>Computer Engineering - 2nd Year 2nd Semester - Project for Web Applications course</h4>
        </div>
        <div class="thumbnail">
            <h3 class="text-center">Group  - PL</h3>
            <table class="table table-striped">
                <thead>
                <th>Name</th>
                <th>Student Number</th>
                <th>Year</th>
                <th>Regime</th>

                <thead>
                <tbody>
                <tr>
                    <td>André Alexandre Santos Figueirinha</td>
                    <td>2140283</td>
                    <td>3</td>
                    <td>Daytime</td>
                </tr>
                <tr>
                    <td>Miguel Narciso Ferreira</td>
                    <td>2140982</td>
                    <td>3</td>
                    <td>Daytime</td>
                </tr>
                <tr>
                    <td>Edgar João Cipriano De Azevedo</td>
                    <td>2130153</td>
                    <td>3</td>
                    <td>Daytime</td>
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