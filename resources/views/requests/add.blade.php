@extends('layouts.app')

@section('title', 'PrintIT! - Requests')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Print Request</strong></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('print.insert') }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description"
                                       value="{{old('description')}}" required autofocus>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="due_date" class="col-md-4 control-label">Date Limit</label>

                            <div class="col-md-6">
                                <input id="due_date" type="date" class="form-control" name="due_date"
                                       value="{{old('due_date')}}">

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                            <label for="quantity" class="col-md-4 control-label">Number of copys</label>

                            <div class="col-md-6">
                                <input id="quantity" type="number" class="form-control" name="quantity"
                                       value="{{ old('quantity') }}" required>
                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="colored" class="col-md-4 control-label">Color</label>

                            <div class="col-md-6">
                                <input id="colored" type="checkbox" class="radio-inline" name="colored" value="1" @if(old('colored')) checked @endif autofocus> Colored<br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="staples" class="col-md-4 control-label">Stapled</label>

                            <div class="col-md-6">
                                <input id="stapled" type="checkbox" class="radio-inline" name="stapled" value="1" @if(old('stapled')) checked @endif autofocus> Stapled<br>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('paper_size') ? ' has-error' : '' }}">
                            <label for="paper_size" class="col-md-4 control-label">Paper Size</label>

                            <div class="col-md-6">

                                <input id="paper_size" type="radio" class="radio-inline" name="paper_size" value="3" @if(old('paper_size')) checked @endif autofocus> A3<br>
                                <input id="paper_size" type="radio" class="radio-inline" name="paper_size" value="4" @if(old('paper_size')) checked @endif autofocus> A4<br>
                                @if ($errors->has('paper_size'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paper_size') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('paper_type') ? ' has-error' : '' }}">
                            <label for="presentation" class="col-md-4 control-label">Paper Type</label>

                            <div class="col-md-6">
                                <select name="paper_type" id="paper_type" class="form-control col-md-6">
                                    <option disabled selected> -- select an option --</option>
                                    @if(old('paper_type'))
                                        <option value="0" @if(old('paper_type') == 0) selected @endif>Draft Copy</option>
                                        <option value="1" @if(old('paper_type') == 1) selected @endif>Normal</option>
                                        <option value="2" @if(old('paper_type') == 2) selected @endif>Photographic Paper</option>
                                    @else
                                        <option value="0">Draft Copy</option>
                                        <option value="1">Normal</option>
                                        <option value="2">Photographic Paper</option>
                                    @endif
                                </select>

                                @if ($errors->has('paper_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paper_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="file">File</label>
                            <div class="col-md-6">
                                <input type="file" name="file" id="file" accept=".odt,application/msword,
                                    application/vnd.ms-excel, application/vnd.ms-powerpoint,
                                    text/plain, application/pdf, image/*"
                                >
                                <input type="hidden" name="_token" value="{{csrf_token()}}" required>
                                @if ($errors->has('file'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Accept
                                </button>
                                <a href="{{route('index')}}">
                                    <button type="button" class="btn btn-default" name="cancel">Cancel</button>
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection