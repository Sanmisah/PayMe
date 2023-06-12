@extends('layouts.app')

@section('title', 'Loan')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Loan</h1>
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
            <form method="POST" action="{{route('loans.update', ['loan'=>$loan->id])}}">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span> Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('name') is-invalid @enderror" 
                            id="name"
                            placeholder="Name" 
                            name="name" 
                            value="{{ old('name') ? old('name') : $loan->name  }}">

                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span>Mobile No</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('mobile_no') is-invalid @enderror" 
                            id="mobile_no"
                            name="mobile_no" 
                            value="{{ old('mobile_no') ? old('mobile_no') : $loan->mobile_no }}">

                        @error('mobile_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="col-sm-3 mb-3 mb-sm-0">
                    <label> Alternative Mobile no</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('alternative_no') is-invalid @enderror" 
                            id="alternativeNo"
                            name="alternative_no" 
                            value="{{ old('alternative_no') ? old('alternative_no') : $loan->alternative_no }}">

                        @error('alternative_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label>Email</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('email') is-invalid @enderror" 
                            id="email"
                            placeholder="email" 
                            name="email" 
                            value="{{ old('email') ? old('email') : $loan->email }}">

                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                  
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span>Agent</label>
                        <select name="agent_id" class="form-control form-control-user @error('agent_id') is-invalid @enderror" >
                            <option value="">Please Select</option>
                            @foreach ($agents as $id=>$agent)
                                <option value="{{ $id }}" {{ $loan->agent_id == $id ? 'Selected' : ''}}>{{ $agent }}</option>
                            @endforeach
                        </select>

                        @error('agent_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                  
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                    <label> Address</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('address') is-invalid @enderror" 
                            id="address"
                            name="address" 
                            value="{{ old('address') ? old('address') : $loan->address }}">

                        @error('address')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span> Contact Person Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('contact_person') is-invalid @enderror" 
                            name="contact_person" 
                            value="{{ old('contact_person') ? old('contact_person') : $loan->contact_person }}">

                        @error('contact_person')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span>Contact Person Mobile No</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('contact_person_no') is-invalid @enderror" 
                            name="contact_person_no" 
                            value="{{ old('contact_person_no') ? old('contact_person_no') : $loan->contact_person_no }}">

                        @error('contact_person_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label>Contact Person Email</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('contact_person_email') is-invalid @enderror" 
                            name="contact_person_email" 
                            value="{{ old('contact_person_email') ? old('contact_person_email') : $loan->contact_person_email }}">

                        @error('contact_person_email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>Loan Date</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('loan_date') is-invalid @enderror" 
                            name="loan_date" 
                            id="loanDate"
                            value="{{ old('loan_date') ? old('loan_date') : $loan->loan_date }}">

                        @error('loan_date')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>Loan Amount</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('loan_amount') is-invalid @enderror" 
                            name="loan_amount" 
                            value="{{ old('loan_amount') ? old('loan_amount') : $loan->loan_amount }}">

                        @error('loan_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>EMI Day</label>
                        <select name="emi_day" id=""  class="form-control form-control-user @error('emi_day') is-invalid @enderror" >
                            <option value="">Please Select</option>
                            <?php $arr = range(1,28); ?>     
                            @foreach($arr as $a)
                            <option value="{{ $a }}"  {{ $loan->emi_day == $a ? 'Selected' : ''}}>{{ $a }}</option>
                            @endforeach
                            
                        </select>

                        @error('emi_day')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                   
                </div>
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>Interest Rate Per Months</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('interest_rate') is-invalid @enderror" 
                            name="interest_rate" 
                            value="{{ old('interest_rate') ? old('interest_rate') : $loan->interest_rate }}">

                        @error('interest_rate')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>                   

                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>Period In Months</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('period') is-invalid @enderror" 
                            name="period" 
                            value="{{ old('period') ? old('period') : $loan->period }}">

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