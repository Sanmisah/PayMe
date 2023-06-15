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
            <h6 class="m-0 font-weight-bold text-primary">All Loan Repayments</h6>           
        </div>
        <div class="card-body">
            <form action="{{ route('loan_repayments.index') }}" method="get">
            @csrf
            <div class="form-group row">
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>Till Date</label>
                    <input 
                        type="text" 
                        class="form-control form-control-user @error('till_date') is-invalid @enderror" 
                        name="till_date" 
                        id="date"
                    >
                    @error('till_date')
                     <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>Loan Holder</label>
                    <select name="account_id" class="form-control form-control-user @error('account_id') is-invalid @enderror" >
                        <option value="">Please Select</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->account_no }} - {{ $account->name }}</option>
                        @endforeach
                    </select>

                    @error('account_id')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>Agent Name</label>
                    <select name="agent_id" class="form-control form-control-user @error('agent_id') is-invalid @enderror" >
                        <option value="">Please Select</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->full_name }}</option>
                        @endforeach
                    </select>

                    @error('agent_id')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>  &nbsp;</label> 
                    <button type="submit" class="btn btn-success btn-user btn-block">Search</button>
                </div>
            </div>
            </form>
            <form method="POST" action="{{route('loan_repayments.store')}}">
                @csrf
                

            <div class="table-responsive">
                <table class="table table-bordered tableRibb" id="dataTable" width="100%" cellspacing="0">
                 
                    
                    <thead>
                        <tr>
                            <th>Account No </th>
                            <th>Name </th>
                            <th>Area </th>
                            <th>Date </th>
                            <th>Mobile No </th>
                            <th>Alternative Mobile No </th>
                            <th>Agent Name </th>
                            <th width="12%">Amount</th>
                            <th>Balance Amount</th>
                            <th>Monthly Interest</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>                   
                    <tbody>
                        <?php $today = Carbon::now(); ?>
                        @if(!empty($repayments))
                       
                        @foreach ($repayments as $id=>$repayment)
                        <?php $date = Carbon::createFromFormat('d/m/Y', $repayment->payment_date); ?>
                            <tr class='{{ ($today >= $date) ? "text-danger" : "" }}'>
                                <td>  <span>{{ $repayment->loan->account->account_no }}</span>  </td>
                                <td>{{$repayment->loan->account->name }}</td>
                                <td>{{$repayment->loan->account->area->area }}</td>
                                <td>{{$repayment->payment_date }}</td>
                                <td>{{$repayment->loan->account->mobile_no }}</td>
                                <td>{{$repayment->loan->account->alternative_no }}</td>
                                <td>{{$repayment->loan->agent->full_name }}</td>
                                <td>
                                    <span>{{ $repayment->interest_amount }}</span> <br>
                                    <input 
                                        type="hidden" 
                                        class="form-control form-control-user @error('loan_repayment_id') is-invalid @enderror" 
                                        name="Collection[{{ $id }}][loan_repayment_id]"  
                                        value="{{ $repayment->id }}"
                                    >
                                    <input 
                                        type="text" 
                                        class="form-control form-control-user @error('interest_received_amount') is-invalid @enderror" 
                                        name="Collection[{{ $id }}][interest_received_amount]"  
                                    >  
                                   
                                </td>
                                <td> <span >{{ $repayment->balance_amount() }}</span>  </td>
                                <td>{{$repayment->loan->interest_rate }}</td>
                                <td>  
                                    
                                    <div class="display:none;">
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
                                            <a href="#" class="btn btn-info btn-sm m-2 log" data-toggle="modal" data-target="#Modal" alt="{{ $repayment->log }}" title="{{ $repayment->reason }}">
                                                Log
                                            </a>     
                                        @endif      

                                    </div>
                               </td>
                           </tr>
                       @endforeach
                       
                    </tbody>
                    <tfoot>
                        <tr> 
                            <td colspan="11" align="right"> 
                                <button type="submit" class="btn btn-primary btn-block m-2">Payment</button>  
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                    </form>
                </table>
                
                </form>
                {{ isset($repayments) ? $repayments->links() : ''}}

            </div>
        </div>
    </div>
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Loan Repayment Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                    <label>New Date: &nbsp; &nbsp; </label><span id="newDate"></span> <br>
                    <label>Old Date: &nbsp; &nbsp; </label><span id="oldDate"></span> <br>
                    <label>Reason: &nbsp; &nbsp; </label><span id="reason"></span> <br>
                    <label>Older Log: &nbsp; </label><span id="olderLog"></span> <br>

                    </div>
                  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    

</div>


@endsection
@section('scripts')
<script>
    $(document).ready(function(){
       
        $(".log").click(function(){
            data = $(this).attr('alt');
            title = $(this).attr('title');
            log = JSON.parse(data);
            $("#reason").text(title)
            $('#newDate').text(log['new_date']);
            $('#oldDate').text(log['old_date']);
            oldLog = JSON.parse(log['old_record']);
            $('#olderLog').text(oldLog['old_date']);

           

        });
        $('#date').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy'
        });
       
    });
</script>
@endsection
