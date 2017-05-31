@include('admin.partials.detailsRequest')

<div class="container">
    <form class="form-horizontal" role="form" action="{{ route('refuse') }}" method="POST">
        <div class="form-group{{ $errors->has('refused_reason') ? ' has-error' : '' }}">
            <label for="refused_reason" class="col-md-4 control-label">Refuse Reason</label>

            <div class="col-md-6">
                <textarea style="resize:none; width:100%;" id="refused_reason" name="refused_reason" type="text" rows="5" placeholder="Describe the reason here..."></textarea>

                @if ($errors->has('refused_reason'))
                    <span class="help-block">
                        <strong>{{ $errors->first('refused_reason') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <input hidden id="request_id" name="request_id" value="{{$request->id}}">
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
        {{ csrf_field() }}
    </form>
</div>