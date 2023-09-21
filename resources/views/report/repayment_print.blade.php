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
        </div>	
        <?php $i = 0; ?>
        <?php $loan = 0; ?>
        @if(!empty($data)) 
        @foreach ($data as $repayment)
            @if($i != 0)
                <P style="page-break-before: always">
            @endif
            <table width="100%">
                <tr>
                    <td width="30%"> &nbsp;</td>
                    <td><h3 align="center"> {{ $repayment['agent_name'] }}</h3>   </td>
                    <td width="30%"> <h3 align="right">Till Date: <?= $date->format('d/m/Y') ?></h3></td>
                </tr>
            </table> <br>
          

            <table class="item" width="100%"  cellpadding="5" border='1px'>
                <thead>
                    <tr>
                        <th>Account No</th>
                        <th>Collection Day</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Till Last Month</th>
                        <th>Current Month</th>
                    </tr>
                </thead>
            @foreach ($repayment as $record)
                @if($record != $repayment['agent_name'])
                    <tr>                
                        <td>{{ $record['account_no'] }}</td>
                        <td>{{ $record['day'] }}</td>
                        <td>{{ $record['name'] }}</td>
                        <td>{{ $record['address'] }}</td>
                        <td>{{ $record['last'] }}</td>
                        <td>{{ $record['current'] }}</td>
                        
                    </tr>

                @endif
            @endforeach
            </table>   
            <?php $i = 1; ?>

        @endforeach
        @else
        <table width="100%">
                <tr>
                    <td width="30%"> &nbsp;</td>
                    <td><h3 align="center"> No Records</h3>   </td>
                    <td width="30%"> <h3 align="right">Till Date: <?= $date->format('d/m/Y') ?></h3></td>
                </tr>
            </table> <br>
          

            <table class="item" width="100%"  cellpadding="5" border='1px'>
                <thead>
                    <tr>
                        <th>Account No</th>
                        <th>Collection Day</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Till Last Month</th>
                        <th>Current Month</th>
                    </tr>
                </thead>
            </table>
        @endif

        


          
		

    </body>
</html>