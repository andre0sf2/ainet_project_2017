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
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($requests as $request)
                    <tr>
                        <td>
                            {{ $request->owner->name }}
                        </td>

                        @if($request->colored)
                            <td>Colored</td>
                        @else
                            <td>Black and White</td>
                        @endif
                        <td>
                            {{ $request->created_at }}
                        </td>
                        <td>
                            {{ $request->due_date }}
                        </td>
                        <td class="col-md-3 inline">
                            @if (Auth::user() && Auth::user()->isAdmin())
                                <div class="col-md-3">
                                    <a href="{{ route('request.accept', $request->id) }}" class="btn btn-success">Accept</a>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-3">
                                        <a href="{{ route('request.refuse', $request->id) }}" class="btn btn-danger">Refuse</a>
                                    </div>
                                </div>
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