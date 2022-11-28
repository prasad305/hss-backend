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
                    <h1 class="m-0">Live Chat Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('managerAdmin.dashboard.liveChat') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Live Chat</li>
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
                            <span class="info-box-text text-warning">Superstar</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($superstars as $star)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 text-center border border-warning">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                    aria-hidden="true"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ $star->star->first_name }}
                                    {{ $star->star->last_name }}</span>
                                <span class="info-box-number">
                                    <small><a class="text-warning"
                                            href="{{ route('managerAdmin.liveChatEvents.superstarEvents', $star->star->id) }}">See
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
