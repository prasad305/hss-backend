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
                    <h1 class="m-0">Accounts</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Accounts</li>
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
                            <span class="info-box-text text-warning">All Events Daily Income</span>
                        </div>

                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Simple Post</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.simplePostDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Live Chat</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.liveChatDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Meetup Events</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.meetupDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Learning Session</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.learningSessionDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Greeting</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.greetingDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Audition</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.auditionDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Fan Group</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.fanGroupDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Q&A</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.qnaDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Star Showcase</span>
                        </div>

                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Market Place</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.marketplaceDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Souvenir</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.souvenirDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3 text-center">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Auction</span>
                            <span class="info-box-number">41,410</span>
                            <span class="info-box-number">
                                <small><a class="text-warning" href="{{ route('superAdmin.auctionDailyIncome') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div>
    </div> <!-- content -->
@endsection
