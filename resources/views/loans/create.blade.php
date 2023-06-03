@extends('layouts.app')

@section('title', 'Add Loan')

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
            <h6 class="m-0 font-weight-bold text-primary">Add New loan</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('loans.store')}}">
                @csrf
               
                <div class="form-group row">                   
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> Account</label>
                        <select name="account_id" class="form-control form-control-user @error('account_id') is-invalid @enderror" >
                            <option value="">Please Select</option>
                            @foreach ($accounts as $id=>$account)
                                <option value="{{ $id }}">{{ $account }}</option>
                            @endforeach
                        </select>

                        @error('account_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                  
                    @hasrole('Admin')
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>Agent</label>

                        <select name="agent_id" class="form-control form-control-user @error('agent_id') is-invalid @enderror" >
                            <option value="">Please Select</option>
                            @foreach ($agents as $id=>$agent)
                                <option value="{{ $id }}">{{ $agent }}</option>
                            @endforeach
                        </select>

                        @error('agent_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> 
                    @endhasrole    
                    @if(auth()->user()->roles->pluck('name')->first() != 'Admin')
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label>Agent</label>
                        <select name="agent_id" class="form-control form-control-user @error('agent_id') is-invalid @enderror" >
                            <option value="{{ Auth::user()->id }}">{{ Auth::user()->full_name  }}</option>
                        </select>

                        @error('agent_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> 
                    @endif                  
                </div>                           
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> Loan Date</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('loan_date') is-invalid @enderror" 
                            name="loan_date" 
                            data-mask="99/99/9999"
                            value="{{ old('loan_date')  }}">

                        @error('loan_date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> Loan Amount</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('loan_amount') is-invalid @enderror" 
                            name="loan_amount" 
                            value="{{ old('loan_amount')  }}">

                        @error('loan_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> EMI Day</label>
                        <select name="emi_day" id=""  class="form-control form-control-user @error('emi_day') is-invalid @enderror" >
                            <option value="">Please Select</option>
                            <?php $arr = range(1,28); ?>     
                            @foreach($arr as $a)
                            <option value="{{ $a }}">{{ $a }}</option>
                            @endforeach
                            
                        </select>

                        @error('emi_day')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                   
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> Interest Rate Per Months</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('interest_rate') is-invalid @enderror" 
                            name="interest_rate" 
                            value="{{ old('interest_rate')  }}">

                        @error('interest_rate')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                   

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> Period In Months</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('period') is-invalid @enderror" 
                            name="period" 
                            value="{{ old('period')  }}">

                        @error('period')
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