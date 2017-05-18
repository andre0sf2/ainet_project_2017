<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Carbon\Carbon;
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

        $allRequests = count(\App\Request::all());

        $reasons->addStringColumn('Prints')
            ->addNumberColumn('Percent')
            ->addRow(['Black & White', count(\App\Request::where('colored', 0)->get())])
            ->addRow(['Colored', count(\App\Request::where('colored', 1)->get())]);

        $lava->PieChart('Prints', $reasons, [
            'title'  => 'Colored vs Black & White',
            'is3D'   => true,
        ]);

        $finances = $lava->DataTable();

        $finances->addDateColumn('Day of Month')
            ->addNumberColumn('Black & White')
            ->addNumberColumn('Colored');

        $requests = \App\Request::whereMonth('closed_date', '=', date('m'))->get();

        
        foreach ($requests as $request){
            $finances->addRow([
               $request->closed_date,
                count(\App\Request::whereMonth('closed_date', '=', date('m'))->whereDay('closed_date', '=', Carbon::parse($request->closed_date)->day)->where('colored', 0)->get()),
                count(\App\Request::whereMonth('closed_date', '=', date('m'))->whereDay('closed_date', '=', Carbon::parse($request->closed_date)->day)->where('colored', 1)->get())
            ]);
        }




        $lava->ColumnChart('Finances', $finances, [
            'title' => 'Prints per Month',
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);


        return view('index', compact('departments', 'lava', 'allRequests'));
    }

    public function unauthorized()
    {
        return redirect()->route('index')->with('errors', ['errors' => 'You are currently blocked. Try again later.']);
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all();

        return view('users.profile', compact('user', 'departments'));
    }

    public function listUsers()
    {
        $users = User::where('blocked', 0)->orderBy('name')->paginate(6);
        $departments = Department::all();

        return view('users.list', compact('users', 'departments'));
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
}
