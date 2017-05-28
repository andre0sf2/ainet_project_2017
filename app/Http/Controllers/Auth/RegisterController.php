<?php

namespace App\Http\Controllers\Auth;

use App\PasswordResets;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    private $user;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected function redirectTo()
    {
        if (!$this->user->isActivated()){
            Auth::logout();
            return route('ativated');
        }

        return '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|min:9|max:254',
            'department' => 'required|not_in:0',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $filename = null;
        $profileUrl = null;
        $presentation = null;

        $token = str_random(30);

        if(array_key_exists('avatar', $data)) {
            $avatar = $data['avatar'];
            $filename = str_replace(' ', '', $data['name']).time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(storage_path('app/public/profiles/'.$filename));
        }

        if(array_key_exists('presentation', $data)){
            Validator::validate($data, [
                'presentation' => 'max:255'
            ]);
            $presentation = $data['presentation'];
        }

        if(array_key_exists('profile_url', $data)){
            Validator::validate($data, [
                'profile_url' => 'max:255',
            ]);
            $profileUrl = $data['profile_url'];
        }

        $this->user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'profile_photo' => $filename,
            'department_id' => $data['department'],
            'presentation' => $presentation,
            'profile_url' => $profileUrl,
        ]);

        PasswordResets::insert([
            'email' => $this->user->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('auth.email.verify', ['token' => $token, 'email' => $this->user->email], function($message) {
            $message->to($this->user->email, $this->user->name)
                ->subject('Verify your email address');
        });

        return $this->user;
    }
}
