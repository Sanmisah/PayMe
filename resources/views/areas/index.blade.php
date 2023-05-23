@extends('layouts.app')

@section('title', 'areas')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Areas</h1>
        <a href="{{route('areas.create')}}" class="btn btn-sm btn-primary" >
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
    

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Areas</h6>            

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Areas</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $area)
                            <tr>
                               <td>{{$area->area }}</td>
                                <td style="display:flex;">                                   
                                   
                                    <a href="{{ route('areas.edit', ['area' => $area->id]) }}" class="btn btn-primary btn-sm m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                  
                                    <form action="{{ route('areas.destroy',$area->id) }}" method="Post" onsubmit="return confirm('Do you really want to Delete this Record')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm m-2"><i class="fa fa-trash"></i></button>
                                    </form>
                                  
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                {{$areas->links()}}

            </div>
        </div>
    </div>

</div>


@endsection
