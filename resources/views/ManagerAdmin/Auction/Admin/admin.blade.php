@extends('Layouts.ManagerAdmin.master')
@push('title')
    Manager Admin
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Auction Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('managerAdmin.dashboard.auction') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Auction</li>
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
                            <span class="info-box-text text-warning">Admin</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($admins as $admin)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 text-center border border-warning">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                    aria-hidden="true"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Admin</span>
                                <span class="info-box-number">
                                    {{ $admin->admin->first_name }} {{ $admin->admin->last_name }}
                                </span>
                                <span class="info-box-number">
                                    <small><a class="text-warning"
                                            href="{{ route('managerAdmin.auctionEvents.adminEvents', $admin->admin->id) }}">See
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