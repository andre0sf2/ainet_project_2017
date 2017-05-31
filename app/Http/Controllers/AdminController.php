<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Department;
use App\Printer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function showDashboard()
    {
        $blockedUsers = User::where('blocked', 1)->get();
        $comments = Comment::where('blocked', 1)->get();
        $requests = \App\Request::where('status', 0)->where('due_date', '>=', Carbon::now())->get();

        $departments = Department::all();


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

    public function acceptView($id)
    {
        $departments = Department::all();
        $printers = Printer::all();

        $request = \App\Request::findOrFail($id);

        return view('admin.acceptRequest', compact('departments', 'request', 'printers'));
    }

    public function refuseView($id)
    {
        $departments = Department::all();

        $request = \App\Request::findOrFail($id);

        return view('admin.refusedRequest', compact('departments', 'request'));

    }

    public function acceptRequest(Request $request)
    {
        $this->validate($request, [
            'printer' => 'required|not-in:0'
        ]);

        \App\Request::where('id', $request->input('request_id'))->update([
            'printer_id' => $request->input('printer'),
            'status' => 2,
            'closed_date' => Carbon::now(),
            'closed_user_id' => Auth::user()->id
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Request Nº '.$request->input('request_id').' accepted with success');
    }

    public function refuseRequest(Request $request)
    {
        $this->validate($request, [
            'refused_reason' => 'required|string|max:255'
        ]);

        \App\Request::where('id', $request->input('request_id'))->update([
            'refused_reason' => $request->input('refused_reason'),
            'status' => 1,
            'closed_date' => Carbon::now(),
            'closed_user_id' => Auth::user()->id
        ]);

        return redirect()->route('admin.dashboard')->with('errors', ['Request Nº '.$request->input('request_id').' refused with success']);
    }
}
