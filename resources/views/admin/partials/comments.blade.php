<div class="row">
    <div class="col-md-12">
        @if(count($comments))
            <span class="help-block"></span>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Owner</th>
                    <th>Advertisement</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>
                            @foreach ($users as $user)
                                @if ($comment->user_id === $user->id)
                                    {{$user->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($requests as $request)
                                @if ($comment->request_id === $request->id)
                                    {{$request->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$comment->comment}}</td>
                        <td class="col-md-2 inline">

                            @if (Auth::user() && Auth::user()->isAdmin())
                                <form action="{{route('comment.unblock')}}" method="post">
                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
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
            <h2>No Blocked Comments Found</h2>
        @endif
    </div>
</div>