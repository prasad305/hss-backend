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
                <h1 class="m-0">Creat Audition Rules</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- <a href="{{ route('superAdmin.events.edit',1) }}"> <li class="breadcrumb-item active">Events
                        List</li></a> --}}
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"> Audition Rules List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<style>
    .AddC {
        border-top: 1px solid gold !important;
    }
    .cards{
        border: 1px solid #FFD910 !important;
    }
    .Buths{
        margin-top: 25px;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="col-md-2 ">
            <div class="card cards AddC border-warning">
                <center>
                    <img src="{{ asset('assets/super-admin/images/CreateNewAuditionsrules.png') }}"
                        style="width: 60px; " class=" pt-4" alt="">
                </center>
                <button class="btn text-white border-warning Buths"> <a href="{{ route('superAdmin.audition-rules.create') }}"
                        class="" style="color:
                        #8CF9FF">Create New Audition Rules</a></button>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ongoing Events list</h3>
                {{-- <a class="btn btn-success btn-sm" style="float: right;"
                        onclick="Show('New Audition','{{ route('superAdmin.events.create') }}')"><i
                    class=" fa fa-plus"></i>&nbsp;New Audition</a> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Rules ID</th>
                            <th>Envet Name</th>
                            <th>Rounds</th>
                            <th>SuperStar</th>
                            <th>Jury</th>
                            <th>Schedule</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($rules as $rule)
                        <tr>
                            <td>{{ $loop->iteration }}  </td>
                            <td>{{ $rule->id }}  </td>
                            <td>{{ $rule->category ? $rule->category->name : '' }}  Audition</td>
                            <td> Rounds Number {{ $rule->round_num }} </td>
                            <td>Super Star {{ $rule->judge_num }}</td>
                            <td>Jury {{ $rule->jury_num }}</td>
                            <td>Time: {{ $rule->month }} Month {{ $rule->day }} Days</td>
                            <td style="width: 150px">
                                <a href="{{ route('superAdmin.audition-rules.edit',$rule->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit text-white"></i></a>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button>
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
