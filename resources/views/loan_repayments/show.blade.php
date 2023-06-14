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
                        @foreach ($repayments as $repayment)
                        <?php $date = Carbon::createFromFormat('d/m/Y', $repayment->payment_date); ?>
                            <tr class='{{ ($today >= $date) ? "text-danger" : "" }}'>
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
                    <label for="">New Date: &nbsp; &nbsp; </label><span id="newDate"></span> <br>
                    <label for="">Old Date: &nbsp; &nbsp; </label><span id="oldDate"></span> <br>
                    <label for="">Older Log: &nbsp; </label><span id="olderLog"></span> <br>

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
            log = JSON.parse(data);
            $('#newDate').text(log['new_date']);
            $('#oldDate').text(log['old_date']);
            oldLog = JSON.parse(log['old_record']);
            $('#olderLog').text(oldLog['old_date']);
           

        });
    });
</script>
@endsection
