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
                        type="date" 
                        class="form-control form-control-user @error('date') is-invalid @enderror" 
                        name="date" 
                    >
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>  </label> <br>
                    <button type="submit" class="btn btn-success btn-user btn-block">Search</button>
                </div>
            </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Loan No </th>
                            <th>Date </th>
                            <th>Amount</th>
                            <th>Received Amount</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($repayments as $repayment)
                            <tr>
                                <td>{{ $repayment->loan->loan_no}}</td>
                                <td>{{$repayment->payment_date }}</td>
                                <td>{{$repayment->interest_amount }}</td>
                               <td>{{$repayment->paid_amount }}</td>
                                <td style="display:flex;">                                   
                                   
                                    <a href="{{ route('loan_repayments.edit', ['loan_repayment' => $repayment->id]) }}" class="btn btn-primary btn-sm m-2">
                                        Postponed
                                    </a>  
                                    @if($repayment->log)
                                    <?php $data = json_decode($repayment->log); ?>
                                    <a href="#" class="btn btn-info btn-sm m-2 log" data-toggle="modal" data-target="#Modal" alt="{{ $repayment->log }}">
                                        Log
                                    </a>     
                                    @endif                             
                                  
                                  
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                {{$repayments->links()}}

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
