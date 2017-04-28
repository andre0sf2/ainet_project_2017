<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    function __construct()
    {

    }

    public function showUser($id)
    {
        $user = User::where('id', $id)->first();
        $userDepartment = Department::where('id', $user->department_id)->first();
        $departments = Department::all();

        return view('users.profile', array('user'=>$user, 'userDepartment'=> $userDepartment, 'departments' => $departments));
    }

    public function updateUser(Request $request)
    {
        $user = User::where('id', $request->input('user_id'))->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if($request->hasFile('avatar')){
            if($user->profile_photo != 'default.png'){
                unlink('uploads/avatars/' . $user->profile_photo);
            }

            $avatar = $request->file('avatar');
            $filename = str_replace(' ', '', $user->name).time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('uploads/avatars/'.$filename));

            $user->profile_photo = $filename;
        }

        $user->save();

        return redirect()->route('user.show', $user->id);
    }

    public function listUsers()
    {
        $users = User::where('blocked', 0)->get();
        $departments = Department::all();

        return view('users.list', compact('users', 'departments'));
    }

    public function blockUser(Request $request)
    {
        $user = User::where('id', $request->input('user_id'))->first();
        if (!$user->isAdmin()) {
            User::where('id', $request->input('user_id'))->update(['blocked' => 1]);
        }

        $message = ['message_success' => 'User blocked with success.'];

        return redirect()->route('users.list')->with($message);
    }

    public function unblockUser(Request $request)
    {
        $user = User::where('id', $request->input('user_id'))->first();
        if (!$user->isAdmin()) {
            User::where('id', $request->input('user_id'))->update(['blocked' => 0]);
        }

        $message = ['message_success' => 'User unblocked with success.'];

        return redirect()->route('admin.dashboard')->with($message);
    }

    public function editUser($id)
    {
        $departments = Department::all();
        $user = User::where('id', $id)->first();
        if (Auth::user()->id == $user->id) {

            return view('users.edit', compact('user', 'departments'));
        }
        return redirect()->route('home');
    }
}
