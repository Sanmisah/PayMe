<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
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
                                    ->orWhereDate('payment_date', '<=' , $toDate)
                                    ->where($conditions)->get()->load(['LoanRepayments'=>['Loan']]);

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
        $input = $request->all();
        if($input){
            $request->validate([
                'to_date' => 'required',
            ]);
    
            $toDate = Carbon::createFromFormat('d/m/Y', $request->to_date);
           
    
            $repayments = LoanRepayment::whereDate('payment_date', '<=' , $toDate)
                                            ->where('interest_amount', '>','paid_amount')->get()->load('Loan');
    
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
            return view('report.add');
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
