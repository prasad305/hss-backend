@extends('Layouts.SuperAdmin.master')

@push('title')
    Super Admin
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Audition</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Audition List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Assign Person</th>
                                <th>Judge</th>
                                <th>Audition Admin</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($auditions as $audition)
                                <tr>
                                    <td>{{ $audition->title }}</td>
                                    <td>
                                        {{ $audition->category->name ?? '-' }}
                                    </td>

                                    <td>
                                        @foreach ($audition->admin as $admin)
                                            {{ $admin->admin->first_name . ' ' . $admin->admin->last_name }} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($audition->assignedJudges as $judges)
                                            {{ $judges->user->first_name . ' ' . $judges->user->last_name }} <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $audition->auditionAdmin->first_name . ' ' . $audition->auditionAdmin->last_name }}
                                    </td>
                                    <td>
                                        {{ $audition->created_at->diffForHumans() }}
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
