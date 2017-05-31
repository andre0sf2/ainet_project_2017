<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Department;
use App\Resquest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function insertRequest(Request $request)
    {
        $filesPath = 'print-jobs';

        $this->validate($request, [
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'paper_type' => 'required|not-in:-1',
            'paper_size' => 'required',
            'file' => 'required'
        ]);

        //Guardar ficheiro na Storage
        $file = $request->file('file');
        Storage::makeDirectory($filesPath.'/'.Auth::user()->id);
        $request->file('file')->store($filesPath.'/'.Auth::user()->id);


        //criar novo request
        $newRequest = new \App\Request($request->all());
        $newRequest->owner_id = Auth::user()->id;
        $newRequest->file = $file->hashName();
        $newRequest->status = 0;
        if(!$request->has('due_date')){
            $newRequest->due_date = Carbon::now()->addDay(30);
        }
        $newRequest->save();

        return redirect()->route('request.view', $newRequest->id);
    }

    public function createRequest()
    {
        $departments = Department::all();

        return view('requests.add', compact('departments'));
    }

    public function listRequest(Request $request)
    {
        $departments = Department::all();
        $search = $request->input('search');
        $status = $request->input('status');
        $create_date = $request->input('date');
        $due_date = $request->input('due_date');
        $dep = $request->input('department');

        $requests = \App\Request::where(function ($query) use ($request) {
            if ($request->has('status') && $request->input('status') != -1){
                $query->where('status', $request->input('status'))->get();
            }
            if ($request->has('create_date')){
                $query->whereDate('created_at', '=', Carbon::parse($request->input('create_date')))->get();
            }
            if ($request->has('due_date')){
                $query->whereDate('due_date', '=', Carbon::parse($request->input('due_date')))->get();
            }
            if($request->has('department') && $request->input('department') != -1){
                $query->whereIn('owner_id', User::where('department_id', $request->input('department'))->pluck('id')->toArray())->get();
            }
            if ($request->has('search')){
                $query->whereIn('owner_id', User::where('name', 'like', '%'.$request->input('search').'%')->pluck('id')->toArray())->get();
            }

        })->orderBy('created_at', 'desc')->paginate(10);

        return view('requests.list', compact('departments', 'requests', 'search', 'status', 'create_date', 'dep', 'due_date'));
    }


    public function viewRequest($id)
    {
        $request = \App\Request::findOrFail($id);
        $departments = Department::all();
        $comments = $request->comments->where('blocked', 0);

        return view('requests.details', compact('request', 'departments', 'comments'));
    }


    public function editRequest($id)
    {
        $departments = Department::all();
        $request = \App\Request::findOrFail($id);

        return view('requests.edit', compact('request', 'departments'));
    }

    public function updateRequest(Request $requestInput)
    {
        $filesPath = 'print-jobs';

        $request = \App\Request::findOrFail($requestInput->input('request_id'));
        $request->description = $requestInput->input('description');
        if($requestInput->has('due_date')){
            $request->due_date = $requestInput->input('due_date');
        }
        $request->quantity = $requestInput->input('quantity');
        $request->colored = $requestInput->input('colored');
        $request->stapled = $requestInput->input('stapled');
        $request->paper_size = $requestInput->input('paper_size');
        $request->paper_type = $requestInput->input('paper_type');
        if($requestInput->hasFile('file')){
            unlink(storage_path('app/'.$filesPath.'/'.$request->owner_id.'/'.$request->file));

            $file = $requestInput->file('file');
            Storage::makeDirectory($filesPath.'/'.Auth::user()->id);
            $requestInput->file('file')->store($filesPath.'/'.Auth::user()->id);
            $request->file = $file->hashName();
        }
        $request->save();

        return redirect()->route('request.view', $request->id);
    }

    public function destroy($id)
    {
        $filesPath = 'print-jobs';
        $request = \App\Request::findOrFail($id);

        unlink(storage_path('app/'.$filesPath.'/'.$request->owner_id.'/'.$request->file));

        $request->forceDelete();

        return redirect()->route('request.list')->with('success', 'Request number '.$id.' deleted with success');
    }

    public function userRequests(Request $request)
    {
        $departments = Department::all();

        $status = $request->input('status');
        $createdDate = $request->input('created_date');
        $dueDate = $request->input('due_date');

        $requests = \App\Request::where('owner_id', Auth::user()->id)->where(function ($query) use ($request){
            if ($request->has('status') && $request->input('status') != -1){
                $query->where('status', $request->input('status'))->get();
            }
            if ($request->has('created_date')){
                $query->whereDate('created_at', '=', Carbon::parse($request->input('created_date')))->get();
            }
            if ($request->has('due_date')){
                $query->whereDate('due_date', '=', Carbon::parse($request->input('due_date')))->get();
            }
        })->paginate(10);

        return view('requests.user', compact('departments', 'requests', 'status', 'dueDate', 'createdDate'));
    }

    public function rating(Request $request)
    {
        \App\Request::where('id', $request->input('request_id'))->update(['satisfaction_grade' => $request->input('satisfaction_grade')]);

        return redirect()->route('request.view', $request->input('request_id'));
    }
}
