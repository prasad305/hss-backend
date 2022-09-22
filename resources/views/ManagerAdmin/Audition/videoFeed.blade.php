@extends('Layouts.ManagerAdmin.master')


@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 feed-title">
                    <h1 class="m-0">Video Feed</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Video Feed Round</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            @foreach ($auditions as $audition)
                
                <div class="card card-bg head-line mt-4 mb-2 ">
                    <div class="text-light  p-2 text-center">
                        <h4 class="mx-3 text-white p-2 feed-name ">{{ $audition->title }}</h4>
                    </div>
                </div>

                <div class="row">
                    @foreach ($audition->auditionRound as $key => $round)
                        <div class="col-12 col-sm-6 col-md-2">
                            <div class="info-box border border-warning">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-warning">Round Number</span>
                                    <span class="info-box-number text-center">
                                        <a href="{{ route('managerAdmin.audition.videoFeedList', $round->id) }}">
                                            <i class="fas fa-eye text-warning"> </i>
                                        </a>
                                        &nbsp;
                                        {{ $key + 1 }}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    @endforeach

                </div>
            @endforeach

        </div>



    </section>
@endsection
