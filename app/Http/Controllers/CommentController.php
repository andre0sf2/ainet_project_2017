<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function blockComment(Request $request)
    {

        Comment::where('id', $request->input('comment_id'))->update(['blocked' => 1]);

        return redirect()->route('product.show' . $request->input('advertisement_id'))->with('success', 'Comment blocked with success!');
    }

    public function unblockComment(Request $request)
    {

        Comment::where('id', $request->input('comment_id'))->update(['blocked' => 0]);

        return redirect()->route('admin.dashboard')->with('success', 'Comment unblocked with success!');
    }

    public function insertComment(Request $request)
    {
        $requestId = $request->input('request_id');

        if (strlen($request->input('comment')) > 1) {
            $comment = Comment::create($request->all());


            if (!$comment->save()) {
                return redirect()->route('request.view', $requestId)->with('errors', ['message_error' => 'Error inserting your comment. Please, try again!']);
            } else {
                return redirect()->route('request.view', $requestId)->with('success', 'Comment inserted with success!');
            }
        }

        return redirect()->route('request.view', $requestId)->with('errors', ['message_error' => 'You cannot insert an empty comment.']);
    }

    public function insertSubComment(Request $request)
    {
        $requestId = $request->input('request_id');

        if (strlen($request->input('comment')) > 1) {
            $newSubComment = Comment::create($request->all());
            $newSubComment->save();

            if (!$newSubComment->save()) {
                return redirect()->route('request.view', $requestId)->with('errors', ['message_error' => 'Error inserting your comment. Please, try again!']);
            } else {
                return redirect()->route('request.view', $requestId)->with('success', 'Comment inserted with success!');
            }
        }

        return redirect()->route('request.view', $requestId)->with('errors', ['message_error' => 'You cannot insert an empty comment.']);
    }
}
