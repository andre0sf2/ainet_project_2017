<div class="row">
    <div class="col-md-12">
        @if(count($blockedUsers))
            <span class="help-block"></span>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Email</th>
                    <th>Fullname</th>
                    <th>Registered At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($blockedUsers as $user)
                    <tr>
                        <td>{{$user->email}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->created_at}}</td>
                        <td class="col-md-2 inline">

                            @if (Auth::user() && Auth::user()->isAdmin())
                                <form action="{{route('user.unblock')}}" method="post">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-xs btn-danger">Unblock</button>
                                    {{csrf_field()}}
                                </form>

                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @else
            <h2>No Blocked Users Found</h2>
        @endif
    </div>
</div>