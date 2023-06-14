<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Account;
use App\Models\Area;
use App\Models\User;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CollectionController extends Controller
{
    
    public function index()
    {
        $loans = Loan::with(['Agent', 'Account'])->paginate(20);
        return view('loans.index', compact('loans'));
    }

  
    public function create()
    {
        $accounts = Account::all()->pluck('name', 'id');
        $areas = Area::all()->pluck('area', 'id');
        $agents = User::where(['role_id'=>2])->pluck('first_name', 'id');
        return view('loans.create')->with([
            'areas' => $areas,
            'accounts' => $accounts,
            'agents' => $agents,
        ]);
    }

   
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'account_id'=>'required',
            'area_id'=>'required',
            'loan_amount'=>'required|numeric',
            'interest_rate'=>'required|numeric',
            'loan_date'=>'required',
            'emi_day'=>'required|numeric',
            'period'=>'required|numeric',

        ]);

        $interestAmount = $input['loan_amount']*$input['interest_rate']/100;
        $input['final_amount'] = $input['loan_amount'];

        $month = Carbon::createFromFormat('d/m/Y', $input['loan_date'])->format('m');
        $year = Carbon::createFromFormat('d/m/Y', $input['loan_date'])->format('Y');

        $date = $input['emi_day'].'/'.$month.'/'.$year;
        $date = Carbon::createFromFormat('d/m/Y', $date);

        $loan = Loan::create($input);

        for($i = 1; $i<=$input['period']; $i++){
            $date = $date->addMonth(1);
            LoanRepayment::create([
                'loan_id' => $loan->id,
                'interest_amount' => $interestAmount,
                'payment_date' => $date->format('d/m/Y'),
            ]);              
        }


        return redirect()->route('loans.index')->with(['success'=>'Record has been saved successfully']);
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit(Loan $loan)
    {
        $areas = Area::all()->pluck('area', 'id');
        $agents = Agent::all()->pluck('name', 'id');
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
            'account_id'=>'required',
            'area_id'=>'required',
            'agent_id'=>'required',
            'loan_amount'=>'required|numeric',
            'interest_rate'=>'required|numeric',
            'loan_date'=>'required',
            'emi_day'=>'required|numeric',
            'period'=>'required|numeric',

        ]);

        $loan->load(['LoanRepayment']);


        $loan->name = $input['name'];
        $loan->mobile_no = $input['mobile_no'];
        $loan->alternative_no = $input['alternative_no'];
        $loan->area_id = $input['area_id'];
        $loan->agent_id = $input['agent_id'];
        $loan->contact_person = $input['contact_person'];
        $loan->contact_person_no = $input['contact_person_no'];
        $loan->loan_amount = $input['loan_amount'];
        $loan->interest_rate = $input['interest_rate'];
        $loan->loan_date = $input['loan_date'];
        $loan->emi_day = $input['emi_day'];
        $loan->period = $input['period'];
        if($input['address']){
            $loan->address = $input['address'];
        }
        if($input['email']){
            $loan->address = $input['email'];
        }
        if($input['contact_person_email']){
            $loan->address = $input['contact_person_email'];
        }



        $loanRepayments = [];
        $interestAmount = $input['loan_amount']*$input['interest_rate']/100;

        $month = Carbon::createFromFormat('d/m/Y', $input['loan_date'])->format('m');
        $year = Carbon::createFromFormat('d/m/Y', $input['loan_date'])->format('Y');

        $date = $year.'-'.$month.'-'.$input['emi_day'];
        $date = Carbon::createFromFormat('Y-m-d', $date);


        for($i = 1; $i<=$input['period']; $i++){
            $date = $date->addMonth(1);
            LoanRepayment::create([
                'loan_id' => $loan->id,
                'interest_amount' => $interestAmount,
                'payment_date' => $date,
            ]);              
        }

        $loan->save();

        return redirect()->route('loans.index')->with(['success'=>'Record has been updated successfully']);
    }

   
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loans.index')->with(['success'=>'Record has been deleted successfully']); 
    }
}
