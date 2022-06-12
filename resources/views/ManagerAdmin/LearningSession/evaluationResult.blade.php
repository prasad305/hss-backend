@extends('Layouts.ManagerAdmin.master')

@push('title')
Manager Admin
@endpush


@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Learning Session Evaluation</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Evaluation</li>
                    <li class="breadcrumb-item active">Evaluation Mark</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>



<div class="content">

    <div class="container-fluid">

        <h1>Final Result</h1>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Videos</th>
                            <th>Total Mark</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($results as $key => $result)
                        @if (isset($result->assignments[0]))
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <th>{{ $result->user ? $result->user->first_name.' '.$result->user->last_name : '' }}</th>
                            <td>
                                @if (isset($result->assignments[0]))
                                    @foreach ($result->assignments as  $data)
                                        <video width="120" height="90" class="">
                                            <source src="{{ asset($data->video) }}" type="video/mp4">
                                        </video>
                                    @endforeach
                                @endif
                            </td>

                            <td>
                                {{ number_format($result->total_mark, 2) }} 
                                @if ($key == 0 && $result->total_mark > 0)
                                 <span class="text-success">1st</span>                                
                                @endif 
                                @if ($key == 1 && $result->total_mark > 0)
                                 <span class="text-info">2nd</span>                                
                                @endif 
                                @if ($key == 3 && $result->total_mark > 0)
                                 <span class="text-primary">3rd</span>                                
                                @endif 
                            </td>
                            
                        </tr>
                        @endif
                        
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Videos</th>
                            <th>Total Mark</th>
                        </tr>
                    </tfoot>
                </table>
            </div>


        </div>
        
        <hr>
        <h1>Reject Video List</h1>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Videos</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if ($rejected_videos->assignments[0]) --}}
                        @foreach ($rejected_videos as $key => $rejected)
                        {{-- <tr>
                            <td colspan="5" class="text-center">No Rjected Video Found!!</td>
                        </tr> --}}
                        @if (count($rejected->assignments) > 0)
                           
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rejected->user ? $rejected->user->first_name.' '.$rejected->user->last_name : '' }}</td>
                            <td>
                                @if (isset($rejected->assignments[0]))
                                    @foreach ($rejected->assignments as  $data)
                                        <video width="120" height="90" class="">
                                            <source src="{{ asset($data->video) }}" type="video/mp4">
                                        </video>
                                    @endforeach
                                @endif
                            </td>

                            <td>
                               Rejected 
                            </td>
                        </tr>
                      
                        @endif
                      
                        @endforeach
                          {{-- @endif --}}
                        {{-- @endif --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Videos</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <a href="{{route('managerAdmin.learningSession.evaluationResultPublished',$event->id)}}" class="btn btn-outline-success btn-success text-light"> Send To User</a>

        </div>


    </div>

</div>
@endsection