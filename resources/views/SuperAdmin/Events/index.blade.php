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
                    <h1 class="m-0">Events</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Events List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<style>
    .AddC{
        border-color:1px solid gold !important;
    }
</style>
    <div class="content">
        <div class="container-fluid">
                <div class="col-md-2 ">
                    <div class="card AddC border-warning">
                        <center>
                            <img src="{{ asset('assets/super-admin/images/CreateNewAuditionsrules.png') }}" style="width: 45px; " class="py-3" alt="">
                        </center>
                       <button class="btn text-white border-warning">  <a href="{{ route('superAdmin.events.create') }}" class="text-light">Create New Audition Rules</a></button>
                    </div>
                </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable with default features</h3>
                    {{-- <a class="btn btn-success btn-sm" style="float: right;"
                        onclick="Show('New Audition','{{ route('superAdmin.events.create') }}')"><i
                            class=" fa fa-plus"></i>&nbsp;New Audition</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Envet Name</th>
                                <th>Rounds</th>
                                <th>SuperStar</th>
                                <th>Jury</th>
                                <th>Schedule</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @foreach ($auditions as $audition)
                                <tr>
                                    <td>{{ $audition->title }}</td>
                                    <td>
                                        {{ $audition->category->name ?? '-' }}
                                    </td>
                                    <td>{{ $audition->assignAdmin ? $audition->assignAdmin->assignPerson->first_name : '' }}</td>
                                    <td>
                                        {{ $audition->created_at->diffForHumans() }}
                                    </td>
                                    <td style="width: 150px">
                                        <a class="btn btn-sm btn-info"
                                            onclick="Show('Edit Audition','{{ route('superAdmin.audition.edit', $audition->id) }}')"><i
                                                class="fa fa-edit text-white"></i></a>
                                        <button class="btn btn-sm btn-danger" onclick="delete_function(this)"
                                            value="{{ route('superAdmin.audition.destroy', $audition) }}"><i
                                                class="fa fa-trash"></i> </button>
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
@endsection
