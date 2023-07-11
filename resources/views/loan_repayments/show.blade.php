<?php 
use Carbon\Carbon;
 ?>
@extends('layouts.app')

@section('title', 'Loan Repayments')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Loan Repayments</h1>
    </div>
    

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Loan History</h6>           
        </div>
        <div class="card-body">
            <!-- Tabs navs -->
            <ul class="nav nav-tabs mb-3" id="ex1-con" role="tablist">
                @if(isset($accounts->Loan))
                    @foreach($accounts->Loan as $id=>$loan)
                        <li class="nav-item" role="presentation">
                            <a
                            class="nav-link "
                            id="ex1-tab-{{ $id+1 }}"
                            data-toggle="tab"
                            href="#loan-{{ $id+1 }}"
                            role="tab"
                            aria-controls="ex1-tabs-1"
                            aria-selected="false"
                            >{{ $loan->loan_no }}</a
                            >
                        </li>
                                        
                    @endforeach
                @endif
               
               
               
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex1-content">
                @if(isset($accounts->Loan))
                    @foreach($accounts->Loan as $id=>$loan)
                        <div
                            class="tab-pane fade  table-responsive"
                            id="loan-{{ $id+1 }}"
                            role="tabpanel"
                            aria-labelledby="ex1-tab-{{ $id+1 }}"
                        >
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Loan No </th>
                                        <th>Loan Date </th>
                                        <th>Agent Name </th>
                                        <th>Day</th>
                                        <th>Initial Loan Amount</th>
                                        <th>Balance Amount</th>
                                        <th>Balance Interest Amount</th>
                                    </tr>
                                </thead>
                                <tbody>                                       
                                    <tr>
                                        <td>{{$loan->loan_no }}</td>
                                        <td>{{$loan->loan_date }}</td>
                                        <td>{{$loan->Agent->first_name }}</td>
                                        <td>{{$loan->emi_day }}</td>
                                        <td>{{ $loan->final_amount }} at {{ $loan->interest_rate }}% Interest Rate</td>
                                        <td>
                                                {{ $loan->balanceAmount() }} 
                                            
                                            
                                        </td>
                                        <td> {{ $loan->LoanRepayments->sum('interest_amount')-$loan->LoanRepayments->sum('paid_amount') }} </td>
                                    
                                </tr>
                            
                                </tbody>
                            </table>

                            <hr>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Account No </th>
                                            <th>Name </th>
                                            <th>Area </th>
                                            <th>Date </th>
                                            <th>Mobile No </th>
                                            <th>Alternative Mobile No </th>
                                            <th>Agent </th>
                                            <th>Amount</th>
                                            <th>Received Amount</th>
                                            <th>Balanced Amount</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $today = Carbon::now(); ?>
                                        @foreach ($loan->LoanRepayments as $repayment)
                                        <?php $date = Carbon::createFromFormat('d/m/Y', $repayment->payment_date); ?>
                                            <tr class='{{ ($today >= $date && $repayment->balance_amount() > 0) ? "text-danger" : "" }}'>
                                                <td>{{ $repayment->loan->account->account_no}}</td>
                                                <td>{{ $repayment->loan->account->name}}</td>
                                                <td>{{ $repayment->loan->account->area->area}}</td>
                                                <td>{{$repayment->payment_date }}</td>
                                                <td>{{ $repayment->loan->account->mobile_no}}</td>
                                                <td>{{ $repayment->loan->account->alternative_no}}</td>
                                                <td>{{ $repayment->loan->agent->full_name}}</td>
                                                <td>{{$repayment->interest_amount }}</td>
                                            <td>{{$repayment->paid_amount }}</td>
                                            <td>{{$repayment->balance_amount() }}</td>
                                                <td >  
                                                    <div style="display:flex;">
                                                        @if($repayment->balance_amount() > 0)                               
                                                    
                                                            <a href="{{ route('loan_repayments.edit', ['loan_repayment' => $repayment->id]) }}" class="btn btn-primary btn-sm m-2">
                                                                Postponed
                                                            </a>  
                                                            <a href="{{ route('loan_repayments.collections', ['loan_repayment' => $repayment->id]) }}" class="btn btn-primary btn-sm m-2">
                                                                Payment
                                                            </a>  
                                                        @endif
                                                        @if($repayment->paid_amount > 0)
                                                            <a href="{{ env('BASE_URL', '') }}/reports/collection/{{$repayment->id}}/{{$repayment->loan->name}}.pdf" class="btn btn-primary btn-sm m-2" target="_blank">
                                                                Receipt
                                                            </a>
                                                        @endif
                                                        @if($repayment->log)
                                                                <?php $data = json_decode($repayment->log); ?>
                                                                <a href="#" class="btn btn-info btn-sm m-2 log" data-toggle="modal" data-target="#Modal" alt="{{ $repayment->log }}">
                                                                    Log
                                                                </a>     
                                                        @endif          

                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                                        
                    @endforeach
                @endif
               
                <div
                    class="tab-pane fade"
                    id="ex1"
                    role="tabpanel"
                    aria-labelledby="ex2-tab-1"
                >
                  
                </div>
            </div>
            <!-- Tabs content -->
          
        </div>
    </div>
   

</div>


@endsection
