<?php 
use Carbon\Carbon;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&display=swap" rel="stylesheet">
        <title>Receipt</title>
        <style>
            @page {
                margin: 30px 35px;
                footer: html_myFooter;
            }
            body {
                font-family: 'EB Garamond', serif;
                font-size: 14px;
            }

            p.sign {
                font-family: Georgia,Times,Times New Roman,serif;
            }

            h3 {
                text-align: center;
                margin-bottom: 0;
            }

            td {
                vertical-align: top;
            }

            p {
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .tr{
                border:none;
            }
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }

           
        </style>
    </head>
    <body>
        <htmlpagefooter name="myFooter">
            
    	</htmlpagefooter>
        <br> <br> <br>

        <div>
            <h2 align="center"><strong> Receipt </strong></h2>
        </div>	
		<br>
        <table  class="item" width="100%"> 
            <tr>
                <td width="50%">
                    <b>Loan No: </b>{{ $loan_repayment->loan->loan_no }} <br>
                    <b>Name: </b>{{ $loan_repayment->loan->account->name }} <br>
                    <b>Phone No: </b>{{ $loan_repayment->loan->account->mobile_no }} <br>
                    <b>Agent Name: </b>{{ $loan_repayment->loan->agent->full_name }} <br>
                </td>
                <td width="50%">
                    <b>Loan Date: </b>{{ $loan_repayment->loan->loan_date }} <br>
                    <b>Contact Person: </b>{{ $loan_repayment->loan->account->contact_person }} <br>
                    <b>Contact Person No: </b>{{ $loan_repayment->loan->account->contact_person_no }} <br>
                </td>

            </tr>
            <tr >
                <td >
                    <b>Date of Payment Schedule: </b>{{ $loan_repayment->payment_date }} <br>
                  
                </td>
            </tr>
        </table>
        
		
		
        <table class="item" width="100%"  cellpadding="5" border='1px'>
			<thead >
                <tr  border='1px'>
                    <th  border='1px'>Collection Date</th>
                    <th  border='1px'> Amount Received against Interest (INR)</th>
                    <th  border='1px'>Travelling Charges (INR)</th>
                    <th  border='1px'> Amount Received against Loan (INR)</th>
                    <th  border='1px'>Payment Mode</th>
                    <th  border='1px'>Total Amount (INR)</th>
                </tr>
            </thead>
            <tbody>
                 @if(!empty($loan_repayment)) 
                 @foreach ($loan_repayment['collection'] as $collection)
                <tr  border='1px'>
                    <td  border='1px'> {{ $collection->payment_date }}  </td>
                    <td  border='1px'> {{ $collection->interest_received_amount }}  </td>
                    <td  border='1px'> {{ $collection->travelling_charges ? $collection->travelling_charges : '0.00' }}  </td>
                    <td  border='1px'> {{ $collection->loan_received_amount ? $collection->loan_received_amount : '0.00' }}  </td>
                    <td  border='1px'>{{ $collection->payment_mode }} {{ ($collection->payment_mode == 'Babk') ? $collection->utr_no : '' }}</td>
                    <td  border='1px'> {{ $collection->total_amount }}  </td>
                </tr>
                @endforeach
                @endif
            </tbody>
		</table>
        <div class="footer">
            <hr>
             <p style="text-align:right"> <?php echo Carbon::now(); ?></p>
               
        </div>

    </body>
</html>