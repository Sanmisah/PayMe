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
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit loan</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('loan_repayments.update', ['loan_repayment'=>$loan_repayment->id])}}">
                @csrf
                @method('PUT')
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Loan No </th>
                                <th>Payment Date </th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$loan_repayment->loan->loan_no }}</td>
                                <td>{{$loan_repayment->payment_date }}</td>
                                <td>{{$loan_repayment->interest_amount }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="form-group row">
                    <div class="col-sm-3 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span> Reschedule Date</label>
                        <input 
                            type="date" 
                            class="form-control form-control-user @error('payment_date') is-invalid @enderror" 
                            id="payment_date"
                            placeholder="payment_date" 
                            name="payment_date" 
                            value="{{ old('payment_date') ? old('payment_date') : $loan_repayment->payment_date  }}">

                        @error('payment_date')
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