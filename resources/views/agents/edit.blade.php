@extends('layouts.app')

@section('title', 'Add Agents')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Agents</h1>
        <a href="{{route('agents.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit  Agent</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('agents.update', ['agent' => $agent->id])}}">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label> <span style="color:red;">*</span>Agent Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('name') is-invalid @enderror" 
                            id="name"
                            placeholder="Name" 
                            name="name" 
                            value="{{ old('name') ? old('name')  : $agent->name }}">

                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span>Mobile No</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('mobile_no') is-invalid @enderror" 
                            id="mobile_no"
                            name="mobile_no" 
                            value="{{ old('mobile_no') ? old('mobile_no') : $agent->mobile_no  }}">

                        @error('mobile_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label> <span style="color:red;">*</span>Alternative Mobile no</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('alternative_no') is-invalid @enderror" 
                            id="alternativeNo"
                            name="alternative_no" 
                            value="{{ old('alternative_no') ? old('alternative_no') : $agent->alternative_no  }}">

                        @error('alternative_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span>Agent Email</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('email') is-invalid @enderror" 
                            id="email"
                            placeholder="email" 
                            name="email" 
                            value="{{ old('email') ? old('email') : $agent->email  }}">

                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label>Address</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('address') is-invalid @enderror" 
                            id="address"
                            name="address" 
                            value="{{ old('address') ? old('address') : $agent->address }}">

                        @error('address')
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