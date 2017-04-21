<?php

namespace App\Http\Controllers;

use App\Department;
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

        return view('index', compact('departments', 'message'));
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

    public function about()
    {
        $departments = Department::all();

        return view('about', compact('departments'));
    }

    public function unauthorized()
    {
        $departments = Department::all();
        $message = 'You have been Blocked!';

        return view('index', compact('departments', 'message'));
    }
}
