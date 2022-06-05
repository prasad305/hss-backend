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
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <th>{{ $result->user ? $result->user->first_name.' '.$result->user->last_name : '' }}</th>
                            <td>
                                @php $avg = 0; @endphp
                                @if (isset($result->assignments[0]))
                                    @foreach ($result->assignments as  $data)
                                        <video width="120" height="90" class="">
                                            <source src="{{ asset($data->video) }}" type="video/mp4">
                                        </video>
                                        @php $avg += $data->mark/$event->assignment_video_slot_number @endphp
                                    @endforeach
                                @endif
                            </td>

                            <td>
                                {{ number_format($result->total_mark, 2) }} 
                                @if ($key == 0)
                                 <span class="text-success">1st</span>                                
                                @endif 
                                @if ($key == 1)
                                 <span class="text-info">2nd</span>                                
                                @endif 
                                @if ($key == 3)
                                 <span class="text-primary">3rd</span>                                
                                @endif 
                            </td>
                        </tr>
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


    </div>

</div>
@endsection