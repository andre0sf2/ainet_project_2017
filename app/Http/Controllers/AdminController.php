<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function showDashboard($blockedUsers = null, $comments = null)
    {
        $users = User::all();
        $blockedUsers = User::where('blocked', 1)->get();
        $comments = Comment::all();

        return view('admin.dashboard',  compact('users', 'blockedUsers', 'comments'));
    }
}
