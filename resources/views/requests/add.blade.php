@extends('layouts.app')

@section('title', 'PrintIT! - Requests')

@section('content')

<div class="container">

    @if(session('success'))
        @include('partials.success')
    @endif

    @if(session('errors'))
        @include('partials.errors')
    @endif

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Print Request</strong></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('print.insert') }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description"
                                       value="{{old('description')}}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date" class="col-md-4 control-label">Date</label>
                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control" name="date"
                                       value="{{old('date')}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date_limit" class="col-md-4 control-label">Date Limit</label>

                            <div class="col-md-6">
                                <input id="date_limit" type="date" class="form-control" name="date_limit"
                                       value="{{old('date_limit')}}" required>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="number" class="col-md-4 control-label">Number of copys</label>

                            <div class="col-md-6">
                                <input id="number" type="number" class="form-control" name="number"
                                       value="{{ old('number') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="colorPrint" class="col-md-4 control-label">Color</label>

                            <div class="col-md-6">
                                <input hidden id="colors" name="colors" value="0">
                                <input id="colors" type="checkbox" class="radio-inline" name="colors" value="1" autofocus> Colored<br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="staples" class="col-md-4 control-label">Stapled</label>

                            <div class="col-md-6">
                                <input hidden id="stapled" name="stapled" value="0">
                                <input id="stapled" type="checkbox" class="radio-inline" name="stapled" value="1" autofocus> Stapled<br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paperSize" class="col-md-4 control-label">Paper Size</label>

                            <div class="col-md-6">
                                <input id="paper" type="radio" class="radio-inline" name="paperSize" value="a3" autofocus> A3<br>
                                <input id="paper" type="radio" class="radio-inline" name="paperSize" value="a4" autofocus> A4<br>
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <label for="presentation" class="col-md-4 control-label">Paper Type</label>

                            <div class="col-md-6">
                                <select name="paperType" id="paperType" class="form-control col-md-6">
                                    <option disabled selected> -- select an option --</option>
                                        <option value="">Draft Copy</option>
                                        <option value="">Normal</option>
                                        <option value="">Photographic paper</option>
                                </select>
                            </div>
                        </div>-->


                        <div class="form-group">
                            <label class="col-md-4 control-label" for="file">File</label>
                            <div class="col-md-6">
                                <input type="file" name="file" accept="file/*">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Accept
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    Cancel
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection