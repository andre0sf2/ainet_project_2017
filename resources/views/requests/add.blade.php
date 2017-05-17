@extends('layouts.app')

@section('title', 'PrintIT! - Requests')

@section('content')

<div class="container">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('print.insert') }}"
          enctype="multipart/form-data">

        

    </form>
</div>

@endsection