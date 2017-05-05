<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        $message = null;

        $blackPrints = (count(\App\Request::where('colored', 0)->get())/count(\App\Request::all()))*100;
        $coloredPrints = (count(\App\Request::where('colored', 1)->get())/count(\App\Request::all()))*100;

        $allPrints = count(\App\Request::all());

        $requests = \App\Request::all();

        return view('index', compact('departments', 'message', 'blackPrints', 'coloredPrints', 'allPrints', 'requests'));
    }

    public function unauthorized()
    {
        $departments = Department::all();
        $message = 'You have been Blocked! Please contact the Administration';

        $blackPrints = (count(\App\Request::where('colored', 0)->get())/count(\App\Request::all()))*100;
        $coloredPrints = (count(\App\Request::where('colored', 1)->get())/count(\App\Request::all()))*100;

        return view('index', compact('departments', 'message', 'blackPrints', 'coloredPrints'));
    }

    public function login()
    {
        $departments = Department::all();

        return view('auth.login', compact('departments'));
    }

    public function register()
    {
        $departments = Department::all();

        return view('auth.register', compact('departments'));
    }

    public function passwordReset()
    {
        $departments = Department::all();
        $token = "";

        return view('auth.passwords.reset', compact('departments', 'token'));
    }

    public function emailPassword()
    {
        $departments = Department::all();
        $token = "";

        return view('auth.passwords.email', compact('departments', 'token'));
    }

    public function about()
    {
        $departments = Department::all();

        return view('about', compact('departments'));
    }
}
