<?php

namespace App\Sanmisha;

use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Report
{
    public function generate($loan_repayment)
    {

        $pdf = PDF::loadView('loan_repayments.receipts', compact('loan_repayment'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

       

        $path = public_path("reports/collection/".$loan_repayment->id);

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $pdf->save($path . "/" . $loan_repayment->loan->name . ".pdf");
    }
}
