@extends('layouts.app')

@section('title', 'Add Account')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Accounts</h1>
        <a href="{{route('accounts.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Account</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('accounts.store')}}">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-3 mb-3 mb-sm-0">
                     <label><span style="color:red;">*</span>Account No</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('account_no') is-invalid @enderror" 
                            id="account_no"
                            name="account_no" 
                            value="{{ old('account_no')  }}">

                        @error('account_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span> Area</label>
                        <select name="area_id" class="form-control form-control-user @error('area_id') is-invalid @enderror" >
                            <option value="">Please Select</option>
                            @foreach ($areas as $id=>$area)
                                <option value="{{ $id }}">{{ $area }}</option>
                            @endforeach
                        </select>

                        @error('area_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span> Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('name') is-invalid @enderror" 
                            id="name"
                            name="name" 
                            value="{{ old('name')  }}">

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
                            value="{{ old('mobile_no')  }}">

                        @error('mobile_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="col-sm-4 mb-3 mb-sm-0">
                    <label> Alternative Mobile no</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('alternative_no') is-invalid @enderror" 
                            id="alternativeNo"
                            name="alternative_no" 
                            value="{{ old('alternative_no')  }}">

                        @error('alternative_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>               
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label>Email</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('email') is-invalid @enderror" 
                            id="email"
                            name="email" 
                            value="{{ old('email')  }}">

                        @error('email')
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
                            value="{{ old('address')  }}">

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
                            value="{{ old('contact_person')  }}">

                        @error('contact_person')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                    <label><span style="color:red;">*</span> Contact Person Mobile No</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('contact_person_no') is-invalid @enderror" 
                            name="contact_person_no" 
                            value="{{ old('contact_person_no')  }}">

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
                            value="{{ old('contact_person_email')  }}">

                        @error('contact_person_email')
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