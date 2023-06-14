@extends('layouts.app')

@section('title', 'Loan')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Loans</h1>
        <a href="{{route('loans.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
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
            <form method="POST" action="{{route('loans.update', ['loan' => $loan->id])}}">
                @csrf
                @method('PUT')
               
                <div class="form-group row">                   
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label  style="color:black;"> <b>Account:</b> {{ $loan->account->account_no }}- {{ $loan->account->name }}</label> 
                        
                    </div>                 
                   
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label  style="color:black;"><b>Agent:</b> {{ $loan->agent->full_name }}</label>
                    </div> 
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label style="color:black;"> <b>Loan Date:</b> {{ $loan->loan_date  }}</label>
                    </div>
                </div>                           
                <div class="form-group row">
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label> Loan Amount</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('loan_amount') is-invalid @enderror" 
                            name="loan_amount" 
                            value="{{ old('loan_amount') ? old('loan_amount')  : $loan->loan_amount }}">

                        @error('loan_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                      
                
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label> EMI Day</label>
                        <select name="emi_day" id=""  class="form-control form-control-user @error('emi_day') is-invalid @enderror" >
                            <option value="">Please Select</option>
                            <?php $arr = range(1,28); ?>     
                            @foreach($arr as $a)
                            <option value="{{ $a }}" {{ $loan->emi_day == $a ? 'Selected' : '' }}>{{ $a }}</option>
                            @endforeach
                            
                        </select>

                        @error('emi_day')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                     
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label>Interest Rate Per Months</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('interest_rate') is-invalid @enderror" 
                            name="interest_rate" 
                            value="{{ old('interest_rate') ? old('interest_rate') : $loan->interest_rate }}">

                        @error('interest_rate')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>    
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label> Period In Months</label>
                        <input value="{{ $loan->period }}" readonly=true class="form-control ">
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
    $(document).ready(function(){
        $('#loanDate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy'
        });
    });
</script>
@endsection