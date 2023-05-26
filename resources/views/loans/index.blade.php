@extends('layouts.app')

@section('title', 'Loans')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Loans</h1>
        <a href="{{route('loans.create')}}" class="btn btn-sm btn-primary" >
            <i class="fas fa-plus"></i> Registration
        </a>
    </div>
    

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Loans</h6>            

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Loan No </th>
                            <th>Loan Date </th>
                            <th>Agent Name </th>
                            <th>Name </th>
                            <th>Mobile No</th>
                            <th>Contact Person</th>
                            <th>Loan Amount</th>
                            <th>Balance Amount</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{$loan->loan_no }}</td>
                                <td>{{$loan->loan_date }}</td>
                                <td>{{$loan->Agent->first_name }}</td>
                               <td>{{$loan->name }}</td>
                               <td>{{$loan->mobile_no }} </td>
                               <td>{{$loan->contact_person }}</td>
                               <td>{{ $loan->loan_amount }} <br> at {{ $loan->interest_rate }}% Interest Rate</td>
                               <td>{{ $loan->balanceAmount() }}</td>
                                <td style="display:flex;">                                   
                                   
                                    <a href="{{ route('loan_repayments.show', ['loan_repayment' => $loan->id]) }}" class="btn btn-primary btn-sm m-2">
                                        Details
                                    </a>
                                  
                                    <form action="{{ route('loans.destroy',$loan->id) }}" method="Post" onsubmit="return confirm('Do you really want to Delete this Record')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm m-2"><i class="fa fa-trash"></i></button>
                                    </form>
                                  
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                {{$loans->links()}}

            </div>
        </div>
    </div>

</div>


@endsection
