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
        $color = $lava->DataTable();

        $allRequests = count(\App\Request::where('status', 2)->get());

        $numBlackWhite = count(\App\Request::where('colored', 0)->where('status', 2)->get());
        $numColored = count(\App\Request::where('colored', 1)->where('status', 2)->get());

        $color->addStringColumn('Prints')
            ->addNumberColumn('Percent')
            ->addRow(['Black & White', $numBlackWhite])
            ->addRow(['Colored', $numColored]);

        $lava->PieChart('Prints', $color, [
            'title'  => 'Colored vs Black & White',
            'is3D'   => true,
        ]);

        $perDay = $lava->DataTable();

        $perDay->addDateColumn('Day of Month')
            ->addNumberColumn('Black & White')
            ->addNumberColumn('Colored');

        $requests = \App\Request::whereMonth('closed_date', '=', date('m'))->whereDay('closed_date', '<=', date('d'))->where('status', 2)->get()->groupBy(function($date) {
            return Carbon::parse($date->closed_date)->format('m-d');
        });

        foreach ($requests as $request){
            $contColor = 0;
            $contBlack = 0;
            $date = null;
            foreach ($request as $item){
                $date = Carbon::parse($item->closed_date)->toDateString();
                if($item->colored){
                    $contColor++;
                }else{
                    $contBlack++;
                }
            }
            $perDay->addRow([
                $date,
                $contBlack,
                $contColor
            ]);
        }

        $lava->ColumnChart('PerDay', $perDay, [
            'title' => 'Prints per Day',
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);

        $todayPrint = count(\App\Request::where('status', 2)->whereDate('closed_date', date('Y-m-d'))->get());


        return view('index', compact('departments', 'lava', 'allRequests', 'todayPrint'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all();

        return view('users.profile', compact('user', 'departments'));
    }

    public function listUsers(Request $request)
    {
        $search = $request->input('search');
        $deparInput = $request->input('department');
        $departments = Department::all();
        $users = User::where('blocked', 0)->where(function ($query) use ($request){
            if ($request->has('department') && $request->input('department') != -1){
                $query->where('department_id', '=', $request->input('department'))->get();
            }
            if ($request->has('search')){
                $query->where('name', 'like', '%'.$request->input('search').'%')
                    ->orWhere('email', 'like', '%'.$request->input('search').'%')
                    ->orWhere('phone', 'like', '%'.$request->input('search').'%')
                    ->get();
            }
        })->orderBy('name')->paginate(6);

        return view('users.list', compact('users', 'departments', 'search', 'deparInput'));
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
        return redirect()->route('index')->with('errors', ['errors' => 'You are currently blocked. Try again later.']);
    }

    public function ativated()
    {
        return redirect()->route('index')->with('warning', 'Thanks for signing up! Please check your email.!');
    }

    public function departementInfo($id)
    {
        $departments = Department::all();

        $currentDepar = Department::findOrFail($id);

        $lava = new Lavacharts();
        $color = $lava->DataTable();

        $contColor = 0;
        $contBlack = 0;
        $todayPrint = 0;

        foreach ($currentDepar->users as $user){
            foreach ($user->requests->where('status', 2) as $request){
                if ($request->colored){
                    $contColor++;
                }else{
                    $contBlack++;
                }

                if(Carbon::parse($request->closed_date)->toDateString() == date('Y-m-d')){
                    $todayPrint++;
                }
            }
        }

        $color->addStringColumn('Prints')
            ->addNumberColumn('Percent')
            ->addRow(['Black & White', $contBlack])
            ->addRow(['Colored', $contColor]);

        $lava->PieChart('Prints', $color, [
            'title'  => 'Colored vs Black & White',
            'is3D'   => true,
        ]);


        return view('departments.information', compact('departments', 'currentDepar', 'todayPrint', 'lava'));
    }
}
