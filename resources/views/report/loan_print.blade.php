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
          
            th {
				align: center;
				vertical-align: middle;
                background-color: #E5E5E5;
			}
           

           
        </style>
    </head>
    <body>

        <div>
            <h2 align="center"><strong> Loan Report </strong></h2>
        </div>	
		<br>
		
		<table class="item" width="100%"  cellpadding="5" border='1px'>
			<thead >
                <tr  border='1px'>
                    <th  border='1px'> Date</th>
                    <th  border='1px'>Account No</th>
                    <th  border='1px'>Account Name</th>
                    <th  border='1px'>Agent Name</th>
                    <th  border='1px'>Loan Amount (INR)</th>
                    <th  border='1px'>Paid Amount (INR)</th>
                    <th  border='1px'>Rate of Interest</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalAmount = 0; 
                 $totalPaid = 0; ?>
                 @if(!empty($loans)) 
                 @foreach ($loans as $loan)
                
                <tr  border='1px'>
                    <td  border='1px'> {{ $loan->loan_date }}  </td>
                    <td  border='1px'> {{ $loan->Account->account_no }}  </td>
                    <td  border='1px'> {{ $loan->Account->name }}  </td>
                    <td  border='1px'> {{ $loan->Agent->first_name }}  </td>
                    <td  border='1px' align="right"> {{ $loan->final_amount }}  </td>
                    <td  border='1px' align="right"> {{ $loan->paid_amount }}  </td>
                    <td  border='1px' align="right"> {{ $loan->interest_rate }}  </td>
                </tr>
                
                <?php 
                    $totalAmount += $loan->final_amount; 
                    $totalPaid += $loan->paid_amount;
                 ?>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" align="right"><b>Total Amount</b></td>
                    <td align="right"><b>{{ $totalAmount }}</b></td>
                    <td align="right"><b>{{ $totalPaid }}</b></td>
                    <td align="right"></td>
                </tr>
            </tfoot>
		</table>
		

    </body>
</html>