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
                    <h1 class="m-0">Greeting Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('superAdmin.greetingEvents.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Greeting</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Manager Admin</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 text-center border border-warning">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                    aria-hidden="true"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Category : {{ $user->category->name }}</span>
                                <span class="info-box-text">{{ $user->first_name }}
                                    {{ $user->last_name }}</span>
                                <span class="info-box-number">{{ $user->category->greeting->count() }}</span>
                                <span class="info-box-number">
                                    <small><a class="text-warning"
                                            href="{{ route('superAdmin.greetingEvents.managerAdminEvents', $user->category->id) }}">See
                                            All</a></small>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
