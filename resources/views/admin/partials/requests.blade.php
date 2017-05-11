<div class="row">
    <div class="col-md-12">
        @if(count($requests))
            <span class="help-block"></span>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Owner</th>
                    <th>Color Type</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($requests as $request)
                    <tr>
                        <td>
                            {{ $request->owner->name }}
                        </td>

                        @if($request->colored == 0)
                            <td>Black and White</td>
                        @else
                            <td>Colored</td>
                        @endif
                        <td>
                            {{ $request->created_at }}
                        </td>
                        <td class="col-md-2 inline">
                            @if (Auth::user() && Auth::user()->isAdmin())
                                <form action="{{ route('request.accept') }}" method="post">
                                    <input type="hidden" name="comment_id" value="{{$request->id}}">
                                    <button type="submit" class="btn btn-xs btn-success">Accept</button>
                                    {{csrf_field()}}
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @else
            <h2>No Blocked Comments Found</h2>
        @endif
    </div>
</div>