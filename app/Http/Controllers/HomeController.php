<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;

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

        $lava = new Lavacharts();
        $reasons = $lava->DataTable();

        $reasons->addStringColumn('Reasons')
            ->addNumberColumn('Percent')
            ->addRow(['Black & White', count(\App\Request::where('colored', 0)->get())])
            ->addRow(['Colored', count(\App\Request::where('colored', 1)->get())]);

        $lava->PieChart('Prints', $reasons, [
            'title'  => 'Colored vs Black & White',
            'is3D'   => true,
        ]);


        return view('index', compact('departments', 'lava'));
    }

    public function unauthorized()
    {
        return redirect()->route('index')->with('errors', ['errors' => 'You are currently blocked. Try again later.']);
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
