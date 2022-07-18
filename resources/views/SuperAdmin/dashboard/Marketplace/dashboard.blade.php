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
                    <h1 class="m-0">Marketplace Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Marketplace</li>
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
                            <span class="info-box-text text-warning">Categories</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">

                @foreach ($categories as $category)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 text-center border border-warning">
                            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                    aria-hidden="true"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ $category->name }}</span>
                                <span class="info-box-number">{{ $category->marketplace->count() }}</span>
                                <span class="info-box-number">
                                    <small><a class="text-warning"
                                            href="{{ route('superAdmin.marketplace.list', $category->id) }}">See
                                            All</a></small>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Events</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total</span>
                            <span class="info-box-number">{{ $total }}</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.marketplaceEvents.marketplaceDataList', 'total') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Unsold</span>
                            <span class="info-box-number">{{ $pending }}</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.marketplaceEvents.marketplaceDataList', 'unsold') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sold</span>
                            <span class="info-box-number">{{ $published }}</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.marketplaceEvents.marketplaceDataList', 'sold') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-list-alt"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Rejected</span>
                            <span class="info-box-number">{{ $rejected }}</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.marketplaceEvents.marketplaceDataList', 'rejected') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box text-center border border-warning">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-flag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Weekly Users</span>
                            <span class="info-box-number">
                                {{ $weeklyUser }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-map"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Monthly Users</span>
                            <span class="info-box-number">{{ $monthlyUser }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-map-location"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Yearly Users</span>
                            <span class="info-box-number">{{ $yearlyUser }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box text-center border border-warning">
                        <span class="info-box-icon bg-info elevation-1"><i
                                class="fa-solid fa-square-poll-vertical"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Weekly Income</span>
                            <span class="info-box-number">
                                {{ $weeklyIncome }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-danger elevation-1"><i
                                class="fa-solid fa-square-poll-vertical"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Monthly Income</span>
                            <span class="info-box-number">{{ $monthlyIncome }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Yearly Income</span>
                            <span class="info-box-number">{{ $yearlyIncome }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning">Admin & Superstars</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Manager Admin</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.marketplaceEvents.managerAdminList') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Superstar Admin</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.marketplaceEvents.adminList') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 text-center border border-warning">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"
                                aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Superstars</span>
                            <span class="info-box-number">
                                <small><a class="text-warning"
                                        href="{{ route('superAdmin.marketplaceEvents.superstarList') }}">See
                                        All</a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="info-box text-center">
                        <div class="info-box-content">
                            <span class="info-box-text text-warning"> Revenue </span>
                        </div>
                    </div>
                </div>
            </div>





            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <!-- BAR CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Monthly Income</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="barChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.col (RIGHT) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(function() {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.

            var labels = <?php echo $months; ?>;
            var data = <?php echo $amountCount; ?>;


            var areaChartData = {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data
                }, ]
            }


            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })


        })
    </script>

    <script src="{{ asset('assets/super-admin/plugins/flot/jquery.flot.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('assets/super-admin/plugins/flot/plugins/jquery.flot.resize.js ') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/flot/plugins/jquery.flot.hover.js ') }}"></script>
    <script src="{{ asset('assets/super-admin/plugins/chart.js/Chart.min.js') }}"></script>
@endpush
