<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Department;
use App\Resquest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function insertRequest(Request $request)
    {
        //dd($request->input());

        $this->validate($request, [
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'paper_type' => 'required|not_in:-1',
            'color' => 'required',
            'stapled' =>'required',
            'paper_size' => 'required',
            'file' => 'required'
        ]);

        $newRequest = new \App\Request($request->all());
        $newRequest->owner_id = Auth::user()->id;
        $newRequest->status = 0;
        //$newRequest->save();
        dd($newRequest);
        //return redirect()->route('request.view', $newRequest->id);
    }

    public function createRequest()
    {
        $departments = Department::all();

        return view('requests.add', compact('departments'));
    }

    public function listRequest()
    {

        $requests = \App\Request::query()->orderBy('created_at', 'ASC')->paginate(10);
        $departments = Department::all();

        return view('requests.list', compact('departments', 'requests'));
    }


    public function acceptRequest()
    {
        return redirect()->route('admin.dashboard')->with('success', 'Entrei Aqui!');
    }


    public function viewRequest($id)
    {
        $request = \App\Request::findOrFail($id);
        $departments = Department::all();
        $comments = $request->comment->where('blocked', 0);

        return view('requests.details', compact('request', 'departments', 'comments'));
    }

    public function refuseRequest()
    {
        return redirect()->route('admin.dashboard')->with('errors', ['Tambem entrei aqui']);

    }

}
