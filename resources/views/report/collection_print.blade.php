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
                    <th  border='1px'>Collection Date</th>
                    <th  border='1px'> Amount Received against Interest (INR)</th>
                    <th  border='1px'>Travelling Charges (INR)</th>
                    <th  border='1px'> Amount Received against Loan (INR)</th>
                    <th  border='1px'>Payment Mode</th>
                    <th  border='1px'>Total Amount (INR)</th>
                </tr>
            </thead>
            <tbody>
                 @if(!empty($collections)) 
                 @foreach ($collections as $collection)
                <tr  border='1px'>
                    <td  border='1px'> {{ $collection->payment_date }}  </td>
                    <td  border='1px'> {{ $collection->interest_received_amount }}  </td>
                    <td  border='1px'> {{ $collection->travelling_charges ? $collection->travelling_charges : '' }}  </td>
                    <td  border='1px'> {{ $collection->loan_received_amount ? $collection->loan_received_amount : '' }}  </td>
                    <td  border='1px'>{{ $collection->payment_mode }} {{ ($collection->payment_mode == 'Babk') ? $collection->utr_no : '' }}</td>
                    <td  border='1px'> {{ $collection->total_amount }}  </td>
                </tr>
                @endforeach
                @endif
            </tbody>
		</table>
		

    </body>
</html>