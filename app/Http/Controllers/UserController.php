<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    function __construct()
    {

    }

    public function showUser($id)
    {
        $user = User::where('id', $id)->first();
        $departments = Department::all();

        $file = Storage::get('public/profiles/'.$user->profile_photo);

        return view('users.profile', compact('user', 'departments', 'file'));
    }

    public function updateUser(Request $request)
    {
        $user = User::where('id', $request->input('user_id'))->first();

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,id,'.$user->id,
            'phone' => 'required|min:9|max:255',
            'presentation' => 'max:255',
            'profile_url' => 'max:255',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->department_id = $request->input('department');
        $user->presentation = $request->input('presentation');
        $user->profile_url = $request->input('profile_url');

        if ($request->has('password')){
            $this->validate($request, [
                'password' => 'min:8|confirmed',
            ]);

            $user->password = bcrypt($request->input('password'));
        }

        if($request->hasFile('avatar')){
            if(!is_null($user->profile_photo)){
                unlink(storage_path('app/public/profiles/' . $user->profile_photo));
            }

            $avatar = $request->file('avatar');
            $filename = str_replace(' ', '', $user->name).time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(storage_path('app/public/profiles/'.$filename));

            $user->profile_photo = $filename;
        }

        $user->save();

        return redirect()->route('user.show', $user->id);
    }

    public function listUsers()
    {
        $users = User::where('blocked', 0)->orderBy('name')->paginate(10);
        $departments = Department::all();

        return view('users.list', compact('users', 'departments'));
    }

    public function blockUser(Request $request)
    {
        $user = User::where('id', $request->input('user_id'))->first();
        if (!$user->isAdmin()) {
            User::where('id', $request->input('user_id'))->update(['blocked' => 1]);
        }

        $message = ['success' => 'User blocked with success.'];

        return redirect()->route('users.list')->with($message);
    }

    public function unblockUser(Request $request)
    {
        $user = User::where('id', $request->input('user_id'))->first();
        if (!$user->isAdmin()) {
            User::where('id', $request->input('user_id'))->update(['blocked' => 0]);
        }

        $message = ['success' => 'User unblocked with success.'];

        return redirect()->route('admin.dashboard')->with($message);
    }

    public function editUser($id)
    {
        $departments = Department::all();
        $user = User::where('id', $id)->first();
        if (Auth::user()->id == $user->id) {

            return view('users.edit', compact('user', 'departments'));
        }
        return redirect()->route('index');
    }
}
