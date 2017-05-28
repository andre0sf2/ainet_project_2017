@include('admin.partials.detailsRequest')

<div class="container">
    <form class="form-horizontal" role="form" action="{{ route('accept') }}" method="POST">
        <div style="display: flex">
            <select id="printer" name="printer" class="form-control">
                <option value="0" selected disabled>Select a Printer</option>
                @foreach($printers as $printer)
                    <option value="{{$printer->id}}">{{$printer->name}}</option>
                @endforeach
            </select>

            <button class="btn btn-success" type="submit">Save</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Cancel</a>
        </div>
        <input hidden id="request_id" name="request_id" value="{{$request->id}}">
        {{ csrf_field() }}
    </form>
</div>