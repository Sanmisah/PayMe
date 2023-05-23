@extends('layouts.app')

@section('title', 'Loans')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Loans</h1>
        <a href="{{route('loans.create')}}" class="btn btn-sm btn-primary" >
            <i class="fas fa-plus"></i> Registration
        </a>
    </div>
    

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Loans</h6>            

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name </th>
                            <th>Mobile No</th>
                            <th>Alternative Mobile No</th>
                            <th>Contact Person</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                               <td>{{$loan->name }}</td>
                               <td>{{$loan->mobile_no }}</td>
                               <td>{{$loan->alternative_no }}</td>
                               <td>{{$loan->contact_person }}</td>
                                <td style="display:flex;">                                   
                                   
                                    <a href="{{ route('loans.edit', ['loan' => $loan->id]) }}" class="btn btn-primary btn-sm m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                  
                                    <form action="{{ route('loans.destroy',$loan->id) }}" method="Post" onsubmit="return confirm('Do you really want to Delete this Record')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm m-2"><i class="fa fa-trash"></i></button>
                                    </form>
                                  
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                {{$loans->links()}}

            </div>
        </div>
    </div>

</div>


@endsection
