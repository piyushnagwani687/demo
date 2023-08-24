<?php

namespace App\Http\Controllers;

use App\Http\Requests\clients\StoreRequest;
use App\Http\Requests\clients\UpdateRequest;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
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
            $users = User::with('client')->where('id', $auth->id)->get();
        }
        else
        {
            $users = User::with('client')->where('role', 'client')->get();
        }

        return view('clients.index', ['users' => $users]);
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

        return view('clients.create');
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
        $user->role = 'client';
        $user->save();

        $client = new Client();
        $client->user_id = $user->id;
        $client->address = $request->address;
        $client->notes = $request->notes;
        $client->city = $request->city;
        $client->save();

        return ['redirectUrl' => route('clients.index')];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $auth = Auth::user();

        if($auth->role == 'client')
        {
            abort(403);
        }

        $user = User::with('client')->findOrFail($id);
        return view('clients.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password != '')
        {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $client = Client::where('user_id', $user->id)->first();
        $client->city = $request->city;
        $client->address = $request->address;
        $client->notes = $request->notes;
        $client->save();

        return ['redirectUrl' => route('clients.index')];



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return ['redirectUrl' => route('clients.index')];
    }

    public function changeStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();
    }
    
}
