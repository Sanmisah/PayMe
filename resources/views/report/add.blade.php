<?php 
use Illuminate\Support\Str;
?>

@extends('layouts.app')

@section('title', ' Loan Repayments')


@section('content')

<div class="container-fluid">
            

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Loan Replayment Report</h1>
       
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body p-2"> 
            <form method="POST" action="{{route('report.loan')}}" target="_blank">
            @csrf         

            <div class="form-group row m-2">                 
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>To</label>
                    <input
                        type="text"
                        class="form-control form-control @error('to_date') is-invalid @enderror"
                        name="to_date"
                        id="date"
                        >
                    @error('to_date')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div> 
                @hasrole('Admin')
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span>Agent</label>

                    <select name="agent_id" class="form-control form-control-user @error('agent_id') is-invalid @enderror" >
                        <option value="">Please Select</option>
                        @foreach ($agents as $id=>$agent)
                            <option value="{{ $agent->id }}">{{ $agent->full_name }}</option>
                        @endforeach
                    </select>

                    @error('agent_id')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div> 
                @endhasrole    
                @if(auth()->user()->roles->pluck('name')->first() != 'Admin')
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>Agent</label>
                    <select name="agent_id" class="form-control form-control-user @error('agent_id') is-invalid @enderror" >
                        <option value="{{ Auth::user()->id }}">{{ Auth::user()->full_name  }}</option>
                    </select>

                    @error('agent_id')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div> 
                @endif     
           
                <div class="col-md-12">
                    <label> &nbsp;</label>
                    {{-- Save Button --}} 
                    <button type="submit" class="btn btn-success btn-user btn-block">
                        Show
                    </button>
                </div>
            </div>
        </form>               
        </div>       
    </div>

   

</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#date').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy'
        });     
    });
</script>
@endsection





