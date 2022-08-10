@extends('Layouts.ManagerAdmin.master')


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Video Feed</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Video Feed List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box border border-warning">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-warning">Round Number</span>
                            <span class="info-box-number text-center">
                                <a href="#">
                                    <i class="fas fa-eye text-warning"> </i>
                                </a>

                                &nbsp;
                                1
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        </div>



    </section>
@endsection
