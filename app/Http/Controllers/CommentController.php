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
}
