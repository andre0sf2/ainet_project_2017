<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Department;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function showDashboard($blockedUsers = null, $comments = null)
    {
        $users = User::all();
        $blockedUsers = User::where('blocked', 1)->get();
        $comments = Comment::all();
        $departments = Department::all();

        return view('admin.dashboard',  compact('users', 'blockedUsers', 'comments', 'departments'));
    }

    public function grantAdmin(Request $request)
    {

        User::where('id', $request->input('user_id'))->update(['admin' => 1]);

        $name = User::where('id', $request->input('user_id'))->value('name');

        $message = ['message_success' => "User $name is now admin!"];

        return redirect()->route('users.list')->with($message);
    }

    public function revokeAdmin(Request $request)
    {
        User::where('id', $request->input('user_id'))->update(['admin' => 0]);

        $name = User::where('id', $request->input('user_id'))->value('name');

        $message = ['message_success' => "User $name is no longer admin!"];

        return redirect()->route('users.list')->with($message);
    }
}
