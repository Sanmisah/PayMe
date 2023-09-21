<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanRepayment;
use App\Models\Loan;
use App\Models\Account;
use App\Models\User;
use App\Models\Collection;
use Carbon\Carbon;
use App\Sanmisha\Report;


class LoanRepaymentController extends Controller
{
   
    public function index(Request $request)
    {

        $accounts = Account::all();
        $agents = User::where(['role_id'=>2])->get();
        $input = $request->all();
        if(!empty($input)){
            $condition = [];
            if($request->till_date){
                $date = Carbon::createFromFormat('d/m/Y', $request->till_date);
                $condition[] = ['payment_date', '<=', $date];
            }
            $conditions = [];
            if(!empty($input['account_id'])){
                $conditions['account_id'] = $input['account_id'];
            }

            if(!empty($input['agent_id'])){
                $conditions['agent_id'] = $input['agent_id'];
            }
            $repayments = LoanRepayment::where($condition)
                                        ->whereColumn('interest_amount', '>','paid_amount')
                                        ->with(['Loan'=>['Agent', 'Account'=>['Area']]])
                                        ->whereRelation('Loan', $conditions)->orderBy('payment_date', 'asc')->paginate(20);
            $repaymentArr = $repayments->pluck('id');

            return view('loan_repayments.index', compact('repayments'))->with([
                'accounts' => $accounts,
                'agents' => $agents,
                'repaymentArr' => implode( ',', $repaymentArr->toArray())
            ]);

        } 
        return view('loan_repayments.index')->with([
            'accounts' => $accounts,
            'agents' => $agents
        ]);
        
       
    }

   
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $details = $request->collect('Collection');
        foreach($details as $detail){
            if($detail['interest_received_amount']){
                Collection::create([
                    'payment_date' => date('d/m/Y'),
                    'payment_mode' => 'Cash',
                    'interest_received_amount' => $detail['interest_received_amount'],
                    'total_amount' => $detail['interest_received_amount'],
                    'loan_repayment_id' => $detail['loan_repayment_id']

                ]);
                $loan_repayment = LoanRepayment::where(['id'=>$detail['loan_repayment_id']])->first();
                $collection = Collection::where(['loan_repayment_id'=>$detail['loan_repayment_id']])->get();
                $amount = $collection->sum('interest_received_amount');
                $loan_repayment->paid_amount = $amount;
                $loan_repayment->save();
                $loan_repayment->with(['Loan'=>['Account', 'Agent'], 'Collection']);
                $report = new Report();
                $report->generate($loan_repayment);
                

            }
        }

        return redirect()->route('loan_repayments.index')->with('success', 'Loan Repayment has been Collected');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
       
