<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Account;
use App\Models\User;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class LoanController extends Controller
{
    
    public function index(Request $request)
    {
        $date = Carbon::now();
       
        if($request->all()){
            $conditions = [];
            if($request->search){
                $conditions[] = ['name', 'like', '%'.$request->search.'%'];
            }
            if($request->search_account){
                $conditions[] = ['account_no', 'like', '%'.$request->search_account.'%'];
            }
            if($request->search_mobile){
                $conditions[] = ['mobile_no', 'like', '%'.$request->search_mobile.'%'];
            }
            $accounts = Account::where($conditions)->with('Loan')->paginate(20);           
           
          
            return view('loans.index', compact('accounts'));
        }
        // $loans = Loan::with(['Agent', 'Account'])
        //                 ->with('LoanRepayments', function($q) use($date){
        //                     $q->where('payment_date', '<=', $date)
        //                         ->whereColumn('paid_amount', '<', 'interest_amount');
        //                 })->orderBy('id', 'desc')->paginate(20);

        $accounts = Account::with('Loan')->paginate(20);

        return view('loans.index', compact('accounts'));
    }

  
    public function create()
    {
        $accounts = Account::all();
        $agents = User::where(['role_id'=>2])->pluck('first_name', 'id');
        return view('loans.create')->with([
            'accounts' => $accounts,
            'agents' => $agents,
        ]);
    }

   
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'account_id'=>'required',
            'agent_id'=>'required',
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
        $loan->load(['Agent', 'Account']);
        return view('loans.edit')->with([
            'loan' => $loan,
        ]);
    }

   
    public function update(Request $request, Loan $loan)
    {
        $input = $request->all();

        if($loan->loan_amount != $input['loan_amount']){            
            $input['final_amount'] = $input['loan_amount'];
        }
        
        $interestAmount = $input['loan_amount']*$input['interest_rate']/100;

        
        $loanRepayments = LoanRepayment::where(['loan_id'=>$loan->id])->where('paid_amount',  0)->get();
        foreach($loanRepayments as $payment){
            $payment->interest_amount  = $interestAmount; 
            $date = Carbon::createFromFormat('d/m/Y', $payment->payment_date)->format('m/Y');   
            $payment->payment_date = $input['emi_day'].'/'.$date;
            $payment->save();
        }

        $loan->fill($input);
        $loan->update();
        

        //  $month = Carbon::createFromFormat('d/m/Y', $input['loan_date'])->format('m');
        // $year = Carbon::createFromFormat('d/m/Y', $input['loan_date'])->format('Y');

        // $date = $input['emi_day'].'/'.$month.'/'.$year;
        // $date = Carbon::createFromFormat('d/m/Y', $date);

       



       
      
        return redirect()->route('loans.index')->with(['success'=>'Record has been updated successfully']);
    }

   
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loans.index')->with(['success'=>'Record has been deleted successfully']); 
    }
}
