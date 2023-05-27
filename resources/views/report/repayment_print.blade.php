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
            <h2 align="center"><strong> Report </strong></h2>
        </div>	
		<br>
		
		<table class="item" width="100%"  cellpadding="5" border='1px'>
			<thead >
                <tr  border='1px'>
                    <th  border='1px'> Date</th>
                    <th  border='1px'> Interest Amount (INR)</th>
                    <th  border='1px'>Log (Old Reschedule Date)</th>
                    <th  border='1px'>Paid Amount (INR)</th>
                </tr>
            </thead>
            <tbody>
                 @if(!empty($repayments)) 
                 @foreach ($repayments as $repayment)
                <tr  border='1px'>
                    <td  border='1px'> {{ $repayment->payment_date }}  </td>
                    <td  border='1px'> {{ $repayment->interest_amount }}  </td>
                    <td  border='1px'> 
                       <?php  if($repayment->log){
                            $log = json_decode($repayment->log); ?>
                            {{ $log->old_date }}                           
                       <?php }else { echo ' ';}     ?>
                       
                    </td>
                    <td  border='1px'> {{ $repayment->paid_amount }}  </td>
                </tr>
                @endforeach
                @endif
            </tbody>
		</table>
		

    </body>
</html>