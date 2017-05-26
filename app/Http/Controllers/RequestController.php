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
            'paper_type' => 'required|not_in:-1',
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
        $date = $request->input('date');

        $requests = \App\Request::where(function ($query) use ($request) {
            if ($request->has('status') && $request->input('status') != -1){
                $query->where('status', $request->input('status'))->get();
            }
            if ($request->has('date')){
                $query->whereDate('created_at', '=', Carbon::parse($request->input('date')))->get();
            }
            if ($request->has('search')){
                $users = User::where('name', 'like', '%'.$request->input('search').'%')->get();
                $array = array();
                foreach ($users as $user){
                    array_push($array, $user->id);
                }
                $query->whereIn('owner_id', $array)->get();
            }

        })->paginate(10);

        return view('requests.list', compact('departments', 'requests', 'search', 'status', 'date'));
    }


    public function acceptRequest()
    {
        return redirect()->route('admin.dashboard')->with('success', 'Entrei Aqui!');
    }


    public function viewRequest($id)
    {
        $request = \App\Request::findOrFail($id);
        $departments = Department::all();
        $comments = $request->comments->where('blocked', 0);

        return view('requests.details', compact('request', 'departments', 'comments'));
    }

    public function refuseRequest()
    {
        return redirect()->route('admin.dashboard')->with('errors', ['Tambem entrei aqui']);

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

        return redirect()->route('index')->with('success', 'Request number '.$id.' deleted with success');
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
}
