<?php 
use Illuminate\Support\Str;
?>

@extends('layouts.app')

@section('title', ' Booking')


@section('content')

<div class="container-fluid">
            

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Collection Report</h1>
       
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body p-2"> 
            <form method="POST" action="{{route('collections.report')}}" target="_blank">
            @csrf         

            <div class="form-group row m-2">
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>From</label> 
                    <input
                        type="text"
                        class="form-control form-control @error('from_date') is-invalid @enderror"
                        name="from_date"
                        id="date"
                        >
                    @error('from_date')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>    
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>To</label>
                    <input
                        type="text"
                        class="form-control form-control @error('to_date') is-invalid @enderror"
                        name="to_date"
                        id="toDate"
                        >
                    @error('to_date')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>    
                <!-- <div class="col-sm-3 mb-3 mb-sm-0">
                    <label>Loan</label>
                    <select class="form-control  @error('block_id') is-invalid @enderror" name="loan_id" id="pet">
                        <option value="">Please Select</option>
                       @foreach ($loans as $id=>$loan)
                       <option value="{{ $id}}">{{ $loan }}</option>
                       @endforeach
                    </select>          
                    @error('block_id')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>    -->
                <div class="col-md-12">
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
        $('#toDate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy'
        });
    });
</script>
@endsection






