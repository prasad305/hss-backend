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
                            <span class="info-box-text text-warning">Panel</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Admin</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.accountsAdminList') }}">See
                                More</a>
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
                            </span><a class="text-warning" href={{ route('managerAdmin.accountsSuperstarList') }}>See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Audition Admin</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href={{ route('managerAdmin.accountsAuditionAdminList') }}>See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Total Income</span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Simple Post</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.simplePostTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Live Chat</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.liveChatTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Meetup</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.meetupTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Greeting</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.greetingTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Audition</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auditionTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Learning Session</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.learningSessionTotalIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Fan Group</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.fanGroupTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Q&A</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.qnaTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Auction</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auctionTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Marketplace</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.marketplaceTotalIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Souvenir</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.souvenirTotalIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Daily Income</span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Simple Post</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.simplePostDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Live Chat</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.liveChatDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Meetup</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.meetupDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Greeting</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.greetingDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Audition</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auditionDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Learning Session</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.learningSessionDailyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Fan Group</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.fanGroupDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Q&A</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.qnaDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Auction</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auctionDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Marketplace</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.marketplaceDailyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Souvenir</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.souvenirDailyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Weekly Income</span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Simple Post</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.simplePostWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Live Chat</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.liveChatWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Meetup</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.meetupWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Greeting</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.greetingWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Audition</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auditionWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Learning Session</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.learningSessionWeeklyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Fan Group</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.fanGroupWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Q&A</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.qnaWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Auction</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auctionWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Marketplace</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.marketplaceWeeklyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Souvenir</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.souvenirWeeklyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <!-- /.content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Monthly Income</span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Simple Post</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.simplePostMonthlyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Live Chat</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.liveChatMonthlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Meetup</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.meetupMonthlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Greeting</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.greetingMonthlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Audition</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auditionMonthlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Learning Session</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.learningSessionMonthlyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Fan Group</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.fanGroupMonthlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Q&A</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.qnaMonthlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Auction</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auctionMonthlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Marketplace</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.marketplaceMonthlyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Souvenir</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.souvenirMonthlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Yearly Income</span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Simple Post</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.simplePostYearlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Live Chat</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.liveChatYearlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Meetup</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.meetupYearlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Greeting</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.greetingYearlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Audition</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auditionYearlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Learning Session</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.learningSessionYearlyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Fan Group</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.fanGroupYearlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Q&A</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.qnaYearlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Auction</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.auctionYearlyIncome') }}">See
                                More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Marketplace</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning"
                                href="{{ route('managerAdmin.marketplaceYearlyIncome') }}">See More</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Souvenir</span>
                            <span class="info-box-number">
                                1200
                            </span><a class="text-warning" href="{{ route('managerAdmin.souvenirYearlyIncome') }}">See
                                More</a>
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
