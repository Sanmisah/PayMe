<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Area;
use App\Models\Agent;

class LoanController extends Controller
{
    
    public function index()
    {
        $loans = Loan::paginate(20);
        return view('loans.index', compact('loans'));
    }

  
    public function create()
    {
        $areas = Area::all()->pluck('area', 'id');
        $agents = Agent::all()->pluck('name', 'id');
        return view('loans.create')->with([
            'areas' => $areas,
            'agents' => $agents
        ]);
    }

   
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'name'=>'required',
            'mobile_no'=>'required|numeric|digits:10',
            'alternative_no'=>'required|numeric|digits:10',
            'contact_person'=>'required',
            'contact_person_no'=>'required',
            'area_id'=>'required',
            'agent_id'=>'required',

        ]);


        Loan::create($input);
        return redirect()->route('loans.index')->with(['success'=>'Record has been saved successfully']);
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit(Loan $loan)
    {
        $areas = Area::all()->pluck(['area', 'id']);
        $agents = Agent::all()->pluck(['name', 'id']);
        return view('loans.edit')->with([
            'loan' => $loan,
            'areas' => $areas,
            'agents' => $agents
        ]);
    }

   
    public function update(Request $request, Loan $loan)
    {
        $input = $request->all();
        $request->validate([
            'name'=>'required',
            'mobile_no'=>'required',
            'alternative_no'=>'required',
            'address'=>'required',
            'contact_person'=>'required',
            'contact_person_no'=>'required',
        ]);

        $loan->update($input);
        return redirect()->route('loans.index')->with(['success'=>'Record has been updated successfully']);
    }

   
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loans.index')->with(['success'=>'Record has been deleted successfully']); 
    }
}
