@extends('Layouts.SuperAdmin.master')


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-size: 25px; color: #fff3b4; font-weight: 600;">Dashboard</h1>
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
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Users</span>
                            <span class="info-box-number">
                                {{ $userCount }}
                            </span>
                            <a href="{{ route('superAdmin.allUser') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Manager Admins</span>
                            <span class="info-box-number">{{ $managerAdminCount }}</span>
                            <a href="{{ route('superAdmin.managerAdmin.index') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Superstars</span>
                            <span class="info-box-number">{{ $starCount }}</span>
                            <a href="{{ route('superAdmin.allStar') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Admins</span>
                            <span class="info-box-number">{{ $adminCount }}</span>
                            <a href="{{ route('superAdmin.allAdmin') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-edit"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Categories</span>
                            <span class="info-box-number">
                                {{ $categoryCount }}
                            </span>
                            <a href="{{ route('superAdmin.category.index') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-plus-square"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total SubCategories</span>
                            <span class="info-box-number">{{ $subCategoryCount }}</span>
                            <a href="{{ route('superAdmin.subCategory.index') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-flag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Countries</span>
                            <span class="info-box-number">{{ $countryCount }}</span>
                            <a href="{{ route('superAdmin.country.index') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-flag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total States</span>
                            <span class="info-box-number">{{ $stateCount }}</span>
                            <a href="{{ route('superAdmin.state.index') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-map-signs""></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Cities</span>
                            <span class="info-box-number">
                                {{ $cityCount }}
                            </span>
                            <a href="{{ route('superAdmin.city.index') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-th"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Interest Types</span>
                            <span class="info-box-number">{{ $interestTypeCount }}</span>
                            <a href="{{ route('superAdmin.interest-type.index') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i
                                class="fa-brands fa-product-hunt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Marketplace Products</span>
                            <span class="info-box-number">{{ $marketplaceCount }}</span>
                            <a href="{{ route('superAdmin.allMarketplace') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fa-brands fa-product-hunt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Auction Products</span>
                            <span class="info-box-number">{{ $auctionCount }}</span>
                            <a href="{{ route('superAdmin.allAuction') }}">
                                <span class="info-box-number" style="color: #3aa733;"><i class="fa fa-eye"></i> View
                                    all</span>
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>


            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <h5 class="card-header" style="font-size: 20px; color: gold; font-weight: 600;">User Visitor Count
                        </h5>
                        <div class="panel-body">
                            <canvas id="canvas" height="280" width="600"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <h5 class="card-header" style="font-size: 20px; color: gold; font-weight: 600;">Payment History
                        </h5>
                        <div class="panel-body">
                            {{-- <canvas id="canvas" height="280" width="600"></canvas> --}}
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning">
                                        <h5 class="description-header">${{ $totalLearningAmount }}</h5>
                                        <span class="description-text">Learning Session</span><br>
                                        {{-- <a href="{{ route('superAdmin.learningSessions') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning">

                                        <h5 class="description-header">${{ $totalMeetUpAmount }}</h5>
                                        <span class="description-text">Meetup Events</span><br>
                                        {{-- <a href="{{ route('superAdmin.meetupEvents') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning text-warning">

                                        <h5 class="description-header">${{ $totalAuditionAmount }}</h5>
                                        <span class="description-text">Auditions</span><br>
                                        {{-- <a href="{{ route('superAdmin.auditions') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block text-warning">

                                        <h5 class="description-header">${{ $totalLiveChatAmount }}</h5>
                                        <span class="description-text">Live Chat</span><br>
                                        {{-- <a href="{{ route('superAdmin.liveChats') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning">
                                        <h5 class="description-header">$35,210.43</h5>
                                        <span class="description-text">Fan Group</span><br>
                                        {{-- <a href="{{ route('superAdmin.fanGroup') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning">

                                        <h5 class="description-header">${{ $totalGreetingAmount }}</h5>
                                        <span class="description-text">Greetings</span><br>
                                        {{-- <a href="{{ route('superAdmin.greetings') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning">
                                        <h5 class="description-header">${{ $totalPostAmount }}</h5>
                                        <span class="description-text">User Posts</span><br>
                                        {{-- <a href="{{ route('superAdmin.userPosts') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block text-warning">

                                        <h5 class="description-header">$1200</h5>
                                        <span class="description-text">Wallet</span><br>
                                        {{-- <a href="{{ route('superAdmin.wallets') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning">
                                        <h5 class="description-header">${{ $totalSouvenirAmount }}</h5>
                                        <span class="description-text">Souvenir</span><br>
                                        {{-- <a href="#">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning">

                                        <h5 class="description-header">${{ $totalMarketplaceAmount }}</h5>
                                        <span class="description-text">Marketplace</span><br>
                                        {{-- <a href="{{ route('superAdmin.greetings') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right text-warning">
                                        <h5 class="description-header">${{ $totalPostAmount }}</h5>
                                        <span class="description-text">Auction</span><br>
                                        {{-- <a href="{{ route('superAdmin.userPosts') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block text-warning">

                                        <h5 class="description-header">${{ $totalQnaAmount }}</h5>
                                        <span class="description-text">QnA</span><br>
                                        {{-- <a href="{{ route('superAdmin.wallets') }}">
                                            <span class="description-percentage text-success"><i class="fas fa-eye"></i>
                                                view </span>
                                        </a> --}}
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>



                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>






        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Payment',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: ['2017', '1158', '2019', '20', '586', '2022', '2417', '1158', '2019', '20', '586', '222'],
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };
    </script>

    <script>
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>

    <script>
        var year = <?php echo $year; ?>;
        var user = <?php echo $user; ?>;
        var barChartData = {
            labels: year,
            datasets: [{
                label: 'User',
                backgroundColor: "#faebd736",
                data: user
            }]
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'line',
                data: barChartData,
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderColor: '#gold',
                            borderSkipped: 'bottom'
                        }
                    },
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Yearly Visitor Count'
                    }
                }
            });
        };
    </script>
@endsection