        $accounts = Account::where('id', $id)->with(['Loan'=>['Agent', 'LoanRepayments']])->first();
        // $repayments = LoanRepayment::where(['loan_id'=>$loan_id])->orderBy('payment_date', 'asc')->paginate(20);
        return view('loan_repayments.show', compact('accounts'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanRepayment $loan_repayment)
    {
        $loan_repayment->load(['Loan'=>['Agent', 'Account']]);
        return view('loan_repayments.edit')->with([
            'loan_repayment' => $loan_repayment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanRepayment $loan_repayment)
    {

        $input = $request->all();
        if(!$loan_repayment->log){
            $data = [
                'old_date' => $loan_repayment->payment_date,
                'new_date' => $input['payment_date'],
            ];            
        } else {
            $data = [
                'old_record' => $loan_repayment->log,
                'old_date' => $loan_repayment->payment_date,
                'new_date' => $input['payment_date'],
            ];
        }
        
        $input['log'] = json_encode($data);

        $loan_repayment->update($input);
        return redirect()->route('loan_repayments.index')->with('success', 'Loan Repayment has been Postponed');
    }

    public function collections(LoanRepayment $loan_repayment)
    {
        $loan_repayment->load('Loan');
        $date = Carbon::createFromFormat('d/m/Y', $loan_repayment->payment_date);

        $loan_repayments = LoanRepayment::whereDate('payment_date', '<=', $date)
                                        ->where('loan_id', $loan_repayment->loan_id)
                                         ->whereColumn('paid_amount', '<', 'interest_amount')->get();
        $amount = $loan_repayments->sum('interest_amount') - $loan_repayments->sum('paid_amount');
        $collection = Collection::where(['loan_repayment_id'=>$loan_repayment->id])->get();
        $today = date('d/m/Y');

        return view('loan_repayments.collections')->with([
            'loan_repayment' => $loan_repayment,
            'loan_repayments' => $loan_repayments,
            'collection' => $collection,
            'date' => $loan_repayment->payment_date,
            'today'=> $today,
            'amount' => $amount
        ]);
        
    }

    public function collected(Request $request, $id)
    {
        $input = $request->all();
        $request->validate([
            'payment_date' => 'required',
            'interest_received_amount' => 'required|numeric',
            'payment_mode' => 'required',
        ]); 
        $date = Carbon::createFromFormat('d/m/Y', $request->date);
        $loan_repayments = LoanRepayment::whereDate('payment_date', '<=', $date)
                                         ->where('loan_id', $id)
                                         ->whereColumn('paid_amount', '<', 'interest_amount')->get();
                                         
        $totalAmount = $request->interest_received_amount;
        foreach($loan_repayments as $payments){
            if($totalAmount == 0){
                $loan_repayment = LoanRepayment::where(['id'=>$payments->id])->with(['Loan'=>['Account', 'Agent'], 'Collection'])->first();
                break;
            }
           
            $data = [];
            $payable = $payments->interest_amount - $payments->paid_amount;
            if($totalAmount > $payable){
                $amountInterest = $payable;
                $totalAmount -= $payable;
            } else {
                $amountInterest = $totalAmount;
                $totalAmount -= $amountInterest;
            }
            $data['total_amount'] = $amountInterest;

            if($loan_repayments->last() == $payments){               
                if($request->travelling_charges){
                    $data['travelling_charges'] = $request->travelling_charges;
                    $data['total_amount'] += $request->travelling_charges;
                }   
                if($totalAmount > 0){
                    $data['total_amount'] += $totalAmount;
                    $data['loan_received_amount'] = $totalAmount;

                }      
               
                
            } 
            
            $data['loan_repayment_id'] = $payments->id;
            $loan_id = $payments->loan_id;
            $data['payment_date'] = $request->payment_date;
            $data['interest_received_amount'] = $amountInterest;            
            $data['payment_mode'] = $request->payment_mode ? $request->payment_mode : 'Cash';
            $collect = Collection::create($data);
            $loan_repayment = LoanRepayment::where(['id'=>$payments->id])->with(['Loan'=>['Account', 'Agent'], 'Collection'])->first();
            $report = new Report();
            $report->generate($loan_repayment);

            $collection = Collection::where(['loan_repayment_id'=>$payments->id])->get();
            $amount = $collection->sum('interest_received_amount');
            
            $inputs['paid_amount'] = $amount;
            $loan_repayment->update($inputs);

        }
        if($totalAmount > 0){
            $loan = Loan::find($loan_id);
            $loan->paid_amount += $totalAmount;
            $loan->loan_amount -= $totalAmount;

            $loan->update();

            $interestAmount = $loan->loan_amount*$loan->interest_rate/100;
            $loanRepayments = LoanRepayment::where(['loan_id'=>$loan->id])->whereDate('payment_date', '>', $date)->get();
            foreach($loanRepayments as $repayment){
                $repayment->interest_amount = $interestAmount;
                $repayment->update();
            }

           
    

        }
       
       

        return redirect()->route('loan_repayments.show', ['loan_repayment'=>$loan_repayment->loan->account_id])->with('success', 'Loan Repayment has been Collected');


    }

   


    
    public function destroy($id)
    {
        //
    }
}
