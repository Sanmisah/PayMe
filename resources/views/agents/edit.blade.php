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
                        <label> <span style="color:red;">*</span>First Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('first_name') is-invalid @enderror" 
                            id="name"
                            name="first_name" 
                            value="{{ old('first_name') ? old('first_name')  : $agent->first_name }}">

                        @error('first_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label> <span style="color:red;">*</span>Last Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('last_name') is-invalid @enderror" 
                            id="last_name"
                            name="last_name" 
                            value="{{ old('last_name') ? old('last_name')  : $agent->last_name }}">

                        @error('last_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span>Mobile No</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('mobile_number') is-invalid @enderror" 
                            id="mobile_number"
                            name="mobile_number" 
                            value="{{ old('mobile_number') ? old('mobile_number') : $agent->mobile_number  }}">

                        @error('mobile_number')
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
                        <label><span style="color:red;">*</span> Alternative Mobile no</label>
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
                {{-- Save Button --}}
                <button type="submit" class="btn btn-success btn-user btn-block">
                    Save
                </button>

            </form>
        </div>
    </div>

</div>


@endsection