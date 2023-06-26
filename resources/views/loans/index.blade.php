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
            <form method="GET" action="{{ route('loans.index') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-3 mb-3">
                        <label><b>Search By Account No</b></label>
                        <input type="text" name="search_account" class="form-control  @error('search_account') is-invalid @enderror">
                        @error('search_account')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label><b>Search By Name</b></label>
                        <input type="text" name="search" class="form-control  @error('search') is-invalid @enderror">
                        @error('search')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label><b>Search By Mobile No</b></label>
                        <input type="text" name="search_mobile" class="form-control  @error('search_mobile') is-invalid @enderror">
                        @error('search_mobile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label> &nbsp; </label>
                        <button type="submit" class="btn btn-success btn-block">Search</button>

                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Account No </th>
                            <th>Name (Mobile No)</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Total Loan Amount</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)    
                            @if($account->loan->sum('final_amount') > 0)                 
                            <tr>
                               <td>{{$account->account_no }}</td>
                               <td>{{$account->name }} ({{$account->mobile_no }})</td>
                               <td>{{$account->address }} </td>
                               <td>{{$account->contact_person }}</td>
                               <td>{{  $account->loan->sum('final_amount') }}</td>
                              
                                <td>   
                                    <div  style="display:flex;">        
                                        <a href="{{ route('loan_repayments.show', ['loan_repayment' => $account->id]) }}" class="btn btn-primary btn-sm m-2">
                                            Loan History
                                        </a> 
                                    </div>     
                               </td>
                           </tr>
                           @endif
                       @endforeach
                    </tbody>
                </table>
                {{$accounts->links()}}

            </div>
        </div>
    </div>

</div>


@endsection
