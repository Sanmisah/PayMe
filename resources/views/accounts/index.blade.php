@extends('layouts.app')

@section('title', 'Accounts')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Accounts</h1>
        <a href="{{route('accounts.create')}}" class="btn btn-sm btn-primary" >
            <i class="fas fa-plus"></i> Registration
        </a>
    </div>
    

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Accounts</h6>            

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Account No </th>
                            <th>Name </th>
                            <th>Area </th>
                            <th>Address </th>
                            <th>Mobile No</th>
                            <th>Alternative Mobile No</th>
                            <th>Contact Person</th>
                            <th>Contact Person No</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{$account->account_no }}</td>
                               <td>{{$account->name }}</td>
                               <td>{{$account->area->area }}</td>
                               <td>{{$account->address }} </td>
                               <td>{{$account->mobile_no }} </td>
                               <td>{{$account->alternative_no }} </td>
                               <td>{{$account->contact_person }}</td>
                               <td>{{ $account->contact_person_no }}</td>
                                <td>   
                                    <div  style="display:flex;">
                                        <a href="{{ route('accounts.edit', ['account' => $account->id]) }}" class="btn btn-primary btn-sm m-2">
                                            Edit
                                        </a>
                                    
                                        <form action="{{ route('accounts.destroy',$account->id) }}" method="Post" onsubmit="return confirm('Do you really want to Delete this Record')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm m-2"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>     
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                {{$accounts->links()}}

            </div>
        </div>
    </div>

</div>


@endsection
