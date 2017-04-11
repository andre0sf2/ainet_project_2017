<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    //
    public function showUser($id)
    {
        $user = User::where('id', $id)->first();
        $department = Department::where('id', $user->department_id)->first();

        return view('users.profile', array('user'=>$user, 'department'=> $department));
    }

    public function updateAvatar(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('uploads/avatars/'.$filename));

            $user = Auth::user();
            $user->profile_photo = $filename;

            $user->save();
        }

        return view('users.profile', array('user'=>Auth::user()));
    }
}
