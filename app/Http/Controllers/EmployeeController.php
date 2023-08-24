<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\employees\StoreRequest;
use App\Http\Requests\employees\UpdateRequest;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $auth = Auth::user();

        if($auth->role == 'client')
        {
            abort(403);
        }

        if($auth->role == 'employee')
        {
            $user  = User::with('employee')->where('id', $auth->id)->get();
        }
        elseif($auth->role == 'admin'){
            $user = User::with('employee')->where('role', 'employee')->get();
        }

        return view('employees.index', ['users' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auth = Auth::user();

        if($auth->role == 'client')
        {
            abort(403);
        }

        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'employee';
        $user->save();

        $employee = new Employee();
        $employee->phone_number = $request->phone_number;
        $employee->user_id = $user->id;
        $employee->save();

        return response()->json(['redirectUrl' => route('employees.index')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $auth = Auth::user();

        if($auth->role == 'client')
        {
            abort(403);
        }

        $user = User::findOrFail($id);
        return view('employees.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password != '') {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $employee = Employee::where('user_id', $user->id)->first();
        $employee->phone_number = $request->phone_number;
        $employee->save();

        return ['redirectUrl' => route('employees.index')];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return ['redirectUrl' => route('employees.index')];
    }

    public function changeStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();
    }

}
