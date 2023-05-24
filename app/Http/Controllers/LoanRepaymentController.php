<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanRepayment;
use App\Models\Loan;
use Carbon\Carbon;


class LoanRepaymentController extends Controller
{
   
    public function index(Request $request)
    {
        $input = $request->all();
        if($input){
            $date = Carbon::createFromFormat('Y-m-d', $input['date']);
            $repayments = LoanRepayment::with('Loan')->whereDate('payment_date', '<=', $date)->whereColumn('interest_amount', '>','paid_amount')->paginate(10);
            return view('loan_repayments.index', compact('repayments'));

        } else {
            $repayments = LoanRepayment::with('Loan')->paginate(10);
            return view('loan_repayments.index', compact('repayments'));
        }
       
    }

   
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($loan_id)
    {
        $repayments = LoanRepayment::where(['loan_id'=>$loan_id])->get();
        return view('loan_repayments.show', compact('repayments'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanRepayment $loan_repayment)
    {
        $loan_repayment->load('Loan');
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

    public function collections($id)
    {
        $repayments = LoanRepayment::where(['loan_id'=>$loan_id])->get();
        return view('loan_repayments.show', compact('repayments'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
