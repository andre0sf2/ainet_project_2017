@extends('layouts.app')

@section('title', 'PrintIT! - Landing page')

@section('content')

<div class="container">

    @if(!is_null($message))
        <p>{{ $message }}</p>
    @endif

    <h1>Cenas para meter aqui</h1>

</div>


@endsection