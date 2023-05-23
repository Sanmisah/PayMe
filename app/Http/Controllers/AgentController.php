<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
   
    public function index()
    {
        $agents = Agent::paginate(10);
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
            'name' => 'required',
            'mobile_no' => 'required|numeric|digits:10',
            'alternative_no' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        Agent::create($input);
        return redirect()->route('agents.index')->with(['success', 'The Agent has been saved successfully']);

    }

   
    public function show(Agent $agent)
    {
        //
    }

   
    public function edit(Agent $agent)
    {
        return view('agents.edit')->with([
            'agent'=>$agent
        ]);
    }

  
    public function update(Request $request, Agent $agent)
    {
        $input = $request->all();
        $request->validate([
            'name' => 'required',
            'mobile_no' => 'required|numeric|digits:10',
            'alternative_no' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $agent->update($input);
        return redirect()->route('agents.index')->with(['success', 'The Agent has been updated successfully']);
    }

  
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')->with(['success', 'The Agent has been deleted successfully']);
    }
}
