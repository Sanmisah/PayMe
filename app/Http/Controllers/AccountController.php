<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Area;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    
    public function index()
    {
        $accounts = Account::with('Area')->orderBy('id', 'desc')->paginate(20);
        return view('accounts.index', compact('accounts'));
    }

  
    public function create()
    {
        
        $areas = Area::all()->pluck('area', 'id');
        return view('accounts.create')->with([
            'areas' => $areas
        ]);
    }

   
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'account_no'=>'required',
            'area_id'=>'required',
            'name'=>'required',
            'mobile_no'=>'required|numeric|digits:10',
            'contact_person'=>'required',
            'contact_person_no'=>'required|numeric|digits:10',

        ]);


        Account::create($input);

       
        return redirect()->route('accounts.index')->with(['success'=>'Record has been saved successfully']);
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit(Account $account)
    {
        $areas = Area::all()->pluck('area', 'id');
        return view('accounts.edit')->with([
            'areas' => $areas,
            'account' => $account
        ]);
    }

   
    public function update(Request $request, Account $account)
    {
        $input = $request->all();
        $request->validate([
            'account_no'=>'required',
            'name'=>'required',
            'mobile_no'=>'required|numeric|digits:10',
            'contact_person'=>'required',
            'contact_person_no'=>'required|numeric|digits:10',

        ]);

        $account->update($input);

        return redirect()->route('accounts.index')->with(['success'=>'Record has been updated successfully']);
    }

   
    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('accounts.index')->with(['success'=>'Record has been deleted successfully']); 
    }
}
