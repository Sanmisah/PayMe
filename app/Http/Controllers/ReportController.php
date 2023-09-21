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
          
            $condition = [];
            $conditions = [];
            if(isset($request->agent_id)){
                $conditions['agent_id'] = $request->agent_id;
            }
            if(isset($request->account_id)){
                $conditions['account_id'] = $request->account_id;
            }
            if(isset($request->from)){
                $fromDate = Carbon::createFromFormat('d/m/Y', $request->from);
                $condition[] = ['loan_date', '>=' , $fromDate];
            }

            if(isset($request->to_date)){
                $toDate = Carbon::createFromFormat('d/m/Y', $request->to_date);
                $condition[] = ['loan_date', '<=' , $toDate];
            }
    
    
    
          
           
           
    
            $loans = Loan::where($condition)
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
        $condition = [];

                 
        if(isset($request->from_date)){
            $fromDate = Carbon::createFromFormat('d/m/Y', $request->from_date);
            $condition[] = ['payment_date', '>=' , $fromDate];
        }

        if(isset($request->to_date)){
            $toDate = Carbon::createFromFormat('d/m/Y', $request->to_date);
            $condition[] = ['payment_date', '<=' , $toDate];
        }
       

        $collections = Collection::where($condition)->with(['LoanRepayment'=>['Loan'=>['Agent', 'Account'=>['Area']]]])->get();

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


    
            
           
    
            $repayment = LoanRepayment::whereDate('payment_date', '<=' , $date)
                                            ->whereColumn('interest_amount', '>','paid_amount')
                                            ->with(['Loan'=>['Agent', 'Account'=>['Area']]])                                            
                                            ->whereRelation('Loan', $conditions)->get();


            $repayments = $repayment->sortBy('Loan.agent_id');

            $data = [];
            $dt = Carbon::now();

            foreach($repayments as $record){
                if(!isset($data[$record->loan->agent_id]['agent_name'] )){
                    $data[$record->loan->agent_id]['agent_name'] = $record->loan->Agent->first_name;
                    
                } 
                if(!isset($data[$record->loan->agent_id][$record->loan_id]['acount_no'])){
                    $data[$record->loan->agent_id][$record->loan_id]['account_no'] = $record->loan->account->account_no;
                    $data[$record->loan->agent_id][$record->loan_id]['day'] = $record->loan->emi_day;
                    $data[$record->loan->agent_id][$record->loan_id]['name'] = $record->loan->account->name;
                    $data[$record->loan->agent_id][$record->loan_id]['address'] = $record->loan->account->address;                    
                } 
                $dates = Carbon::createFromFormat('d/m/Y', $record->payment_date);
                if(!isset($data[$record->loan->agent_id][$record->loan_id]['last'])){
                    $data[$record->loan->agent_id][$record->loan_id]['last'] = 0;
                }
                if(!isset($data[$record->loan->agent_id][$record->loan_id]['current'])){
                    $data[$record->loan->agent_id][$record->loan_id]['current'] = 0;
                }
                if($dt->isSameMonth($dates)){
                    $data[$record->loan->agent_id][$record->loan_id]['current'] += $record->interest_amount; 
                } else {
                    $data[$record->loan->agent_id][$record->loan_id]['last'] += $record->interest_amount; 

                }
               
               
            }

            
    
            $pdf = PDF::loadView('report.repayment_print', compact('data', 'date'));
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
