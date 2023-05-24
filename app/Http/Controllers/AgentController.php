<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AgentController extends Controller
{
   
    public function index()
    {
        $agents = User::where(['role_id'=>2])->paginate(10);
        return view('agents.index', compact('agents'));
    }

   
    public function create()
    {
        return view('agents.create');
    }

   
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'alternative_no' => 'numeric|digits:10',
            'password' => 'required',
        ]);

        $input['password'] = Hash::make($input['password']);
        $input['role_id'] = 2;
        User::create($input);
        return redirect()->route('agents.index')->with(['success', 'The Agent has been saved successfully']);

    }

   
    public function show(User $agent)
    {
        //
    }

   
    public function edit(User $agent)
    {
        return view('agents.edit')->with([
            'agent'=>$agent
        ]);
    }

  
    public function update(Request $request, User $agent)
    {
        $input = $request->all();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|numeric|digits:10',
            'alternative_no' => 'numeric|digits:10',
            'email' => 'required|email',
        ]);

        $agent->update($input);
        return redirect()->route('agents.index')->with(['success', 'The Agent has been updated successfully']);
    }

  
    public function destroy(User $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')->with(['success', 'The Agent has been deleted successfully']);
    }
}
