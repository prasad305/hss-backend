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
                                <th>Average Mark</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($assignmentUser as $assignments)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th>{{ $assignments[0]->user ? $assignments[0]->user->first_name.' '.$assignments[0]->user->last_name : '' }}</th>
                                <th>
                                    @php $avg = 0; @endphp
                                    @foreach ($assignments as $data)
                                        <video width="120" height="90" class="">
                                            <source src="{{ asset($data->video) }}" type="video/mp4">
                                        </video>
                                        @php $avg += $data->mark/$event->assignment_video_slot_number @endphp
                                    @endforeach
                                </th>

                                <th>{{ number_format($avg, 2) }}</th>

                            </tr>

                                {{-- @foreach ($assignments as $key => $assignment)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <th>{{ $assignment->user ? $assignment->user->first_name.' '.$assignment->user->last_name : '' }}</th>
                                        <th>Videos</th>
                                        <th>{{ $assignment->mark }}</th>
                                        <th>{{ $assignment->mark }}</th>

                                    </tr>
                                @endforeach --}}
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>User Name</th>
                                <th>Videos</th>
                                <th>Average Mark</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


            </div>


        </div>

    </div>
@endsection
