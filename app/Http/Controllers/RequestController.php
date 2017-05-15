<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function createRequest(){
        $departments = Department::all();

        return view('requests.add', compact('departments'));
    }

    public function listRequest(){
        $departments = Department::all();

        $requests = \App\Request::all()->take(20);

        return view('requests.list', compact('departments', 'requests'));
    }


    public function acceptRequest()
    {
        return redirect()->route('admin.dashboard')->with('success', 'Entrei Aqui CRLH!');
    }

    public function refuseRequest()
    {
        return redirect()->route('admin.dashboard')->with('errors', ['Tambem entrei aqui']);
    }
}
