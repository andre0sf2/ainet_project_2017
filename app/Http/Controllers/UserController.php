<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function updateUser(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));

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

    public function editUser($id)
    {
        $departments = Department::all();
        $user = User::findOrFail($id);
        if (Auth::user()->id == $user->id) {

            return view('users.edit', compact('user', 'departments'));
        }
        return redirect()->route('index');
    }

    public function activeUser($token)
    {
        dd(Password::all());

        return redirect()->route('index')->with('success', 'Your account is now active, You can login.');
    }
}
