@extends('layouts.app')

@section('title', 'Add Areas')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add areas</h1>
        <a href="{{route('areas.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit  Area</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('areas.update', ['area' => $area->id])}}">
                @csrf
                @method('PUT')
                <div class="form-group row">

                    {{-- area --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>area</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('area') is-invalid @enderror" 
                            id="area"
                            placeholder="Name" 
                            name="area" 
                            value="{{ old('area') ? old('area') : $area->area }}">

                        @error('area')
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