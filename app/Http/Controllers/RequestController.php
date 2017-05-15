<?php

namespace App\Http\Controllers;

use App\Department;
use App\Resquest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function createRequest(){
        $departments = Department::all();

        return view('requests.add', compact('departments'));
    }

    public function listRequest(){

        $requests = \App\Request::query()->paginate(8);
        $departments = Department::all();

        return view('requests.list', compact('departments', 'requests'));
    }


    public function acceptRequest()
    {
        return redirect()->route('admin.dashboard')->with('success', 'Entrei Aqui CRLH!');
    }

    public function viewRequest($id)
    {
        $request = \App\Request::where('id', $id)->first();
        $departments = Department::all();

        return view('requests.details', compact('request', 'departments'));
    }
}
