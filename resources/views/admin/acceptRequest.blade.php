@include('admin.partials.detailsRequest')

<div class="container">
    <form class="form-horizontal" role="form" action="{{ route('accept') }}" method="POST">
        <div class="form-group{{ $errors->has('printer') ? ' has-error' : '' }}">
            <label for="printer" class="col-md-4 control-label">Select a Printer</label>

            <div class="col-md-6">
                <select name="printer" id="printer" class="form-control col-md-6">
                    <option value="0" selected disabled>Select a Printer</option>
                    @foreach($printers as $printer)
                        <option value="{{$printer->id}}">{{$printer->name}}</option>
                    @endforeach>
                </select>
                @if ($errors->has('printer'))
                    <span class="help-block">
                    <strong>{{ $errors->first('printer') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
        <input hidden id="request_id" name="request_id" value="{{$request->id}}">
        {{ csrf_field() }}
    </form>
</div>

