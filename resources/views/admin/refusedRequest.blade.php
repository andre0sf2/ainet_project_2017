@include('admin.partials.detailsRequest')

<div class="container">
    <form class="form-horizontal" role="form" action="{{ route('refuse') }}" method="POST">
        <textarea style="resize:none; width:100%;" id="refused_reason" name="refused_reason" type="text" rows="5" placeholder="Describe the reason here..."></textarea>
        <input hidden id="request_id" name="request_id" value="{{$request->id}}">
        <button class="btn btn-success" type="submit">Save</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Cancel</a>
        {{ csrf_field() }}
    </form>
</div>