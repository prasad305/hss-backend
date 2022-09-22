@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush



@section('content')
    <style>
        .head-line {
            border-top: 1px solid #ffad00 !important;
            border-left: 8px solid #ffad00 !important;
            border-bottom: 1px solid #ffad00 !important;
            border-right: 8px solid #ffad00 !important;
        }

        .card-bg {
            background-color: black;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-bg head-line mt-4 mb-2">
                <div class="text-light d-flex p-2">
                    <h4 class="mx-3 text-white p-2">User Vote Mark</h4>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
  
    <!-- /.content-header -->



    <div class="content">

        <div class="container-fluid">



            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Vote Mark Set</h3>
                    <a class="btn btn-success btn-sm" style="float: right;"
                        onclick="Show('Add Audition Vote Mark','{{ route('superAdmin.userVoteMark.create') }}')"><i
                            class=" fa fa-plus"></i>&nbsp;Add User Vote Mark</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th>Audition ID</th>
                                <th>Total React</th>
                                <th>User Vote Mark</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($instruction as $data)
                                <tr>
                                    <td>{{ $data->audition_id }}</td>
                                    <td>{{ $data->total_react }}</td>
                                    <td>{{ $data->user_mark }}</td>
                                    <td style="width: 150px">
                                        <a class="btn btn-sm btn-info"
                                            onclick="Show('Edit Mark','{{ route('superAdmin.userVoteMark.edit', $data->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                        <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                            value="{{ route('superAdmin.userVoteMark.destroy', $data->id) }}"><i
                                                class="fa fa-trash"></i> </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
@endsection
