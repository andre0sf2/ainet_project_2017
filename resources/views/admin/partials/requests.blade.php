<div class="row">
    <div class="col-md-12">
        @if(count($requests))
            <span class="help-block"></span>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Owner</th>
                    <th>Printer Name</th>
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
                        <td>
                            {{ $request->printer->name}}
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