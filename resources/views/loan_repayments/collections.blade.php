@extends('layouts.app')

@section('title', 'Loan Repayments')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Loan Repayments</h1>
        <a href="{{route('loan_repayments.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit loan</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('loan_repayments.collected', ['id'=>$loan_repayment->id])}}">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                            <tr>
                                <th>Account No </th>
                                <th>Loan No </th>
                                <th>Name </th>
                                <th>Agent Name </th>
                                <th>Payment Date </th>
                                <th>Paid Amount (INR)</th>
                                <th>Balanced Amount(INR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loan_repayments as $repayment)
                            <tr>
                                <td>{{$repayment->loan->account->account_no }}</td>
                                <td>{{$repayment->loan->loan_no }}</td>
                                <td>{{$repayment->loan->account->name }}</td>
                                <td>{{$repayment->loan->agent->full_name }}</td>
                                <td>{{$repayment->payment_date }}</td>
                                <td>{{$repayment->paid_amount }}</td>
                                <td>{{$repayment->balance_amount() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <hr>
                @if($collection)
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Payment Date </th>
                                <th>Travelling Charges </th>
                                <th>Interest Received Amount </th>
                                <th>Loan Received Amount </th>
                                <th>Payment Mode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection as $collect)
                            <tr>
                                <td>{{ $collect->payment_date }}</td>
                                <td>{{ $collect->travelling_charges }}</td>
                                <td>{{ $collect->interest_received_amount }}</td>
                                <td>{{ $collect->loan_received_amount }}</td>
                                <td>{{ $collect->payment_mode }} {{ $collect->utr_no ? ': '.$collect->utr_no : '' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                @endif
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span> Date</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('payment_date') is-invalid @enderror" 
                            name="payment_date" 
                            id="paymentDate"
                            value="{{ $date }}"
                        >

                        @error('payment_date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> Payment Mode</label>
                        <select name="payment_mode" id="mode" class="form-control">
                            <option value="'">Please Select</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                            <option value="UPI">UPI</option>
                        </select>
                       
                        @error('payment_mode')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0" style="display:none;" id="utr">
                        <label>UTR No</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('utr_no') is-invalid @enderror" 
                            name="utr_no" 
                        >

                        @error('utr_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                 
                  
                </div>
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> Interest Received Amount</label>
                        <input 
                            type="number" 
                            class="form-control form-control-user @error('interest_received_amount') is-invalid @enderror" 
                            name="interest_received_amount"  
                            value="{{ $amount }}"
                            id="interest"
                        >

                        @error('interest_received_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label>Travelling Charges</label>
                        <input 
                            type="number" 
                            class="form-control form-control-user @error('travelling_charges') is-invalid @enderror" 
                            name="travelling_charges" 
                            default="0.00"
                            id="travel"
                        >

                        @error('travelling_charges')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                  
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label> Laon Received Amount </label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('loan_received_amount') is-invalid @enderror" 
                            name="loan_received_amount"  
                            default="0.00"
                            id="loan"
                        >

                        @error('loan_received_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
              

                {{-- Save Button --}}
                <button type="submit" class="btn btn-success btn-user btn-block">
                    Save
                </button>

            </form>
        </div>
    </div>

</div>


@endsection
@section('scripts')
<script>
    $("#mode").change(function(){
        if($("#mode").val()== 'Bank'){
            $("#utr").show()
        } else  if($("#mode").val()== 'UPI'){
            $("#utr").show()
        } else {
            $("#utr").hide()
        }
    });
    $('#paymentDate').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd/mm/yyyy'
    });
   
</script>
@endsection