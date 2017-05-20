<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Department;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function showDashboard($blockedUsers = null, $comments = null)
    {
        $blockedUsers = User::where('blocked', 1)->get();
        $comments = Comment::where('blocked', 1)->get();

        $departments = Department::all();
        $requests = \App\Request::where('status', 0)->where('due_date', '>=', Carbon::now())->get();

        return view('admin.dashboard',  compact( 'blockedUsers', 'comments', 'departments', 'requests'));
    }

    public function grantAdmin(Request $request)
    {

        User::where('id', $request->input('user_id'))->update(['admin' => 1]);

        $name = User::findOrFail($request->input('user_id'))->value('name');

        $message = ['success' => "User $name is now admin!"];

        return redirect()->route('users.list')->with($message);
    }

    public function revokeAdmin(Request $request)
    {
        User::where('id', $request->input('user_id'))->update(['admin' => 0]);

        $name = User::findOrFail($request->input('user_id'))->value('name');

        $message = ['errors' => "User $name is no longer admin!"];

        return redirect()->route('users.list')->with('errors', $message);
    }

    public function blockUser(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        if (!$user->isAdmin()) {
            User::where('id', $request->input('user_id'))->update(['blocked' => 1]);
        }

        return redirect()->route('users.list')->with('success', $user->name.' blocked with success.');
    }

    public function unblockUser(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        if (!$user->isAdmin()) {
            User::where('id', $request->input('user_id'))->update(['blocked' => 0]);
        }

        return redirect()->route('admin.dashboard')->with('success', $user->name.' unblocked with success.');
    }
}
