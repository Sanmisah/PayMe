<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use App\Models\Account;
use App\Models\Collection;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\File;


class ReportController extends Controller
{
   
    public function create()
    {
        $loans = Loan::all()->pluck('loan_no', 'id');
        return view('report.create')->with([
            'loans' => $loans
        ]);
    }

    public function edit(Request $request)
    {
        $input = $request->all();
        if($input){
            $request->validate([
                'from' => 'required',
                'to_date' => 'required',
            ]);
            $conditions = [];
            if(isset($request->agent_id)){
                $conditions['agent_id'] = $request->agent_id;
            }
            if(isset($request->account_id)){
                $conditions['account_id'] = $request->account_id;
            }
    
    
    
            $fromDate = Carbon::createFromFormat('d/m/Y', $request->from);
            $toDate = Carbon::createFromFormat('d/m/Y', $request->to_date);
           
    
            $loans = Loan::whereDate('loan_date', '>=' , $fromDate)
                            ->whereDate('loan_date', '<=' , $fromDate)
                            ->orWhereDate('loan_date', '<=' , $toDate)
                            ->where($conditions)->whereColumn('final_amount', '>','paid_amount')->with(['Agent', 'Account'=>['Area']])->get();

            $pdf = PDF::loadView('report.loan_print', compact('loans'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
    
            $path = public_path("reports/loan_report");
    
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
    
            $pdf->save($path . "/report.pdf");
    
            return response()->file($path . "/report.pdf");

        } else {
            $agents = User::where('role_id', 2)->get();
            $accounts = Account::all()->pluck('name', 'id');
            return view('report.edit')->with([
                'agents'=>$agents,
                'accounts'=>$accounts
            ]);
        }
    }

  
   
    public function report(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $fromDate = Carbon::createFromFormat('d/m/Y', $request->from_date);
        $toDate = Carbon::createFromFormat('d/m/Y', $request->to_date);
        $conditions = [];
        if(isset($request->loan_id)){
            $conditions['loan_id'] = $request->loan_id;
        }

        $collections = Collection::whereDate('payment_date', '>=' , $fromDate)
                                    ->whereDate('payment_date', '<=' , $fromDate)
                                    ->orWhereDate('payment_date', '<=' , $toDate)->with(['LoanRepayment'=>['Loan'=>['Agent', 'Account'=>['Area']]]])->get();

        $pdf = PDF::loadView('report.collection_print', compact('collections'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $path = public_path("reports/collections");

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $pdf->save($path . "/report.pdf");

        return response()->file($path . "/report.pdf");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loan(Request $request)
    {
        if($request->all()){

            $conditions = [];           
            if($request->to_date){
                $date = Carbon::createFromFormat('d/m/Y', $request->to_date);
            } else {
                $date = Carbon::now();
            }

            if($request->agent_id){
                $conditions['agent_id'] = $request->agent_id;
            }


    
            
           
    
            $repayments = LoanRepayment::whereDate('payment_date', '<=' , $date)
                                            ->whereColumn('interest_amount', '>','paid_amount')
                                            ->with(['Loan'=>['Agent', 'Account'=>['Area']]])
                                            ->whereRelation('Loan', $conditions)->get();
    
            $pdf = PDF::loadView('report.repayment_print', compact('repayments'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
    
            $path = public_path("reports/repayments");
    
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
    
            $pdf->save($path . "/report.pdf");
    
            return response()->file($path . "/report.pdf");

        } else {
            $agents = User::where('role_id', 2)->get();
            return view('report.add')->with([
                'agents' => $agents
            ]);
        }
    }

   



    
    public function receipt(Request $request)
    {
        $input = $request->all();
        if(!$input){
            return view('report');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
