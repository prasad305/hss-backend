@extends('Layouts.ManagerAdmin.master')
@push('title')
    Manager Admin
@endpush

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Superstar Panel</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Superstar</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.superstarIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Superstar</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.superstarIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Superstar</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.superstarIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
@endsection
